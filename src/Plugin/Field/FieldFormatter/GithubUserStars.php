<?php

namespace Drupal\amazee_test\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'github_user_repo_type' formatter.
 *
 * @FieldFormatter(
 *   id = "github_user_repo_type",
 *   label = @Translation("Github user stars"),
 *   field_types = {
 *     "github_user"
 *   }
 * )
 */
class GithubUserStars extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    // Implement default settings.
    return array() + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    // Implement settings form.
    return array() + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    $account = $item->account;
    $repo = $item->repo;
    // Get account datas from github.
    $client = \Drupal::httpClient();
    $request = $client->get('https://api.github.com/repos/'
      . $account . '/' . $repo);
    $content = $request->getBody()->getContents();
    $content = json_decode($content);
    $stars = $content->stargazers_count;
    // Render Results.
    $markup = $this->t('@account got @stars stars on the @repo repo',
      array(
        '@account' => $account,
        '@stars' => $stars,
        '@repo' => $repo,
      ));
    return $markup;
  }

}
