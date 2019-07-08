<?php
namespace Drupal\video_type\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\file\Entity\File;
use Drupal\file\Plugin\Field\FieldType\FileItem;


/**
 * @FieldType(
 *   id = "video_type",
 *   module = "video_type",
 *   label = @Translation("Video"),
 *   description = @Translation("This field stores video meta information."),
 *   default_widget = "VideoTypeDefaultWidget",
 *   default_formatter = "VideoTypeDefaultFormatter",
 * )
 */

class VideoTypeField extends FieldItemBase {
    /**
     * {@inheritdoc}
     */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

        $properties = [];

        $properties['video_title'] = DataDefinition::create('string')
            ->setLabel(t('Video Title'))
            ->setDescription(t('Optional title to be displayed instead of the node title.'));

        $properties['video_description'] = DataDefinition::create('string')
            ->setLabel(t('Video Description'))
            ->setDescription(t('Description to be displayed for the video.'));

        $properties['video_length'] = DataDefinition::create('string')
            ->setLabel(t('Video Length'))
            ->setDescription(t('The duration of the video, in hours:minutes:seconds.'));

        $properties['youtube_url'] = DataDefinition::create('string')
            ->setLabel(t('Video YouTube URL'))
            ->setDescription(t('The YouTube URL at which the video can be referenced.'));

        $properties['caption_file_en'] = DataDefinition::create('integer')
            ->setLabel(t('English Caption File'))
            ->setDescription(t('The Video Track Text file providing video captions.'));

        $properties['caption_file_es'] = DataDefinition::create('integer')
            ->setLabel(t('Spanish Caption File'))
            ->setDescription(t('The Video Track Text file providing video captions.'));

        return $properties;
    }

    /**
     * {@inheritdoc}
     */
    public static function schema(FieldStorageDefinitionInterface $field_definition) {
        $columns = array(
            'video_title' => array(
                'description' => 'Optional title to be displayed instead of the node title.',
                'type' => 'varchar',
                'length' => 255,
            ),
            'video_description' => array(
                'description' => 'Description to be displayed for the video.',
                'type' => 'varchar',
                'length' => 255,
            ),
            'video_length' => array(
                'description' => 'The duration of the video, in hours:minutes:seconds.',
                'type' => 'varchar',
                'length' => 8,
            ),
            'youtube_url' => array(
                'description' => 'The URL at which the video can be referenced on YouTube.',
                'type' => 'varchar',
                'length' => 255,
            ),
            'caption_file_en' => array(
                'description' => 'The Video Track Text file providing video captions.',
                'type' => 'int',
            ),
            'caption_file_es' => array(
                'description' => 'The Video Track Text file providing video captions.',
                'type' => 'int',
            ),
        );

        $schema = array(
            'columns' => $columns,
            'indexes' => [],
            //'foreign keys' => array(),
        );

        return $schema;
    }

    /**
     * Define when the field type is empty.
     */
    public function isEmpty() {

        // The field will not be considered empty if the youtube url, mp4 url or mpe audio file properties has a value
        return empty($this->values['youtube_url']);
    }

// Uncomment the following and bring it up to date if the field is to be used as an entity base field
/*     public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
        // Some fields above.
        
        $fields['video'] = BaseFieldDefinition::create('video')
        ->setLabel(t('Video'))
        ->setDescription(t('Specify meta data for a video.'))
        ->setCardinality(-1); // Ensures that you can have more than just one member
        
        return $fields;
    }
 */    
}
