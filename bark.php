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
require_once __DIR__ . '/inc/activation.php';
require_once __DIR__ . '/inc/class-bark.php';

/**
 * Handle adding bark entry when `bark` action is called.
 *
 * @param array $details Bark details.
 */
function bark_add_entry( $details ) {
	$bark = new \Bark\Bark();
	$bark->log( $details['level'], $details['content'], $details['context'] );
}
add_action( 'bark', 'bark_add_entry' );
