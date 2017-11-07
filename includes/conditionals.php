<?php

namespace tw2113\qmgwp;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'query_monitor_conditionals', function( $conds ) {
	return array_merge( $conds, array(
		'is_give_form',
		'is_give_category',
		'is_give_tag',
		'is_give_taxonomy',
	) );
} );
