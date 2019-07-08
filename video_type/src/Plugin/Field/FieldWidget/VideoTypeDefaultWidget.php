<?php
namespace Drupal\video_type\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'VideoTypeDefaultWidget' widget.
 *
 * @FieldWidget(
 *   id = "VideoTypeDefaultWidget",
 *   label = @Translation("Video Type Default Widget"),
 *   description = @Translation("Video Type Default Widget"),
 *   field_types = {
 *     "video_widget",
 *   }
 * )
 */
//*   multiple_values = TRUE <- Intuitively this should be in the annotation, but it acts opposite of what is expected,


class VideoTypeDefaultWidget extends WidgetBase
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
    )
    {
        $lang = \Drupal::languageManager()->getCurrentLanguage()->getId();

        // Comment out the following lines if the instance fieldsets should not be collapsible
        $element['#type'] = 'details';
        $element['#open'] = true;

        $element['video_title'] = [
            '#type' => 'textfield',
            '#title' => t('Video Title'),
            '#default_value' => isset($items[$delta]->video_title) ? $items[$delta]->video_title : NULL,
            '#size' => 60,
        ];

        $element['video_description'] = [
            '#type' => 'textarea',
            '#title' => t('Video Description'),
            '#default_value' => isset($items[$delta]->video_description) ? $items[$delta]->video_description : NULL,
            '#size' => 60,
        ];

        $element['video_length'] = [
            '#type' => 'textfield',
            '#title' => t('Video Length'),
            '#default_value' => isset($items[$delta]->video_length) ? $items[$delta]->video_length : NULL,
            '#placeholder' => t('h:mm:ss'),
            '#size' => 8,
            '#element_validate' => array(
                array($this, 'validate_length'),
            ),
        ];

        $element['youtube_url'] = [
            '#type' => 'url',
            '#title' => t('YouTube URL'),
            '#default_value' => isset($items[$delta]->youtube_url) ? $items[$delta]->youtube_url : NULL,
            '#size' => 60,
        ];

        if (in_array($lang, [ 'en', 'und' ])) {
            $element['caption_file_en'] = [
                '#type' => 'managed_file',
                '#title' => t('English Caption File'),
                '#multiple' => false,
                '#description' => t('The caption file type must be .vtt format.'),
                '#default_value' => isset($items[$delta]->caption_file_en) ? [$items[$delta]->caption_file_en] : NULL,
                '#upload_location' => 'public://videos/vtt_captions/',
                '#upload_validators' => [
                    'file_validate_extensions' => ['vtt'],
                ],
            ];
        }

        if ($lang == 'es') {
            $element['caption_file_es'] = [
                '#type' => 'managed_file',
                '#title' => t('Spanish Caption File'),
                '#multiple' => false,
                '#description' => t('The caption file type must be .vtt format.'),
                '#default_value' => isset($items[$delta]->caption_file_es) ? [$items[$delta]->caption_file_es] : NULL,
                '#upload_location' => 'public://videos/vtt_captions/',
                '#upload_validators' => [
                    'file_validate_extensions' => ['vtt'],
                ],
            ];
        }

        return $element;
    }

    /**
     * @inheritdoc
     */
    public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {

        foreach ($values as $delta => $value) {
            if (isset($value['caption_file_en']) && is_array($value['caption_file_en'])) {
                $values[$delta]['caption_file_en'] = $value['caption_file_en'][0];
            }
            if (isset($value['caption_file_es']) && is_array($value['caption_file_es'])) {
                $values[$delta]['caption_file_es'] = $value['caption_file_es'][0];
            }
        }

        return parent::massageFormValues($values, $form, $form_state);
    }

    public static function validate_length($element, FormStateInterface $form_state) {
        $value = $element['#value'];
        if (strlen($value) == 0) {
            $form_state->setValueForElement($element, '');
            return;
        }
        if (!preg_match('/^([\d]{1,2}\:)?([\d]{1,2})?\:([\d]{2})$/', $value)) {
            $form_state->setError($element, t("Length, if specified, must be of the format h:mm:ss, mm:ss or m:ss."));
        }
    }


}