<?php

namespace Drupal\entity_reference_override\Plugin\Field\FieldWidget;

trait OverrideTextWidgetTrait {

  /**
   * Provides a widget for the custom text field used by content editors.
   */
  public function overrideTextWidget(&$widget, $items, $delta) {
    $widget['override'] = [
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]) ? $items[$delta]->override : '',
      '#maxlength' => 4094,
      '#size' => 40,
      '#weight' => 10,
    ];

    $format = $this->fieldDefinition->getSetting('override_format');
    if ($format) {
      $widget['override']['#type'] = 'text_format';
      $widget['override']['#format'] = $format;
      $widget['override']['#allowed_formats'] = [$format];
      $widget['override']['#rows'] = 2;
    }

    // This (using this) in a trait must be breaking some PHP OOP rule that i
    // haven't read yet...  but it works, and we know precisely the context
    // in which this trait is used.
    if ($this->fieldDefinition->getFieldStorageDefinition()->isMultiple()) {
      $widget['override']['#placeholder'] = $this->fieldDefinition->getSetting('override_label');
    }
    else {
      $widget['override']['#title'] = $this->fieldDefinition->getSetting('override_label');
    }
  }
}
