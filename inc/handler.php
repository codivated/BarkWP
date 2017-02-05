<?php
/**
 * Catch errors and bark them out.
 *
 * @package bark
 */

function bark_catch_generic_php_errors( $error_number, $error_message, $error_file, $error_line ) {
	if ( ! ( error_reporting() & $error_number ) ) {
		return false;
	}

	$bark_details = array(
		'message' => $error_message,
		'context' => array(
			'file' => $error_file,
			'line' => $error_line,
		),
	);

	switch ( $error_number ) {
		case E_USER_ERROR:
		case E_ERROR:
			$bark_details['level'] = 'error';
			break;
		case E_USER_WARNING:
		case E_WARNING:
			$bark_details['level'] = 'warning';
			break;
		case E_USER_NOTICE:
		case E_NOTICE:
		default:
			$bark_details['level'] = 'notice';
			break;
	}

	do_action( 'bark', $bark_details );
	return false; // Allow PHP to continue and log this error as it normally would.
}
set_error_handler( 'bark_catch_generic_php_errors', E_ALL );

function bark_catch_php_shutdowns() {
	$error = error_get_last();

	if ( empty( $error ) ) {
		return;
	}

	$bark_details = array(
		'message' => $error['message'],
		'context' => array(
			'file' => $error['file'],
			'line' => $error['line'],
		),
	);

	switch ( $error['type'] ) {
		case E_RECOVERABLE_ERROR:
			$bark_details['level'] = 'error';
			break;
		case E_COMPILE_WARNING:
			$bark_details['level'] = 'alert';
			break;
		default:
			$bark_details['level'] = 'error';
			break;
	}

	do_action( 'bark', $bark_details );
	return false;
}
register_shutdown_function( 'bark_catch_php_shutdowns' );
