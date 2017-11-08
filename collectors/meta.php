<?php
/**
 * QueryMonitor GiveWP Meta Collector class.
 *
 * @package qmgwp
 * @since   1.0.0
 */

namespace tw2113\qmgwp;

class QueryMonitor_GiveWP_Collector_Meta extends \QM_Collector {

	/**
	 * ID for our collector instance.
	 *
	 * @var string
	 */
	public $id = 'qmgwp-meta';

	private $give_post_id = 0;

	private $give_has_form = false;

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Sets a usable name ofr our collector.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function name() {
		return 'GiveWP';
	}

	/**
	 * Collect data to make available for the HTML output.
	 *
	 * @since 1.0.0
	 */
	public function process() {
		$this->data['meta'] = array();

		global $post;
		$this->find_give_form( $post );

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

	/**
	 * Determine if a given request has a GiveWP form available.
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Post $post
	 */
	private function find_give_form( \WP_Post $post ) {
		if ( is_admin() ) {
			return;
		}
		if ( 'give_forms' === $post->post_type ) {
			if ( ! is_singular() ) {
				return;
			}
			$this->give_has_form = true;
			$this->give_post_id  = $post->ID;

			return;
		}

		// @todo Figure out why parsing isn't returning attributes correctly.
		$all_shortcode_atts = shortcode_parse_atts( $post->post_content );
		if ( ! empty( $all_shortcode_atts['id'] ) ) {
			$maybe_give_form = get_post( absint( $all_shortcode_atts['id'] ) );
			if ( $maybe_give_form instanceof \WP_Post && 'give_forms' === $maybe_give_form->post_type ) {
				$this->give_has_form = true;
				$this->give_post_id  = $maybe_give_form->ID;

				return;
			}
		}

		$has_widget = is_active_widget( false, false, 'give_forms_widget' );
		if ( false !== $has_widget ) {
			// Grab all of our sidebar areas.
			$sidebars_widgets    = wp_get_sidebars_widgets();
			$widget_id           = $sidebars_widgets[ $has_widget ][0]; // Grab the widget ID that we want to run with.
			$active_give_widgets = get_option( 'widget_give_forms_widget' );
			$widget_numeral_id   = array_pop( explode( '-', $widget_id ) ); // Pluck the ID of the widget off the end.
			$desired_widget_data = $active_give_widgets[ $widget_numeral_id ]; // Grab the specific instance out of our array of saved widgets.
			if ( ! empty( $desired_widget_data['id'] ) ) {
				$maybe_widget_give_form = get_post( absint( $desired_widget_data['id'] ) );
				if ( $maybe_widget_give_form instanceof \WP_Post && 'give_forms' === $maybe_widget_give_form->post_type ) {
					$this->give_has_form = true;
					$this->give_post_id  = $maybe_widget_give_form->ID;

					return;
				}
			}
		}
	}
}

/**
 * Initiate an instance for Collector class for the meta section.
 *
 * @since 1.0.0
 *
 * @param array         $collectors Array of current instantiated collectors.
 * @param \QueryMonitor $qm         Query Monitor instance.
 *
 * @return array
 */
function register_qm_gwp_collectors_meta( array $collectors, \QueryMonitor $qm ) {
	$collectors['qmgwp-meta'] = new QueryMonitor_GiveWP_Collector_Meta;

	return $collectors;
}
