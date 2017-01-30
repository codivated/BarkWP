<?php
/**
 * Primary Bark class.
 *
 * @package bark
 */

namespace Bark;

/**
 * Handles functionality related to handling barked errors.
 *
 * @package Bark
 */
class Bark {
	/**
	 * Register hooks for the bark class.
	 */
	public function register_hooks() {
		add_action( 'bark', array( $this, 'log' ) );
	}

	/**
	 * Handler for logging a bark.
	 *
	 * @param array $details Info about the bark.
	 */
	public function log( $details ) {
		$entry = wp_insert_post( array(
			'post_type' => 'cdv8_bark',
			'post_title' => $details['title'],
			'post_status' => 'publish',
		) );
	}
}
