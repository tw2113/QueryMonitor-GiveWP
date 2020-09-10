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

/**
 * Returns an array of extra conditions to check for with current request.
 *
 * @since 1.0.0
 *
 * @param array $conds Array of conditional tags to check for.
 * @return array
 */
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
		'give_is_donation_history_page',
		'give_is_add_new_form_page',
		'give_is_success_page',
		'give_is_failed_transaction_page',
		'give_is_history_page',
		'give_is_admin_page',
		'give_is_test_mode',
		'give_shortcode_button_condition',
		'give_can_checkout',
		'give_stripe_is_any_payment_method_active',
	) ) );
} );
