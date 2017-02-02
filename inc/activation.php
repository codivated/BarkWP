<?php
/**
 * Functionality that runs on plugin activation.
 *
 * @package bark
 */

/**
 * Add the default levels to the level taxonomy.
 */
function bark_add_default_levels() {
	wp_create_term( 'emergency', 'bark-level' );
	wp_create_term( 'critical', 'bark-level' );
	wp_create_term( 'alert', 'bark-level' );
	wp_create_term( 'error', 'bark-level' );
	wp_create_term( 'warning', 'bark-level' );
	wp_create_term( 'notice', 'bark-level' );
	wp_create_term( 'info', 'bark-level' );
	wp_create_term( 'debug', 'bark-level' );
}

function bark_add_default_settings() {
	update_option( 'bark-limit-logs', 500 );
}
