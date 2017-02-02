<?php
/**
 * Plugin Name: Bark
 * Version: 0.1
 * Description: Supercharged WordPress error logging and reporting utility.
 * Author: Codivated
 * Author URI: https://www.codivated.com/
 * Text Domain: bark
 * Domain Path: languages
 * License: GPL
 *
 * @package bark
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/inc/post-types.php';
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/default-filters.php';
require_once __DIR__ . '/inc/activation.php';
require_once __DIR__ . '/inc/bark-admin-options.php';
require_once __DIR__ . '/inc/class-bark-logger.php';

function bark_handle_plugin_activation() {
	bark_register_levels();
	bark_add_default_levels();
	bark_add_default_settings();
}
register_activation_hook( __FILE__, 'bark_handle_plugin_activation' );

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

	$bark->log( $details['level'], $details['content'], (array) $details['context'] );
}
add_action( 'bark', 'bark_add_entry' );

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
