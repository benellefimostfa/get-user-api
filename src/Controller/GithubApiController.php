<?php

namespace Drupal\amazee_test\Controller;

use Drupal\amazee_test\GithubApiService;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GithubApiController.
 *
 * @package Drupal\amazee_test\Controller
 */
class GithubApiController extends ControllerBase {
  /**
   * @var GithubApiService
   */
  private $githubApi;

  /**
   * GithubApiController constructor.
   *
   * @param \Drupal\amazee_test\GithubApiService $githubApi
   */
  public function __construct(GithubApiService $githubApi) {

    $this->githubApi = $githubApi;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @return static
   */
  public static function create(ContainerInterface $container) {

    $githubApi = $container->get('github_api');

    return new static($githubApi);
  }

  /**
   * @return array
   */
  public function getUser() {

    $content = $this->githubApi->getUser();

    return array(
      '#theme' => 'github_user',
      '#content' => $content,
    );
  }

  /**
   * @return array
   */
  public function getIssues($language) {
    // Convert object to array.
    $content = (array) $this->githubApi->getIssues($language);
    // Get first 10 items.
    $items = array_slice($content['items'], 0, 10, TRUE);

    return array(
      '#theme' => 'github_issues',
      '#items' => $items,
    );
  }

  /**
   * @return array
   */
  public function getRepos($language) {
    // Convert object to array.
    $content = (array) $this->githubApi->getRepos($language);
    // Get first 10 items.
    $items = array_slice($content['items'], 0, 10, TRUE);

    return array(
      '#theme' => 'github_repos',
      '#items' => $items,
    );
  }

  /**
   * @return array
   */
  public function getProjects() {
    // Convert object to array.
    $content = (array) $this->githubApi->getRepos('all');
    // Get first 10 items.
    $items = array_slice($content['items'], 0, 10, TRUE);
    $currencies = $this->getCurrencies();

    return array(
      '#theme' => 'github_projects',
      '#items' => $items,
      '#currencies' => $currencies,
    );
  }

  /**
   * @return \Drupal\Core\Config\Config
   */
  public function getCurrencies() {
    $url =
      'http://www.apilayer.net/api/live?access_key=8ac159821a62e58b7ef1a670063a0f95';

    $content = (array) $this->githubApi->getRequest($url);
    $content = (array) $content['quotes'];
    $currencies['GBP'] = $content['USDGBP'];
    $currencies['EUR'] = $content['USDEUR'];
    $currencies['CHF'] = $content['USDCHF'];
    return $currencies;
  }
}
