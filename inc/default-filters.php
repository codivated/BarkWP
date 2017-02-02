<?php
/**
 * Apply default actions to Bark filters.
 *
 * @package bark
 */

function bark_prevent_log_if_limit_reached( $should_log ) {
	$limit = get_option( 'bark-limit-logs', 500 );
	$barks = bark_get_total();

	if ( (int) $limit <= (int) $barks ) {
		$should_log = false;
	}

	return $should_log;
}
add_filter( 'bark_should_log', 'bark_prevent_log_if_limit_reached' );
