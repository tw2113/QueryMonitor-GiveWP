<?php
/**
 * QueryMonitor GiveWP Conditionals file.
 *
 * @package qmgwp
 * @since   1.0.0
 */

namespace tw2113\qmgwp;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'query_monitor_conditionals', function( $conds ) {
	/**
	 * Filters the conditional tags to check for with Query Monitor GiveWP.
	 *
	 * @since 1.0.0
	 *
	 * @param array $value Array of conditional tag functions to check for.
	 */
	return array_merge( $conds, apply_filters( 'qmgwp_conditionals', array(
		'is_give_form',
		'is_give_category',
		'is_give_tag',
		'is_give_taxonomy',
	) ) );
} );
