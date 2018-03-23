<?php

namespace Drupal\entity_reference_override\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'entity_reference_override_entity' formatter.
 *
 * @FieldFormatter(
 *   id = "entity_reference_override_entity",
 *   label = @Translation("Rendered entity"),
 *   description = @Translation("Display the referenced entities rendered by entity_view(), with optional field overrides."),
 *   field_types = {
 *     "entity_reference_override"
 *   }
 * )
 */
class EntityReferenceOverrideEntityFormatter extends EntityReferenceEntityFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'override_action' => 'title',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $target_entity_type = $this->getFieldSetting('target_type');
    $target_bundle = array_pop($this->getFieldSetting('handler_settings')['target_bundles']);

    $bundle_fields = array_keys(\Drupal::service('entity_field.manager')->getFieldDefinitions($target_entity_type, $target_bundle));
    // To consider: Doing the same for 'text' fields.
    $string_fields = array_keys(\Drupal::service('entity_field.manager')->getFieldMapByFieldType('string')[$target_entity_type]);
    $overridable_fields = array_intersect($string_fields, $bundle_fields);

    $field_options = [];
    foreach ($overridable_fields as $overridable_field) {
      $field_options[$overridable_field] = $this::friendlyField($overridable_field);
    }

    $elements = parent::settingsForm($form, $form_state);
    $elements['override_action'] = [
      '#type' => 'select',
      '#options' => [
        'title' => t('Entity title'),
        'class' => t('Link class'),
      ] + $field_options,
      '#title' => t('Use custom text to override'),
      '#default_value' => $this->getSetting('override_action'),
      '#required' => TRUE,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();

    $override_action = $this->getSetting('override_action');
    switch ($override_action) {
      case 'title':
        $override = t('title');
        break;

      case 'class':
        $override = t('CSS class');
        break;

      case 'display':
        $override = t('display mode');
        break;

      default:
        $override = t('@override field', ['@override' => $this::friendlyField($override_action)]);
        break;
    }
    $summary[] = t('Per-entity @override override', ['@override' => $override]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $view_mode = $this->getSetting('view_mode');
    $elements = [];

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      // Due to render caching and delayed calls, the viewElements() method
      // will be called later in the rendering process through a '#pre_render'
      // callback, so we need to generate a counter that takes into account
      // all the relevant information about this field and the referenced
      // entity that is being rendered.
      $recursive_render_id = $items->getFieldDefinition()->getTargetEntityTypeId()
        . $items->getFieldDefinition()->getTargetBundle()
        . $items->getName()
        // We include the referencing entity, so we can render default images
        // without hitting recursive protections.
        . $items->getEntity()->id()
        . $entity->getEntityTypeId()
        . $entity->id();

      if (isset(static::$recursiveRenderDepth[$recursive_render_id])) {
        static::$recursiveRenderDepth[$recursive_render_id]++;
      }
      else {
        static::$recursiveRenderDepth[$recursive_render_id] = 1;
      }

      // Protect ourselves from recursive rendering.
      if (static::$recursiveRenderDepth[$recursive_render_id] > static::RECURSIVE_RENDER_LIMIT) {
        $this->loggerFactory->get('entity')->error('Recursive rendering detected when rendering entity %entity_type: %entity_id, using the %field_name field on the %bundle_name bundle. Aborting rendering.', [
          '%entity_type' => $entity->getEntityTypeId(),
          '%entity_id' => $entity->id(),
          '%field_name' => $items->getName(),
          '%bundle_name' => $items->getFieldDefinition()->getTargetBundle(),
        ]);
        return $elements;
      }

      $clone = clone $entity;

      if (strlen($items[$delta]->override)) {
        $override = $this->getSetting('override_action');
        switch ($override) {
          case 'class':
            $override_class = $items[$delta]->override;
            break;

          case 'display':
            $view_mode = $items[$delta]->override;
            break;

          default:
            $clone->set($override, $items[$delta]->override);
            break;
        }
      }

      $view_builder = $this->entityTypeManager->getViewBuilder($entity->getEntityTypeId());
      $elements[$delta] = $view_builder->view($clone, $view_mode, $entity->language()->getId());

      if (!empty($items[$delta]->override)) {
        $elements[$delta]['#cache']['keys'][] = md5($items[$delta]->override);
      }

      if (!empty($override_class)) {
        $elements[$delta]['class'][] = $override_class;
      }

      // Add a resource attribute to set the mapping property's value to the
      // entity's url. Since we don't know what the markup of the entity will
      // be, we shouldn't rely on it for structured data such as RDFa.
      if (!empty($items[$delta]->_attributes) && !$entity->isNew() && $entity->hasLinkTemplate('canonical')) {
        $items[$delta]->_attributes += ['resource' => $entity->toUrl()->toString()];
      }
    }

    return $elements;
  }

  /**
   * Provide a human-readable version of a field machine name.
   */
  public static function friendlyField($string) {
    return str_replace(['field_', '_'], ['', ' '], $string);
  }

}
