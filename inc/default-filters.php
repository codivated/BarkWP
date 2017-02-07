<?php
/**
 * Apply default actions to Bark filters.
 *
 * @package bark
 */

/**
 * Handle adding an entry when `bark` action is called.
 *
 * @param array $details Bark_Logger details.
 */
function bark_add_entry( $message, $level = 'debug', $context = array() ) {
	global $wp;

	$bark_context['system'] = array(
		'wp' => $wp,
		'globals' => array(
			'$_GET' => empty( $_GET ) ?  '' : $_GET,
			'$_POST' => empty( $_POST ) ? '' : $_POST,
			'$_SESSION' => empty( $_SESSION ) ? '' : $_SESSION,
		),
	);
	$bark_context['custom'] = $context;

	/**
	 * Filter the context included in a Bark.
	 * The context is where additional information about the Bark is stored.
	 *
	 * @param array $bark_context The context to be saved for the given bark.
	 *     array(
	 *         'system' => array() // Context added automatically by bark.
	 *         'custom' => array() // Context added by the user.
	 *     );
	 *
	 * @since 0.1
	 */
	$bark_context = apply_filters( 'bark_context', $bark_context );

	/**
	 * Action fired before a bark is inserted into the database.
	 *
	 * @param string $message      Messge for the bark.
	 * @param string $level        Bark level slug.
	 * @param array  $bark_context Context for the bark.
	 *
	 * @since 0.1
	 */
	do_action( 'bark_before_insert', $message, $level, $bark_context );

	$bark = new Bark_Logger();
	$bark_id = $bark->log( $message, $level, (array) $bark_context );

	/**
	 * Action fired after a bark is inserted into the database.
	 *
	 * @param string $bark_id ID of the newly added bark.
	 *
	 * @since 0.1
	 */
	do_action( 'bark_after_insert', $bark_id );
}
add_action( 'bark', 'bark_add_entry', 10, 3 );

function bark_prevent_log_if_limit_reached( $should_log ) {
	$limit = get_option( 'bark-limit-logs', 1000 );

	/**
	 * Filter the number of logs that are allowed. If there are more barks currently in the
	 * database than what this limit is set to, we prevent new barks from being added.
	 *
	 * @param int $limit Number of barks that are allowed before we prevent new barks.
	 * @since 0.1
	 */
	$limit = apply_filters( 'bark-log-limit', $limit );
	$barks = bark_get_total();

	if ( (int) $limit <= (int) $barks ) {
		$should_log = false;
	}

	return $should_log;
}
add_filter( 'bark_should_log', 'bark_prevent_log_if_limit_reached' );
