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
		$this->data['constants'] = [];

		$constants = [
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
		];

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

	private function disp_boolean( $bool_text ) {
		$bool_text = (string) $bool_text;
		if ( empty( $bool_text ) || '0' === $bool_text || 'false' === $bool_text ) {
			return 'false';
		}

		return 'true';
	}

}

function register_qm_gwp_collectors_constants( array $collectors, \QueryMonitor $qm ) {
	$collectors['qmgwp-constants'] = new QueryMonitor_GiveWP_Collector_Constants;

	return $collectors;
}
