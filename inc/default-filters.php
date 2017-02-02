<?php
/**
 * Apply default actions to Bark filters.
 *
 * @package bark
 */

/**
 * Handle adding an entry when `bark` action is called.
 *
 * @param array $details Bark_Logger details.
 */
function bark_add_entry( $details ) {
	$bark = new Bark_Logger();
	if ( empty( $details['context'] ) ) {
		$details['context'] = array();
	}

	$bark->log( $details['level'], $details['message'], (array) $details['context'] );
}
add_action( 'bark', 'bark_add_entry' );

function bark_prevent_log_if_limit_reached( $should_log ) {
	$limit = get_option( 'bark-limit-logs', 500 );
	$barks = bark_get_total();

	if ( (int) $limit <= (int) $barks ) {
		$should_log = false;
	}

	return $should_log;
}
add_filter( 'bark_should_log', 'bark_prevent_log_if_limit_reached' );
