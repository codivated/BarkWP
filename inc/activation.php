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
function install() {
	add_default_levels();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\\install' );

/**
 * Add the default levels to the level taxonomy.
 */
function add_default_levels() {
	wp_create_term( LogLevel::EMERGENCY, 'bark-level' );
	wp_create_term( LogLevel::CRITICAL, 'bark-level' );
	wp_create_term( LogLevel::ALERT, 'bark-level' );
	wp_create_term( LogLevel::ERROR, 'bark-level' );
	wp_create_term( LogLevel::WARNING, 'bark-level' );
	wp_create_term( LogLevel::NOTICE, 'bark-level' );
	wp_create_term( LogLevel::INFO, 'bark-level' );
	wp_create_term( LogLevel::DEBUG, 'bark-level' );
}


/**
 * Setup Bark post types.
 */
function setup_post_type() {
	$labels = array(
		'name'                  => _x( 'Bark Entries', 'Post type general name', 'bark' ),
		'singular_name'         => _x( 'Bark Entry', 'Post type singular name', 'bark' ),
		'menu_name'             => _x( 'Bark Entries', 'Admin Menu text', 'bark' ),
		'name_admin_bar'        => _x( 'Bark Entry', 'Add New on Toolbar', 'bark' ),
		'add_new'               => __( 'Add New', 'bark' ),
		'add_new_item'          => __( 'Add New Bark Entry', 'bark' ),
		'new_item'              => __( 'New Bark Entry', 'bark' ),
		'edit_item'             => __( 'Edit Bark Entry', 'bark' ),
		'view_item'             => __( 'View Bark Entry', 'bark' ),
		'all_items'             => __( 'All Bark Entries', 'bark' ),
		'search_items'          => __( 'Search Bark Entries', 'bark' ),
		'parent_item_colon'     => __( 'Parent Bark Entries:', 'bark' ),
		'not_found'             => __( 'No barks found.', 'bark' ),
		'not_found_in_trash'    => __( 'No barks found in Trash.', 'bark' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'bark' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'excerpt' ),
	);

	register_post_type( 'cdv8_bark', $args );
}
add_action( 'init', __NAMESPACE__ . '\\setup_post_type' );

/**
 * Register taxonomy for Lumberjack.
 */
function register_bark_type() {
	register_taxonomy( 'bark-level', 'cdv8_bark', array(
		'label'              => __( 'Types', 'bark' ),
		'hierarchical'       => true,
		'publicly_queryable' => false,
	) );
}
add_action( 'init', __NAMESPACE__ . '\\register_bark_type' );
