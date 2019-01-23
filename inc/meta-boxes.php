<?php
/**
 * Meta boxes for Bark.
 *
 * @package bark
 */

function bark_register_meta_boxes() {
	add_meta_box( 'bark-level', __( 'Level', 'bark' ), 'bark_level_display', 'cdv8_bark', 'advanced', 'high' );
	add_meta_box( 'bark-message', __( 'Message', 'bark' ), 'bark_message_display', 'cdv8_bark' );
	add_meta_box( 'bark-location', __( 'Location', 'bark' ), 'bark_location_display', 'cdv8_bark' );
	add_meta_box( 'bark-custom-context', __( 'Custom Context', 'bark' ), 'bark_custom_context_display', 'cdv8_bark' );
	add_meta_box( 'bark-system-context', __( 'System Context', 'bark' ), 'bark_system_context_display', 'cdv8_bark' );
}

add_action( 'add_meta_boxes', 'bark_register_meta_boxes' );

function bark_level_display() {
	global $post;
	$terms = wp_get_post_terms( $post->ID, 'bark-level' );
	$level = array_shift( $terms );
	?><p><?php echo esc_html( $level->name ); ?></p><?php
}

function bark_location_display() {
	global $post;
	$decoded = json_decode( $post->post_content ); ?>
	<table>
	<tr>
		<td><strong><?php esc_html_e( 'File', 'bark' ); ?></strong></td>
		<td><?php echo esc_html( $decoded->context->file ); ?></td>
	</tr>
	<tr>
		<td><strong><?php esc_html_e( 'Line', 'bark' ); ?></strong></td>
		<td><?php echo esc_html( $decoded->context->line ); ?></td>
	</tr>
	</table><?php
}

function bark_custom_context_display( $post ) {
	global $post;
	$decoded = json_decode( $post->post_content ); ?>
	<p><?php echo esc_html( 'Custom context is any additional information a developer can provide about a Bark.', 'bark' ); ?></p>

	<?php if ( ! empty( $decoded->context->custom ) ) : ?>
		<div style="overflow-x: auto;"><pre><?php echo print_r( $decoded->context->custom ); ?></pre></div>
	<?php else : ?>
		<p><?php echo esc_html( 'No custom context provided.', 'bark' ); ?></p>
	<?php endif;
}

function bark_system_context_display( $post ) {
	global $post;
	$decoded = json_decode( $post->post_content ); ?>
	<p><?php echo esc_html( 'System context is debugging information automatically provided by Bark to every log.', 'bark' ); ?></p>
	<?php if ( ! empty( $decoded->context->system ) ) : ?>
		<div style="overflow-x: auto;"><pre><?php echo print_r( $decoded->context->system ); ?></pre></div><?php
	else :?>
		<p><?php echo esc_html( 'No custom context provided.', 'bark' ); ?></p>
	<?php endif;
}

function bark_message_display( $post ) {
	global $post;
	$decoded = json_decode( $post->post_content ); ?>
	<?php echo esc_html( $decoded->message ); ?><?php
}
