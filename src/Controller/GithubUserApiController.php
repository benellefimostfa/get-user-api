<?php

namespace Drupal\amazee_test\Controller;

use Drupal\amazee_test\GithubUserService;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GithubUserApiController.
 *
 * @package Drupal\amazee_test\Controller
 */
class GithubUserApiController extends ControllerBase {
  /**
   * @var GithubUserService
   */
  private $githubUser;

  /**
   * GithubUserApiController constructor.
   *
   * @param \Drupal\amazee_test\GithubUserService $githubUser
   */
  public function __construct(GithubUserService $githubUser) {

    $this->githubUser = $githubUser;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @return static
   */
  public static function create(ContainerInterface $container) {

    $githubUser = $container->get('github_user');

    return new static($githubUser);
  }

  /**
   * @return array
   */
  public function getUser() {

    $content = $this->githubUser->getUser();

    return array(
      '#theme' => 'github_user',
      '#content' => $content,
    );
  }

}
