<?php

namespace Drupal\amazee_test;

/**
 * Class GithubUserService.
 *
 * @package Drupal\amazee_test
 */
class GithubUserService {

  /**
   * Constructor.
   */
  public function getUser() {
    // Get User account from form.
    $config = \Drupal::config('amazee_test.githubaccount');
    $account = $config->get('user_login');

    // Get account datas from github.
    $client = \Drupal::httpClient();
    $request = $client->get('https://api.github.com/users/' . $account);
    $content = $request->getBody()->getContents();
    $content = json_decode($content);

    return $content;
  }

}
