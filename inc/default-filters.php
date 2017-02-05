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
	global $wp;

	$details = wp_parse_args( $details, array(
		'level' => 'debug',
		'message' => '',
		'context' => array(),
	) );

	$details['context']['wp'] = $wp;
	$details['context']['globals'] = array(
		'$_GET' => empty( $_GET ) ?  '' : $_GET,
		'$_POST' => empty( $_POST ) ? '' : $_POST,
		'$_SESSION' => empty( $_SESSION ) ? '' : $_SESSION,
	);

	$details = apply_filters( 'bark_details', $details );

	do_action( 'bark_before_insert', $details );
	$bark = new Bark_Logger();
	$bark_id = $bark->log( $details['message'], $details['level'], (array) $details['context'] );
	do_action( 'bark_after_insert', $bark_id );
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
