<?php
/**
 * Acceptance tests for things that happen during plugin activation.
 *
 * @package bark
 */

class PluginActivationTest extends WP_UnitTestCase {
	public function setUp() {
		parent::setUp();
		bark_handle_plugin_activation();
	}

	/**
	 * @test
	 */
	public function barkPostTypeShouldExist() {
		$this->assertTrue( post_type_exists( 'cdv8_bark' ) );
	}

	/**
	 * @test
	 */
	public function barkLevelTaxonomyShouldExist() {
		$this->assertTrue( taxonomy_exists( 'bark-level' ) );
	}

	/**
	 * @test
	 */
	public function pluginActivationFunctionCorrectlyAddsDefaultBarkLevels() {
		$term_query = new WP_Term_Query( array(
			'taxonomy' => 'bark-level',
			'hide_empty' => false,
		) );
		$terms = $term_query->get_terms();

		$this->assertCount( 8, $terms );
		$this->assertNotFalse( get_term_by( 'slug', 'emergency', 'bark-level' ) );
		$this->assertNotFalse( get_term_by( 'slug', 'critical', 'bark-level' ) );
		$this->assertNotFalse( get_term_by( 'slug', 'alert', 'bark-level' ) );
		$this->assertNotFalse( get_term_by( 'slug', 'error', 'bark-level' ) );
		$this->assertNotFalse( get_term_by( 'slug', 'warning', 'bark-level' ) );
		$this->assertNotFalse( get_term_by( 'slug', 'notice', 'bark-level' ) );
		$this->assertNotFalse( get_term_by( 'slug', 'info', 'bark-level' ) );
		$this->assertNotFalse( get_term_by( 'slug', 'debug', 'bark-level' ) );
	}

	/**
	 * @test
	 */
	public function pluginActivateSetsDefaultBarkLimit_logs() {
		$limit = get_option( 'bark-limit-logs' );
		$this->assertNotEmpty( $limit );
	}
}
