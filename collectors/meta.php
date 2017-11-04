<?php

namespace tw2113\qmgwp;

class QueryMonitor_GiveWP_Collector_Meta extends \QM_Collector {

	public $id = 'qmgwp-meta';

	public function __construct() {
		parent::__construct();
	}

	public function name() {
		return 'GiveWP';
	}

	// Gather our information to be used in our output.
	public function process() {
		$this->data['meta'] = [];

		global $post;

		if ( isset( $post->post_type ) && 'give_forms' === $post->post_type && is_single( 'give_forms' ) ) {
			$meta = get_post_meta( $post->ID );
			foreach ( $meta as $key => $value ) {
				if ( '_give' !== substr( $key, 0, 5 ) ) {
					continue;
				}
				$this->data['meta'][ $key ] = $value[0];
			}
		}
	}
}

function register_qm_gwp_collectors_meta( array $collectors, \QueryMonitor $qm ) {
	$collectors['qmgwp-meta'] = new QueryMonitor_GiveWP_Collector_Meta;

	return $collectors;
}
