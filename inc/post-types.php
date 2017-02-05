<?php
/**
 * Post types & taxonomies for Bark_Logger.
 *
 * @package bark
 */

/**
 * Register bark levels.
 */
function bark_register_levels() {
	register_taxonomy( 'bark-level', 'cdv8_bark', array(
		'label'              => __( 'Levels', 'bark' ),
		'hierarchical'       => true,
		'publicly_queryable' => true,
		'show_ui'            => false,
	) );
}
add_action( 'init', 'bark_register_levels', 5 ); // 5 is needed so taxonomy exists during mu-plugin.

/**
 * Setup Bark_Logger post types.
 */
function bark_setup_post_type() {
	$labels = array(
		'name'                  => _x( 'Bark', 'Post type general name', 'bark' ),
		'singular_name'         => _x( 'Bark', 'Post type singular name', 'bark' ),
		'menu_name'             => _x( 'Bark', 'Admin Menu text', 'bark' ),
		'name_admin_bar'        => _x( 'Bark', 'Add New on Toolbar', 'bark' ),
		'add_new'               => __( 'Add New', 'bark' ),
		'add_new_item'          => __( 'Add New Bark', 'bark' ),
		'new_item'              => __( 'New Bark', 'bark' ),
		'edit_item'             => __( 'Edit Bark', 'bark' ),
		'view_item'             => __( 'View Bark', 'bark' ),
		'all_items'             => __( 'All Barks', 'bark' ),
		'search_items'          => __( 'Search Barks', 'bark' ),
		'parent_item_colon'     => __( 'Parent Barks:', 'bark' ),
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
		'menu_icon'          => plugin_dir_url( dirname( __FILE__ ) ) . '/assets/bark-icon.png',
		'supports'           => array( 'title' ),
	);

	register_post_type( 'cdv8_bark', $args );
}
add_action( 'init', 'bark_setup_post_type' );
