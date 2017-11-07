<?php

namespace tw2113\qmgwp;

class QueryMonitor_GiveWP_Collector_Constants extends \QM_Collector {

	public $id = 'qmgwp-constants';

	public function __construct() {
		parent::__construct();
	}

	public function name() {
		return 'GiveWP';
	}

	// Gather our information to be used in our output.
	public function process() {
		$this->data['constants'] = array();

		/**
		 * Filters the constants to check for with Query Monitor GiveWP.
		 *
		 * @since 1.0.0
		 *
		 * @param array $value Array of constants to check for.
		 */
		$constants = apply_filters( 'qmgwp_constants', array(
			'GIVE_API_VERSION',
			'GIVE_DISABLE_FORMS_REWRITE',
			'GIVE_DOING_API',
			'GIVE_FORMS_SLUG',
			'GIVE_PLUGIN_BASENAME',
			'GIVE_PLUGIN_DIR',
			'GIVE_PLUGIN_FILE',
			'GIVE_PLUGIN_URL',
			'GIVE_REQUIRED_PHP_VERSION',
			'GIVE_SLUG',
			'GIVE_UNIT_TESTS',
			'GIVE_USE_PHP_SESSIONS',
			'GIVE_VERSION',
		) );

		foreach( $constants as $constant ) {
			if ( defined( $constant ) ) {
				$this->data['constants'][ $constant ] = (
					is_bool( constant( $constant ) )
				)
					? $this->format_bool_constant( constant( $constant ) )
					: constant( $constant );
			} else {
				$this->data['constants'][ $constant ] = esc_html__( 'undefined', 'query-monitor-givewp' );
			}
		}
	}
}

function register_qm_gwp_collectors_constants( array $collectors, \QueryMonitor $qm ) {
	$collectors['qmgwp-constants'] = new QueryMonitor_GiveWP_Collector_Constants;

	return $collectors;
}
