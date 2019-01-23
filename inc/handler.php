<?php
/**
 * Catch errors and bark them out.
 *
 * @package bark
 */

function bark_catch_php_shutdowns() {
	$error = error_get_last();
	if ( empty( $error ) ) {
		return;
	}

	$bark_details = array(
		'message' => $error['message'],
		'context' => array(),
	);

	switch ( $error['type'] ) {
		case E_ERROR:
			$bark_details['level'] = 'critical';
			break;
		case E_RECOVERABLE_ERROR:
		case E_USER_ERROR:
		case E_CORE_ERROR:
			$bark_details['level'] = 'error';
			break;
		case E_USER_WARNING:
		case E_WARNING:
		case E_CORE_WARNING:
		case E_COMPILE_WARNING:
			$bark_details['level'] = 'warning';
			break;
		case E_USER_NOTICE:
		case E_NOTICE:
			$bark_details['level'] = 'notice';
			break;
		default:
			$bark_details['level'] = 'log';
			break;
	}

	do_action( 'bark', $bark_details['message'], $bark_details['level'], $bark_details['context'], $error );
	return false;
}
register_shutdown_function( 'bark_catch_php_shutdowns' );
