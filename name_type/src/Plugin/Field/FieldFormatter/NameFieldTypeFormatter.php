<?php
namespace Drupal\name_type\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'NameFieldTypeFormatter' formatter.
 *
 * @FieldFormatter(
 *   id = "NameFieldTypeFormatter",
 *   label = @Translation("Name field type formatter"),
 *   field_types = {
 *     "name_widget"
 *   }
 * )
 */
class NameFieldTypeFormatter extends FormatterBase {

    public function viewElements(FieldItemListInterface $items, $langcode) {
        $elements = [];

        foreach ($items as $delta => $item) {
            // Render each element as markup.
            $elements[$delta] = [
                '#theme' => 'name_widget',
                '#name_prefix' => $item->name_prefix,
                '#name_first' => "$item->name_first",
                '#name_middle' => "$item->name_middle",
                '#name_last' => "$item->name_last",
                '#name_maternal_last' => "$item->name_maternal_last",
                '#name_suffix' => "$item->name_suffix",
                '#name_full' => "$item->name_full",
                '#name_preferred' => "$item->name_preferred",
            ];
        }

        return $elements;
    }

} // class