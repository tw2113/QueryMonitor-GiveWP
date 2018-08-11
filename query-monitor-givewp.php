<?php
/**
 * QueryMonitor GiveWP loader.
 *
 * @package qmgwp
 * @since   1.0.0
 */

/*
 * Plugin Name: Query Monitor GiveWP
 * Description: Add GiveWP to Query Monitor
 * Version: 1.0.0
 * Plugin URI: https://michaelbox.net
 * Author: Michael Beckwith
 * Author URI: https://michaelbox.net
 * Contributors: tw2113
 * Requires at least: 4.8
 * Tested up to: 4.9.8
 * Requires PHP: 5.6
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

/**
 * Construct our plugin.
 *
 * @since 1.0.0
 */
class QueryMonitor_GiveWP {

	/**
	 * Execute our hooks.
	 *
	 * @since 1.0.0
	 */
	public function do_hooks() {
		add_action( 'plugins_loaded', array( $this, 'includes' ), 0 );
		add_filter( 'qm/outputter/html', array( $this, 'include_outputters' ), 0 );
	}

	/**
	 * Wire up our collectiors and other includes.
	 *
	 * @since 1.0.0
	 */
	public function includes() {
		if ( class_exists( 'QM_Collector' ) ) {
			require 'collectors/constants.php';
			require 'collectors/meta.php';
		}
		add_filter( 'qm/collectors', __NAMESPACE__ . '\register_qm_gwp_collectors_constants', 999, 2 );
		add_filter( 'qm/collectors', __NAMESPACE__ . '\register_qm_gwp_collectors_meta', 999, 2 );

		require 'includes/conditionals.php';

		/**
		 * Fires at the end of our primary class includes method.
		 *
		 * @since 1.0.0
		 */
		do_action( 'qmgwp_includes' );
	}

	/**
	 * Wire up our outputter data.
	 *
	 * @since 1.0.0
	 *
	 * @param array $output Array of output for Query Monitor.
	 * @return mixed
	 */
	public function include_outputters( $output ) {
		if ( class_exists( 'QM_Output_Html' ) ) {
			require 'outputters/constants.php';
			require 'outputters/meta.php';
		}
		add_filter( 'qm/outputter/html', __NAMESPACE__ . '\register_qm_gwp_output_html_constants', 999, 2 );
		add_filter( 'qm/outputter/html', __NAMESPACE__ . '\register_qm_gwp_output_html_meta', 999, 2 );

		/**
		 * Fires at the end of our primary class include_outputters method.
		 *
		 * @since 1.0.0
		 *
		 * @param array @output Array of output for Query Monitor.
		 */
		do_action( 'qmgwp_include_outputters', $output );

		return $output;
	}

}
$qmgwp = new QueryMonitor_GiveWP();
$qmgwp->do_hooks();
