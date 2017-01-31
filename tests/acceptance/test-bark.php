<?php
/**
 * Acceptance tests for barking errors.
 *
 * @package Bark
 */

class BarkTest extends WP_UnitTestCase {
	public function setUp() {
		parent::setUp();
		bark_add_default_levels();
	}

	/**
	 * @test
	 */
	public function barkActionAddsEntryToDatabaseAsBarkPostType() {
		$message = 'Something went wrong!';

		do_action( 'bark', array(
			'level' => 'error',
			'title' => '',
			'content' => $message,
			'context' => array(),
		) );

		$barks = new WP_Query( array(
			'post_type' => 'cdv8_bark',
		) );

		$this->assertNotEmpty( $barks->posts, 'Could not find any barks in database.' );
		$this->assertEquals( $message, $barks->posts[0]->post_content, 'Found a bark in the database, but its title did not match what was expected.' );
	}
}
