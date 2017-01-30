<?php
/**
 * Functionality that runs on plugin activation.
 *
 * @package bark
 */

namespace Bark;
use Psr\Log\LogLevel;

/**
 * Install Bark.
 */
function activation() {
	register_bark_level();
	add_bark_levels();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\\activation' );

/**
 * Add the default levels to the level taxonomy.
 */
function add_bark_levels() {
	wp_create_term( LogLevel::EMERGENCY, 'bark-level' );
	wp_create_term( LogLevel::CRITICAL, 'bark-level' );
	wp_create_term( LogLevel::ALERT, 'bark-level' );
	wp_create_term( LogLevel::ERROR, 'bark-level' );
	wp_create_term( LogLevel::WARNING, 'bark-level' );
	wp_create_term( LogLevel::NOTICE, 'bark-level' );
	wp_create_term( LogLevel::INFO, 'bark-level' );
	wp_create_term( LogLevel::DEBUG, 'bark-level' );
}
