<?php
/**
 * QueryMonitor GiveWP Meta HTML class.
 *
 * @package qmgwp
 * @since   1.0.0
 */

namespace tw2113\qmgwp;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class QueryMonitor_GiveWP_HTML_Meta extends \QM_Output_Html {

	public function __construct( \QM_Collector $collector ) {
		parent::__construct( $collector );

		add_filter( 'qm/output/menus', array( $this, 'admin_menu' ), 101 );
	}

	/**
	 * Construct the output for the Query Monitor content section for GiveWP meta.
	 *
	 * @since 1.0.0
	 */
	public function output() {
		$data = $this->collector->get_data();

		?>
		<div id="<?php echo esc_attr( $this->collector->id() ); ?>" class="qm">
			<table cellspacing="0">
				<thead>
				<tr>
					<th><?php printf( esc_html__( '%s Meta Name', 'query-monitor-givewp' ), $this->collector->name() ); ?></th>
					<th><?php printf( esc_html__( '%s Meta Value', 'query-monitor-givewp' ), $this->collector->name() ); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php
				if ( ! empty( $data['meta'] ) && is_array( $data['meta'] ) ) {
					foreach ( $data['meta'] as $key => $value ) {
						?>
						<tr>
							<td><?php echo esc_html( $key ); ?></td>
							<td><?php echo esc_html( $value ); ?></td>
						</tr>
						<?php
					}
				} else {
					?>
					<tr>
						<td colspan="2" style="text-align:center !important;"><em><?php esc_html_e( 'none', 'query-monitor-givewp' ); ?></em></td>
					</tr>
					<?php
				}
				?>
				</tbody>
				<tfoot>
				<tr class="qm-items-shown qm-hide">
					<td><?php printf( esc_html__( '%s Meta Name', 'query-monitor-givewp' ), $this->collector->name() ); ?></td>
					<td><?php printf( esc_html__( '%s Meta Value', 'query-monitor-givewp' ), $this->collector->name() ); ?></td>
				</tr>
				</tfoot>
			</table>
		</div>

		<?php
	}

	/**
	 * Add our meta section to the Query Monitor dropdown from admin bar.
	 *
	 * @since 1.0.0
	 *
	 * @param array $menu Array of menu items to render.
	 * @return array
	 */
	public function admin_menu( array $menu ) {
		$add = array(
			'title' => sprintf( esc_html__( '%s Meta', 'query-monitor-givewp' ), 'GiveWP' ),
		);

		$menu[] = $this->menu( $add );

		return $menu;
	}
}

/**
 * Initiate an instance for HTML output for the meta section.
 *
 * @since 1.0.0
 *
 * @param array          $output     Array of HTML output instances to render.
 * @param \QM_Collectors $collectors Collector object.
 *
 * @return array
 */
function register_qm_gwp_output_html_meta( array $output, \QM_Collectors $collectors ) {
	if ( $collector = \QM_Collectors::get( 'qmgwp-meta' ) ) {
		$output['qmgwp-meta'] = new QueryMonitor_GiveWP_HTML_Meta( $collector );
	}

	return $output;
}
