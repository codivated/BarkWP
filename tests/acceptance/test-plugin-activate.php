<?php
/**
 * Acceptance tests for things that happen during plugin activation.
 *
 * @package bark
 */

class PluginActivationTest extends WP_UnitTestCase {
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
		bark_handle_adding_default_levels();
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
}
