<?php
/**
 * Acceptance tests for barking errors.
 *
 * @package Bark
 */

class BarkTest extends WP_UnitTestCase {
	/**
	 * @test
	 */
	function barkActionAddsEntryToDatabaseAsBarkPostType() {
		$title = 'Something went wrong!';

		do_action( 'bark', array(
			'type' => 'error',
			'title' => $title,
		) );

		$barks = new WP_Query( array(
			'post_type' => 'cdv8_bark',
		) );

		$this->assertNotEmpty( $barks->posts );
		$this->assertEquals( $title, $barks->posts[0]->post_title );
	}
}
