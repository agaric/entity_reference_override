<?php

namespace Drupal\entity_reference_override\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceLabelFormatter;

/**
 * Plugin implementation of the 'entity_reference_override_label' formatter.
 *
 * @FieldFormatter(
 *   id = "entity_reference_override_label",
 *   label = @Translation("Label"),
 *   description = @Translation("Display the label of the referenced entities with or a custom title."),
 *   field_types = {
 *     "entity_reference_override"
 *   }
 * )
 */
class EntityReferenceOverrideLabelFormatter extends EntityReferenceLabelFormatter {

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);
    $values = $items->getValue();

    foreach ($elements as $delta => $entity) {
      if (!empty($values[$delta]['override'])) {
        $elements[$delta]['#label'] = $values[$delta]['override'];
      }
    }

    return $elements;
  }
}
