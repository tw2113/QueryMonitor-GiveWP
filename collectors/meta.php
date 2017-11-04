<?php

namespace tw2113\qmgwp;

class QueryMonitor_GiveWP_Collector_Meta extends \QM_Collector {

	public $id = 'qmgwp-meta';

	private $give_post_id = 0;

	private $give_has_form = false;

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
		$this->has_give_form( $post );

		if ( $this->give_has_form ) {
			$meta = get_post_meta( $this->give_post_id );
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
