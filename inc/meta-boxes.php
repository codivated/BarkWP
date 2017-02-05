<?php
/**
 * Meta boxes for Bark.
 *
 * @package bark
 */

function bark_register_meta_boxes() {
	add_meta_box( 'bark-message', __( 'Message', 'bark' ), 'bark_message_display', 'cdv8_bark' );
	add_meta_box( 'bark-context', __( 'Context', 'bark' ), 'bark_context_display', 'cdv8_bark' );
}
add_action( 'add_meta_boxes', 'bark_register_meta_boxes' );

function bark_context_display( $post ) {
	global $post;
	$decoded = json_decode( $post->post_content ); ?>
	<div style="overflow-x: auto;"><?php krumo( $decoded->context ); ?></div><?php
}

function bark_message_display( $post ) {
	global $post;
	$decoded = json_decode( $post->post_content ); ?>
	<?php echo nl2br( $decoded->message ); ?><?php
}
