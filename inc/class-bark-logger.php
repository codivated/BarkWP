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
	 * @param array  $context Additional information about the entry.
	 *
	 * @since 0.1
	 *
	 * @return int|WP_Error Created Bar ID or WordPress error.
	 */
	public function log( $message, $level = 'debug', $context = array() ) {
		if ( false === $this->should_log() ) {
			return new WP_Error(500, 'Error should not be logged.');
		}

		/**
		 * Action fired before a bark is inserted into the database.
		 *
		 * @param string $message      Messge for the bark.
		 * @param string $level        Bark level slug.
		 * @param array  $bark_context Context for the bark.
		 *
		 * @since 0.1
		 */
		do_action( 'bark_before_insert', $message, $level, $context );

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

		/**
		 * Action fired after a bark is inserted into the database.
		 *
		 * @param string $bark_id ID of the newly added bark.
		 *
		 * @since 0.1
		 */
		do_action( 'bark_after_insert', $bark );

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
	 *
	 * @return array|false|WP_Error
	 */
	public function assign_level_to_bark( $level_slug, $bark_id ) {
		$level = $this->get_or_create_whitelisted_level( $level_slug );
		if ( false === $level ) {
			return new WP_Error( 404, 'Error finding or creating bark level.');
		}

		return wp_set_post_terms( $bark_id, $level->term_id, 'bark-level' );
	}

	/**
	 * Get or create the whitelisted bark level.
	 *
	 * @param string $level_slug Slug for bark level you want to retrieve.
	 *
	 * @return array|WP_Error
	 */
	protected function get_or_create_whitelisted_level( $level_slug )  {
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
			$level_slug = 'notice';
		}

		$level = get_term_by( 'slug', $level_slug, 'bark-level' );
		if ( false === $level ) {
			$level = $this->create_bark_level( $level_slug );
		}

		return $level;
	}

	/**
	 * Create a bark level.
	 *
	 * @param string $level Slug for bark level.
	 *
	 * @return array|WP_Error
	 */
	protected function create_bark_level( $level ) {
		return wp_create_term( $level, 'bark-level' );
	}
}
