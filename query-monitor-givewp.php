<?php
/**
 * QueryMonitor GiveWP loader.
 *
 * @package qmgwp
 * @since   1.0.0
 */

/*
 * Plugin Name: Query Monitor GiveWP Conditionals
 * Description: Add GiveWP conditionals to Query Monitor
 * Version: 1.0.0
 * Plugin URI: https://michaelbox.net
 * Author: Michael Beckwith
 * Author URI: https://michaelbox.net
 * Contributors: tw2113
 * Requires at least: 4.8
 * Tested up to: 4.8.3
 * Requires PHP: 5.3
 * Stable tag: 1.0.0
 * Text Domain: query-monitor-givewp
 * License: MIT
 */

namespace tw2113\qmgwp;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (
	! class_exists( 'QM_Activation' )
	|| ( defined( 'QM_DISABLED' ) && QM_DISABLED )
	|| ( defined( 'QMX_DISABLED' ) && QMX_DISABLED )
) {
	return;
}

class QueryMonitor_GiveWP {

	public function __construct() {

	}

	public function do_hooks() {
		add_action( 'plugins_loaded', array( $this, 'includes' ), 0 );
		add_filter( 'qm/outputter/html', array( $this, 'include_outputters' ), 0 );
	}

	public function include_outputters( $output ) {
		if ( class_exists( 'QM_Output_Html' ) ) {
			require 'outputters/constants.php';
			require 'outputters/meta.php';
		}
		add_filter( 'qm/outputter/html', __NAMESPACE__ . '\register_qm_gwp_output_html_constants', 999, 2 );
		add_filter( 'qm/outputter/html', __NAMESPACE__ . '\register_qm_gwp_output_html_meta', 999, 2 );

		return $output;
	}

	public function includes() {
		if ( class_exists( 'QM_Collector' ) ) {
			require 'collectors/constants.php';
			require 'collectors/meta.php';
		}
		add_filter( 'qm/collectors', __NAMESPACE__ . '\register_qm_gwp_collectors_constants', 999, 2 );
		add_filter( 'qm/collectors', __NAMESPACE__ . '\register_qm_gwp_collectors_meta', 999, 2 );

		require 'includes/conditionals.php';
	}

}
$qmgwp = new QueryMonitor_GiveWP();
$qmgwp->do_hooks();
