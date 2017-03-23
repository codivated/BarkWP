<?php
/**
 * Primary Bark_Logger class.
 *
 * @package bark
 */

/**
 * Handles functionality related to handling barked errors.
 *
 * @package bark
 */
class Bark_Logger {
	/**
	 * Log a bark into the database.
	 *
	 * @param string $message Message for the entry.
	 * @param string $level   Level of the bark.
	 * @param string $context Additional information about the entry.
	 *
	 * @since 0.1
	 */
	public function log( $message, $level = 'debug', $context = array() ) {
		if ( false === $this->should_log() ) {
			return;
		}

		$backtrace = debug_backtrace();
		$caller = array_shift( $backtrace );

		$context = wp_parse_args( $context, array(
			'file' => $caller['file'],
			'line' => $caller['line'],
		) );

		$bark = wp_insert_post( array(
			'post_type' => 'cdv8_bark',
			'post_title' => substr( $message, 0, 50 ) . '...',
			'post_content' => json_encode( array(
				'message' => $message,
				'context' => $context,
			) ),
			'post_status' => 'publish',
		) );
		$this->assign_level_to_bark( $level, $bark );

		return $bark;
	}

	public function should_log() {
		/**
		 * Filter whether or not the given bark should be logged.
		 *
		 * @param bool $should_log Should the bark be logged.
		 *
		 * @since 0.1
		 */
		return apply_filters( 'bark_should_log', true );
	}

	/**
	 * Assign specified level to a bark entry.
	 *
	 * @param string $level_slug The slug for the level you want to assign.
	 * @param int    $bark_id    The ID of the bark you want the level assigned to.
	 */
	public function assign_level_to_bark( $level_slug, $bark_id ) {
		/**
		 * Whitelist Bark levels.
		 *
		 * @param array $level_whitelist Array of slugs for whitelisted levels.
		 *
		 * @since 0.1
		 */
		$level_whitelist = apply_filters( 'bark-level-whitelist', array(
			'critical',
			'emergency',
			'alert',
			'warning',
			'error',
			'notice',
			'info',
			'debug',
		) );

		if ( ! in_array( $level_slug, $level_whitelist ) ) {
			do_action( 'bark', '[' . $level_slug . '] not a whitelisted level. Defaulting to `notice`.', 'info' );
			$level_slug = 'notice';
		}

		$level = get_term_by( 'slug', $level_slug, 'bark-level' );
		if ( false === $level ) {
			do_action( 'bark', '[' . $level_slug . '] level was not found in database.', 'error' );
			return false;
		}

		return wp_set_post_terms( $bark_id, $level->term_id, 'bark-level' );
	}
}
