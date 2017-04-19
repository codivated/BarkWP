<?php
/**
 * Base class to extend for Bark_Logger tests.
 *
 * @package bark
 */

class BarkTestCase extends WP_UnitTestCase {
	public function setUp() {
		parent::setUp();
		$this->bark = new Bark_Logger();
	}

	public function addDefaultLevels() {
		bark_add_default_levels();
	}

	/**
	 * @return int Post ID.
	 */
	public function createBark( $details = array() ) {
		$details = wp_parse_args( array(
			'post_type' => 'cdv8_bark',
			'post_content' => 'Test bark content.',
			'post_status' => 'publish'
		), $details );

		return $this->factory->post->create( $details );
	}
}
