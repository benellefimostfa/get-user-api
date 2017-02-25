<?php

namespace Drupal\amazee_test\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the amazee_test module.
 */
class StargazersApiControllerTest extends WebTestBase {

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "amazee_test StargazersApiController's controller functionality",
      'description' => 'Test Unit for module amazee_test and controller StargazersApiController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests amazee_test functionality.
   */
  public function testStargazersApiController() {
    // Check that the basic functions of module amazee_test.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
