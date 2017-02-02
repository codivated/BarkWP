<?php
/**
 * Options page for Bark.
 *
 * @package bark
 */

function bark_options_page() {
	add_submenu_page( 'edit.php?post_type=cdv8_bark', 'Bark Options', 'Bark Options', 'edit_posts', basename( __FILE__ ), 'bark_display_options' );
}
add_action( 'admin_menu', 'bark_options_page' );

function bark_display_options() {
	?>
	<div class="wrap">
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		<p><?php echo esc_html__( 'Configure Bark to meet your needs.', 'bark' ); ?></p>
	</div>
	<?php
}
