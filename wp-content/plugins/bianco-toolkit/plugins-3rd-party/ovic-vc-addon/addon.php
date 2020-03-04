<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'Ovic_VC' ) ) {
	class  Ovic_VC
	{
		/**
		 * @var Ovic_VC The one true Ovic_VC
		 */
		private static $instance;

		public static function instance()
		{
			if ( !isset( self::$instance ) && !( self::$instance instanceof Ovic_VC ) ) {
				self::$instance = new Ovic_VC;
				self::$instance->setup_constants();
				add_action( 'plugins_loaded', array( self::$instance, 'load_setup_plugins' ) );
			}

			return self::$instance;
		}

		public function setup_constants()
		{
			// Plugin version.
			if ( !defined( 'OVIC_VC_VERSION' ) ) {
				define( 'OVIC_VC_VERSION', '1.0.0' );
			}
			// Plugin Folder Path.
			if ( !defined( 'OVIC_VC_PLUGIN_DIR' ) ) {
				define( 'OVIC_VC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}
			// Plugin Folder URL.
			if ( !defined( 'OVIC_VC_PLUGIN_URL' ) ) {
				define( 'OVIC_VC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}
			// Plugin Backend Assest.
			if ( !defined( 'OVIC_VC_BACKEND_ASSETS_URL' ) ) {
				define( 'OVIC_VC_BACKEND_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets/backend' );
			}
			// Plugin Frontend Assest.
			if ( !defined( 'OVIC_VC_FRONTEND_ASSETS_URL' ) ) {
				define( 'OVIC_VC_FRONTEND_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets/frontend' );
			}
			// Plugin Shortcode Templates.
			if ( !defined( 'OVIC_VC_SHORTCODE_TEMPLATES_PATH' ) ) {
				define( 'OVIC_VC_SHORTCODE_TEMPLATES_PATH', plugin_dir_path( __FILE__ ) . 'templates/shortcode' );
			}
		}

		public function includes()
		{
			require_once OVIC_VC_PLUGIN_DIR . 'includes/shortcode.php';
			require_once OVIC_VC_PLUGIN_DIR . 'includes/dashboard.php';
		}

		function admin_notice__error()
		{
			?>
            <div class="notice notice-error">
                <p>
					<?php echo __( 'Require plugin', 'bianco-toolkit' ); ?>
                    <a href="<?php echo esc_url( 'https://wpbakery.com/' ); ?>" target="_blank">
						<?php echo __( 'WPBakery Page Builder', 'bianco-toolkit' ); ?>
                    </a>
					<?php echo __( 'for use plugin "Ovic VC Addon"', 'bianco-toolkit' ); ?>
                </p>
            </div>
			<?php
		}

		public function load_setup_plugins()
		{
			if ( !class_exists( 'Vc_Manager' ) ) {
				add_action( 'admin_notices', array( self::$instance, 'admin_notice__error' ) );
			} else {
				self::$instance->includes();
			}
		}
	}
}
if ( !function_exists( 'Ovic_VC' ) ) {
	function Ovic_VC(){
		return Ovic_VC::instance();
	}
	Ovic_VC();
}