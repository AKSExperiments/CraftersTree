<?php
/**
 * Ovic Framework setup
 *
 * @author   KHANH
 * @category API
 * @package  Ovic_VC_Dashboard
 * @since    1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( !class_exists( 'Ovic_VC_Dashboard' ) ) {
	class Ovic_VC_Dashboard
	{
		public function __construct()
		{
			$this->includes();
            add_filter( 'ovic_registered_settings', array( $this, 'options' ), 50, 1 );
            add_filter( 'ovic_settings_print_option_page', array( $this, 'ovic_settings_print_option_page' ), 50, 3 );
		}

		function includes()
		{
			include_once OVIC_VC_PLUGIN_DIR . 'includes/helpers.php';
			include_once OVIC_VC_PLUGIN_DIR . 'includes/params.php';
			include_once OVIC_VC_PLUGIN_DIR . 'includes/visual-composer.php';
		}

		private function options_setting()
		{
			$editor_names             = Ovic_VC_Init::ovic_vc_responsive_data( false );
			$editor_options           = get_option( '_ovic_vc_options' );
			$enable_advanced_options  = 'checked';
			$enable_screen_responsive = 'checked';
			if ( isset( $editor_options['advanced_options'] ) && $editor_options['advanced_options'] == 'no' ) {
				$enable_advanced_options = '';
			}
			if ( isset( $editor_options['screen_responsive'] ) && $editor_options['screen_responsive'] == 'no' ) {
				$enable_screen_responsive = '';
			}
			?>
            <div class="dashboard-ovic-vc">
                <h1 class="title">Welcome to Plugins Responsive WPBakery</h1>
                <div class="dashboard-intro">
                    <form method="post" class="ovic_vc_options">
                        <div class="alert-tool"></div>
                        <div class="head-options">
                            <div class="field-item ovic-vc-checkbox-field" style="padding-right: 20px">
                                <strong class="title"><?php echo esc_html__( 'Enable Screen Responsive', 'bianco-toolkit' ); ?></strong>
                                <div class="inner-field">
                                    <label class="vc_checkbox-label">
                                        <input id="enable_screen_responsive"
                                               class="wpb_vc_param_value"
                                               name="enable_screen_responsive" type="checkbox"
											<?php echo esc_attr( $enable_screen_responsive ); ?>>
                                        <label for="enable_screen_responsive"></label>
                                    </label>
                                </div>
                            </div>
                            <div class="field-item ovic-vc-checkbox-field">
                                <strong class="title"><?php echo esc_html__( 'Enable Advanced Options', 'bianco-toolkit' ); ?></strong>
                                <div class="inner-field">
                                    <label class="vc_checkbox-label">
                                        <input id="enable_advanced_options"
                                               class="wpb_vc_param_value"
                                               name="enable_advanced_options" type="checkbox"
											<?php echo esc_attr( $enable_advanced_options ); ?>>
                                        <label for="enable_advanced_options"></label>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <table class="wp-list-table widefat striped pages group-item" style="width:100%">
                            <thead>
                            <tr>
                                <td style="width:30%">
                                    <strong><?php echo esc_html__( 'Name Screen', 'bianco-toolkit' ); ?></strong>
                                </td>
                                <td style="width:30%">
                                    <strong><?php echo esc_html__( 'Media Feature', 'bianco-toolkit' ); ?></strong>
                                </td>
                                <td style="width:30%">
                                    <strong><?php echo esc_html__( 'Breakpoint', 'bianco-toolkit' ); ?></strong>
                                </td>
                                <td style="width:10%;text-align: center">
                                    <strong><?php echo esc_html__( 'Remove', 'bianco-toolkit' ); ?></strong>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
							<?php echo Ovic_VC_Helpers::content_screen_editor( $editor_names ); ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>
                                    <label class="add-screen"><a href="#" class="button"><?php echo esc_html__( 'Add Screen', 'bianco-toolkit' ); ?></a></label>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </form>
                    <div class="tab-content">
                        <button type="submit" class="button-primary"><?php echo esc_html__( 'Save', 'bianco-toolkit' ); ?></button>
                        <button type="submit" class="reset preview button"><?php echo esc_html__( 'Reset', 'bianco-toolkit' ); ?></button>
                    </div>
                </div>
            </div>
			<?php
		}

        public function options( $options){
            $options['ovic_settings_vc'] = array(
                'id'         => 'ovic_settings_vc', //id used as tab page slug, must be unique
                'title'      => __( 'VC Breakpoints Setting', 'bianco-toolkit' ),
                'show_names' => true,
                'sections'   => array(
                    'settings_backup' => array(
                        'id'    => 'ovic_settings_vc',
                        'title' => __( 'VC Breakpoint Setting', 'bianco-toolkit' ),
                    ),
                ),
            );

            return $options;
        }

        public function ovic_settings_print_option_page( $html, $active_tab, $active_section )
        {
            if ( $active_tab == 'ovic_settings_vc' ) {
                ob_start();
                $this->options_setting();
                $html = ob_get_clean();
            }

            return $html;
        }
	}

	new Ovic_VC_Dashboard();
}