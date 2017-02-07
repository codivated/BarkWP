<?php
/**
 * Adjustments to admin related screens for Bark.
 *
 * Includes admin column changes, new filters showing on post listing page, etc.
 *
 * @package bark
 */

function bark_admin_assets() {
	$screen = get_current_screen();

	$assets_url = plugin_dir_url( dirname( __FILE__ ) );
	wp_enqueue_style( 'bark-admin-css', $assets_url . '/assets/admin.css' );

	if ( 'edit-cdv8_bark' === $screen->id ) {
	    wp_enqueue_script( 'bark-admin-js', $assets_url . '/assets/admin.js', array( 'jquery' ) );
	}
}
add_action( 'admin_enqueue_scripts', 'bark_admin_assets' );

function bark_admin_js() {
}
add_action( 'admin_enqueue_scripts', 'bark_admin_js' );

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
		$level = __( 'Level not provided.', 'bark' );
		if ( ! empty( $levels[0]->name ) ) {
			$level = $levels[0]->name;
		}

		echo esc_html( $level );
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

function bark_admin_display_level_filter() {
	if ( isset( $_GET['post_type'] ) ) {
		$type = sanitize_text_field( wp_unslash( $_GET['post_type'] ) );
	}

	if ( empty( $type ) || 'cdv8_bark' !== $type ) {
		return;
	}

	$levels = get_terms( array(
		'taxonomy' => 'bark-level',
		'hide_empty' => false,
	) );

	?><select name="filter-bark-level">
		<option value=""><?php esc_html_e( 'Filter Level ', 'bark' ); ?></option>
		<?php
		$current_level_filter = isset( $_GET['filter-bark-level'] ) ? $_GET['filter-bark-level'] : '';
		foreach ( $levels as $level ) {
			printf(
				'<option value="%1$s" %2$s>%3$s</option>',
				$level->term_id,
				$level->term_id == $current_level_filter ? ' selected="selected"' : '',
				$level->name
			);
		}
		?></select>
	<?php
}
add_action( 'restrict_manage_posts', 'bark_admin_display_level_filter' );

function bark_admin_respect_level_filter( $query ) {
	global $pagenow;
	$type = 'post';

	if ( isset( $_GET['post_type'] ) ) {
		$type = sanitize_text_field( wp_unslash( $_GET['post_type'] ) );
	}

	if ( isset( $_GET['filter-bark-level'] ) ) {
		$bark_level = intval( $_GET['filter-bark-level'] );
	}

	if (
		'cdv8_bark' === $type && is_admin() &&
		'edit.php' === $pagenow && ! empty( $bark_level )
	) {
		$query->set( 'tax_query', array(
			array(
				'taxonomy' => 'bark-level',
				'field'    => 'id',
				'terms'    => array( $bark_level ),
			),
		) );
	}
}
add_filter( 'parse_query', 'bark_admin_respect_level_filter' );
