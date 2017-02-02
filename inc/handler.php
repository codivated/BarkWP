<?php
/**
 * Catch errors and bark them out.
 *
 * @package bark
 */

/**
 * Catch generic PHP errors and bark them.
 *
 * @param $errno
 * @param $errstr
 * @param $errfile
 * @param $errline
 *
 * @return bool
 */
function bark_catch_php_errors( $errno, $errstr, $errfile, $errline ) {
	if ( ! ( error_reporting() & $errno ) ) {
		return false;
	}

	$bark_details = array(
		'content' => $errstr,
		'context' => array(
			'file' => $errfile,
			'line' => $errline,
		),
	);

	switch ( $errno ) {
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
set_error_handler( 'bark_catch_php_errors', E_ALL );
