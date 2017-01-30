<?php
/**
 * Acceptance tests for things that happen during plugin activation.
 *
 * @package Bark
 */

class PluginActivationTest extends WP_UnitTestCase {
	/**
	 * @test
	 */
	function barkPostTypeShouldExist() {
		$this->assertTrue( post_type_exists( 'cdv8_bark' ) );
	}

	/**
	 * @test
	 */
	function barkLevelTaxonomyShouldExist() {
		$this->assertTrue( taxonomy_exists( 'bark-level' ) );
	}
}
