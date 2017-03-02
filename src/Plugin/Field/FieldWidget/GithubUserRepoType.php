<?php

namespace Drupal\amazee_test\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'github_user_repo_type' widget.
 *
 * @FieldWidget(
 *   id = "github_user_repo_type",
 *   label = @Translation("Github user repo type"),
 *   field_types = {
 *     "github_user"
 *   }
 * )
 */
class GithubUserRepoType extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'size' => 60,
      'placeholder' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['size'] = array(
      '#type' => 'number',
      '#title' => t('Size of textfield'),
      '#default_value' => $this->getSetting('size'),
      '#required' => TRUE,
      '#min' => 1,
    );
    $elements['placeholder'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = t('Textfield size: !size', array('!size' => $this->getSetting('size')));
    if (!empty($this->getSetting('placeholder'))) {
      $summary[] = t('Placeholder: @placeholder', array('@placeholder' => $this->getSetting('placeholder')));
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = [];

    $element['account'] = array(
      '#type' => 'textfield',
      '#title' => t('Account'),
      '#default_value' => isset($items[$delta]->account) ? $items[$delta]->account : 'bryangruneberg',
      '#size' => $this->getSetting('Account'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#maxlength' => $this->getFieldSetting('max_length'),
      '#description' => t('example: bryangruneberg'),

    );

    $element['repo'] = array(
      '#type' => 'textfield',
      '#title' => t('Repository'),
      '#default_value' => isset($items[$delta]->repo) ? $items[$delta]->repo : 'ambient_sms_gateway',
      '#size' => $this->getSetting('Repo'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#maxlength' => $this->getFieldSetting('max_length'),
      '#description' => t('example: ambient_sms_gateway'),

    );
    return $element;
  }

}
