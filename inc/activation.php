<?php
/**
 * Functionality that runs on plugin activation.
 *
 * @package bark
 */

use Psr\Log\LogLevel;

/**
 * Add the default levels to the level taxonomy.
 */
function bark_add_default_levels() {
	wp_create_term( LogLevel::EMERGENCY, 'bark-level' );
	wp_create_term( LogLevel::CRITICAL, 'bark-level' );
	wp_create_term( LogLevel::ALERT, 'bark-level' );
	wp_create_term( LogLevel::ERROR, 'bark-level' );
	wp_create_term( LogLevel::WARNING, 'bark-level' );
	wp_create_term( LogLevel::NOTICE, 'bark-level' );
	wp_create_term( LogLevel::INFO, 'bark-level' );
	wp_create_term( LogLevel::DEBUG, 'bark-level' );
}
