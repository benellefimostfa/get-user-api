<?php

namespace Drupal\amazee_test\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\amazee_test\GithubUserService;

/**
 * Provides a 'GithubAccountBlock' block.
 *
 * @Block(
 *  id = "github_account_block",
 *  admin_label = @Translation("Github account block"),
 * )
 */
class GithubAccountBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\amazee_test\GithubUserService definition.
   *
   * @var Drupal\amazee_test\GithubUserService
   */
  protected $githubUser;

  /**
   * Construct.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    GithubUserService $githubUser
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->githubUser = $githubUser;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('github_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $content = $this->githubUser->getUser();
    return array(
      'github_account_block' =>
        array(
          '#theme' => 'github_user',
          '#content' => $content,
        ),
    );

  }

}
