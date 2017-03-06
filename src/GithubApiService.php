<?php

namespace Drupal\amazee_test;

/**
 * Class GithubApiService.
 *
 * @package Drupal\amazee_test
 */
class GithubApiService {

  /**
   * @return mixed|string
   */
  public function getUser() {
    // Get User account from form.
    $config = \Drupal::config('amazee_test.githubaccount');
    $account = $config->get('user_login');
    $url = 'https://api.github.com/users/' . $account;
    $content = $this->getRequest($url);

    return $content;
  }

  /**
   * @return mixed|string
   */
  public function getIssues($language) {
    $query = $this->getQuery('issue', $language, 'comments');
    $url = $this->getUrl('issues');
    $options = ['query' => $query];
    $content = $this->getRequest($url, $options);
    return $content;
  }

  /**
   * @return mixed|string
   */
  public function getRepos($language) {
    $query = $this->getQuery('repository', $language, 'stars');
    $url = $this->getUrl('repositories');
    $options = ['query' => $query];
    $content = $this->getRequest($url, $options);
    return $content;
  }

  /**
   * Get account data from Github.
   *
   * @param $url
   * @param null $options
   *
   * @return mixed|string
   */
  protected function getRequest($url, $options = NULL) {
    $client = \Drupal::httpClient();
    $request = $client->get($url, $options);
    $content = $request->getBody()->getContents();
    $content = json_decode($content);
    return $content;

  }

  /**
   * @param $type
   * @param $language
   * @param $sort
   * @return string
   */
  protected function getQuery($type, $language, $sort) {
    $weekback = date('Y-m-d', strtotime('-1 week'));
    $query =
      'q=is:' . $type . '
      +language:' . $language . '
      +sort:' . $sort .
      '+created:>=' . $weekback;
    return $query;
  }

  /**
   * @param $type
   * @return string
   */
  protected function getUrl($type) {
    $url = 'https://api.github.com/search/' . $type;
    return $url;
  }

}
