<?php
namespace Drupal\video_type\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'VideoTypeDefaultFormatter' formatter.
 *
 * @FieldFormatter(
 *   id = "VideoTypeDefaultFormatter",
 *   label = @Translation("Video Field Type"),
 *   field_types = {
 *     "video"
 *   }
 * )
 */
class VideoTypeDefaultFormatter extends FormatterBase {

    public function viewElements(FieldItemListInterface $items, $langcode) {
        $element = [];

        foreach ($items as $delta => $item) {

            $element[$delta] = [
                '#type' => 'markup',
                '#markup' => "$item->video_title",
                '#video_title' => "$item->video_title",
                '#video_description' => "$item->video_description",
                '#video_length' => "$item->video_length",
                '#youtube_url' => "$item->youtube_url",
                '#theme' => "video_type",
                '#delta' => "$delta",
            ];

            if (isset($item->{'caption_file_' . $langcode})) {
                $element[$delta]['#caption_file'] = $item->{'caption_file_' . $langcode};
            }
        }

        return $element;
    }

}