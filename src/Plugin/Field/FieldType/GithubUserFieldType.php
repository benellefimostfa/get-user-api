<?php

namespace Drupal\amazee_test\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'github_user' field type.
 *
 * @FieldType(
 *   id = "github_user",
 *   label = @Translation("Github user"),
 *   description = @Translation("Github user login and repo"),
 *   default_widget = "github_user_repo_type",
 *   default_formatter = "github_user_repo_type"
 * )
 */
class GithubUserFieldType extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return array(
      'max_length' => 255,
      'case_sensitive' => FALSE,
    ) + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['account'] = DataDefinition::create('string')
      ->setLabel(t('Account'))
      ->setDescription(t('Account'));

    $properties['repo'] = DataDefinition::create('string')
      ->setLabel(t('Repo'))
      ->setDescription(t('Repo'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = array(
      'columns' => array(
        'account' => array(
          'type' => 'textfield',
          'length' => (int) $field_definition->getSetting('max_length'),
        ),
        'repo' => array(
          'type' => 'textfield',
          'length' => (int) $field_definition->getSetting('max_length'),
        ),
      ),
    );

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $random = new Random();
    $values['account'] = $random->word(mt_rand(1, $field_definition->getSetting('max_length')));
    $values['repo'] = $random->word(mt_rand(1, $field_definition->getSetting('max_length')));
    return $values;
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $elements = [];

    $elements['max_length'] = array(
      '#type' => 'number',
      '#title' => t('Maximum length'),
      '#default_value' => $this->getSetting('max_length'),
      '#required' => TRUE,
      '#description' => t('The maximum length of the field in characters.'),
      '#min' => 1,
      '#disabled' => $has_data,
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $account = $this->get('account')->getValue();

    return $account === NULL || $account === '';
  }

}
