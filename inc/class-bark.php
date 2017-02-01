<?php
/**
 * Primary Bark class.
 *
 * @package bark
 */

namespace Bark;
use Psr\Log\AbstractLogger;

/**
 * Handles functionality related to handling barked errors.
 *
 * @package Bark
 */
class Bark extends AbstractLogger {
	/**
	 * Log an entry.
	 *
	 * @param string $level   Level of the bark.
	 * @param string $message Message for the entry.
	 * @param string $context Additional information about the entry.
	 */
	public function log( $level = 'error', $message, array $context = array() ) {
		$entry = wp_insert_post( array(
			'post_type' => 'cdv8_bark',
			'post_title' => '',
			'post_content' => $message,
			'post_status' => 'publish',
		) );
	}

	/**
	 * Assign specified level to a bark entry.
	 *
	 * @param string $level_slug The slug for the level you want to assign.
	 * @param int    $bark_id    The ID of the bark you want the level assigned to.
	 */
	public function assign_level_to_bark( $level_slug, $bark_id ) {
		$level = get_term_by( 'slug', $level_slug, 'bark-level' );
		if ( false === $level ) {
			return false;
		}

		return wp_set_post_terms( $bark_id, $level->term_id, 'bark-level' );
	}
}