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
		'publicly_queryable' => false,
		'show_ui'            => false,
	) );
}
add_action( 'init', 'bark_register_levels' );

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
		'supports'           => array( 'title', 'editor', 'author' ),
	);

	register_post_type( 'cdv8_bark', $args );
}
add_action( 'init', 'bark_setup_post_type' );

function bark_admin_column_content( $column_name, $post_id ) {
	$post = get_post( $post_id );
	$decoded = json_decode( $post->post_content );
	$context = $decoded->context;

	$levels = wp_get_post_terms( $post_id, 'bark-level' );

	if ( 'bark_file' === $column_name ) {
		$file_message = __( 'File not provided.', 'bark' );
		if ( ! empty( $context->file ) ) {
			$file_message = $context->file;
		}

		echo esc_html( $file_message );
	}

	if ( 'bark_line' === $column_name ) {
		$line_message = __( 'Line not provided.', 'bark' );
		if ( ! empty( $context->line ) ) {
			$line_message = $context->line;
		}

		echo esc_html( $line_message );
	}

	if ( 'bark_level' === $column_name ) {
		echo $levels[0]->name;
	}
}
add_action( 'manage_cdv8_bark_posts_custom_column', 'bark_admin_column_content', 10, 2 );

function bark_set_admin_column_order() {
	return array(
		'cb' => '<input type="checkbox" />',
		'bark_level' => __( 'Level', 'bark' ),
		'title' => __( 'Message', 'bark' ),
		'bark_file' => __( 'File', 'bark' ),
		'bark_line' => __( 'Line', 'bark' ),
		'date' => __( 'Logged', 'bark' ),
	);
}
add_filter( 'manage_cdv8_bark_posts_columns' , 'bark_set_admin_column_order' );
