<?php
namespace Drupal\name_type\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'NameFieldTypeWidget' widget.
 *
 * @FieldWidget(
 *   id = "NameFieldTypeWidget",
 *   label = @Translation("Name Field Type Widget"),
 *   description = @Translation("Name Field Type Widget"),
 *   field_types = {
 *     "name_widget",
 *   }
 * )
 */
//*   multiple_values = TRUE <- Intuitively this should be in the annotation, but it acts opposite of what is expected,


class NameFieldTypeWidget extends WidgetBase
{
    /**
     * {@inheritdoc}
     */
    public function formElement(
        FieldItemListInterface $items,
        $delta,
        array $element,
        array &$form,
        FormStateInterface $form_state
    ) {

      $prefixes = [
        '' => '',
        'Mr' => 'Mr',
        'Mrs' => 'Mrs',
        'Ms' => 'Ms',
      ];
      $suffixes = [
        '' => '',
        'Jr' => 'Jr',
        'Sr' => 'Sr',
        'II' => 'II',
        'III' => 'III',
        'IV' => 'IV',
      ];
      $element['name_prefix'] = [
        '#type' => 'select',
        '#options' => $prefixes,
        '#title' => t('Prefix'),
        '#default_value' => isset($items->name_prefix) ? $items->name_prefix : NULL,
      ];

      $element['name_first'] = [
        '#type' => 'textfield',
        '#title' => t('First'),
        '#default_value' => isset($items->name_first) ? $items->name_first : NULL,
        '#size' => 16,
      ];

      $element['name_middle'] = [
        '#type' => 'textfield',
        '#title' => t('Middle'),
        '#default_value' => isset($items->name_middle) ? $items->name_middle : NULL,
        '#size' => 16,
      ];

      $element['name_last'] = [
        '#type' => 'textfield',
        '#title' => t('Last'),
        '#default_value' => isset($items->name_last) ? $items->name_last : NULL,
        '#size' => 32,
      ];

      $element['name_maternal_last'] = [
        '#type' => 'textfield',
        '#title' => t('Maternal Last'),
        '#default_value' => isset($items->name_maternal_last) ? $items->name_maternal_last : NULL,
        '#size' => 32,
      ];

      $element['name_suffix'] = [
        '#type' => 'select',
        '#title' => t('Suffix'),
        '#options' => $suffixes,
        '#default_value' => isset($items->name_suffix) ? $items->name_suffix : NULL,
      ];

      $element['name_full'] = [
        '#type' => 'textfield',
        '#title' => t('Full'),
        '#default_value' => isset($items->name_full) ? $items->name_full : NULL,
        '#size' => 64,
      ];

      $element['name_preferred'] = [
        '#type' => 'textfield',
        '#title' => t('Preferred'),
        '#default_value' => isset($items->name_preferred) ? $items->name_preferred : NULL,
        '#size' => 32,
      ];


        return $element;
    }
}

