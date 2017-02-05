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
require_once __DIR__ . '/inc/admin-screens.php';
require_once __DIR__ . '/inc/meta-boxes.php';
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/default-filters.php';
require_once __DIR__ . '/inc/handler.php';
require_once __DIR__ . '/inc/activation.php';
require_once __DIR__ . '/inc/bark-admin-options.php';
require_once __DIR__ . '/inc/class-bark-logger.php';

function bark_handle_plugin_activation() {
	bark_register_levels();
	bark_add_default_levels();
	bark_add_default_settings();
}
register_activation_hook( __FILE__, 'bark_handle_plugin_activation' );

function bark_admin_css() {
	wp_enqueue_style( 'bark-admin-css', plugin_dir_url( __FILE__ ) . '/assets/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'bark_admin_css' );
