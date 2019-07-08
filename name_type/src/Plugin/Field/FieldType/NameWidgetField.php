<?php
namespace Drupal\name_type\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\file\Entity\File;
use Drupal\file\Plugin\Field\FieldType\FileItem;


/**
 * @FieldType(
 *   id = "name_widget",
 *   module = "name",
 *   label = @Translation("Name"),
 *   description = @Translation("This field stores name information."),
 *   default_widget = "NameFieldTypeWidget",
 *   default_formatter = "NameFieldTypeFormatter",
 * )
 */

class NameWidgetField extends FieldItemBase {
    /**
     * {@inheritdoc}
     */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

        $properties = [];

        $properties['name_prefix'] = DataDefinition::create('string')
            ->setLabel(t('Prefix'))
            ->setDescription(t('Appears before the name, eg Mr, Ms.'));

        $properties['name_first'] = DataDefinition::create('string')
            ->setLabel(t('First'))
            ->setDescription(t('First/given name.'));

        $properties['name_middle'] = DataDefinition::create('string')
            ->setLabel(t('Middle'))
            ->setDescription(t('Middle name(s) or initial(s).'));

        $properties['name_last'] = DataDefinition::create('string')
            ->setLabel(t('Last'))
            ->setDescription(t('Last name, family name, surname.'));

        $properties['name_maternal_last'] = DataDefinition::create('string')
            ->setLabel(t('Second last'))
            ->setDescription(t('Maternal/Second last name.'));

        $properties['name_suffix'] = DataDefinition::create('string')
            ->setLabel(t('Suffix'))
            ->setDescription(t('Following the name, eg Jr, MD.'));

        $properties['name_full'] = DataDefinition::create('string')
            ->setLabel(t('Full'))
            ->setDescription(t('Full written name in the appropriate order.'));

        $properties['name_preferred'] = DataDefinition::create('string')
            ->setLabel(t('Preferred'))
            ->setDescription(t('Preferred name, nickname.'));

        return $properties;
    }

    /**
     * {@inheritdoc}
     */
    public static function schema(FieldStorageDefinitionInterface $field_definition) {
        $columns = array(
            'name_prefix' => array(
                'type' => 'varchar',
                'length' => 16,
            ),
            'name_first' => array(
                'type' => 'varchar',
                'length' => 32,
            ),
            'name_middle' => array(
                'type' => 'varchar',
                'length' => 32,
            ),
            'name_last' => array(
                'type' => 'varchar',
                'length' => 32,
            ),
            'name_maternal_last' => array(
                'type' => 'varchar',
                'length' => 32,
            ),
            'name_suffix' => array(
                'type' => 'varchar',
                'length' => 16,
            ),
            'name_full' => array(
                'type' => 'varchar',
                'length' => 255,
            ),
            'name_preferred' => array(
                'type' => 'varchar',
                'length' => 32,
            ),
        );

        $schema = array(
            'columns' => $columns,
            'indexes' => [],
        );

        return $schema;
    }

    /**
     * Define when the field type is empty.
     */
    public function isEmpty() {

        // The field will not be considered empty if the youtube url, mp4 url or mpe audio file properties has a value
        return empty($this->values['name_last']) &&
               empty($this->values['name_first']);
    }

// Uncomment the following and bring it up to date if the field is to be used as an entity base field
/*     public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
        // Some fields above.
        
        return $fields;
    }
 */    
}
