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
	public function log( $level, $message, array $context = array() ) {
		$entry = wp_insert_post( array(
			'post_type' => 'cdv8_bark',
			'post_title' => '',
			'post_content' => $message,
			'post_status' => 'publish',
		) );
	}
}
