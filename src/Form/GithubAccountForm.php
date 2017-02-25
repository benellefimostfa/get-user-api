<?php

namespace Drupal\amazee_test\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class GithubAccountForm.
 *
 * @package Drupal\amazee_test\Form
 */
class GithubAccountForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'amazee_test.githubaccount',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'github_account_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('amazee_test.githubaccount');
    $form['user_login'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('User login'),
      '#description' => $this->t('The use login example: benellefimostfa'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('user_login'),
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('amazee_test.githubaccount')
      ->set('user_login', $form_state->getValue('user_login'))
      ->save();
  }

}
