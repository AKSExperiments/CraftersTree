<?php
/**
 * Plugin Name: Bianco Toolkit
 * Plugin URI: https://kutethemes.com
 * Description: Bianco Toolkit For WordPress Theme WooCommerce.
 * Author: Ovic Team
 * Author URI: https://kutethemes.com
 * Version: 1.0.4
 * Text Domain: bianco-toolkit
 */
// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'BIANCO_TOOLKIT' ) ) {
	class  BIANCO_TOOLKIT
	{
		/**
		 * @var BIANCO_TOOLKIT The one true BIANCO_TOOLKIT
		 */
		private static $instance;

		public static function instance()
		{
			if ( !isset( self::$instance ) && !( self::$instance instanceof BIANCO_TOOLKIT ) ) {
				self::$instance = new BIANCO_TOOLKIT;
				self::$instance->setup_constants();
				self::$instance->setup_plugins();
				add_action( 'plugins_loaded', array( self::$instance, 'includes' ) );
				add_action( 'admin_enqueue_scripts', array( self::$instance, 'enqueue_scripts' ) );
			}

			return self::$instance;
		}

		public function enqueue_scripts()
		{
			wp_enqueue_style( 'backend', BIANCO_TOOLKIT_PLUGIN_URL . '/assets/css/backend.css' );
			wp_enqueue_script('backend-js', BIANCO_TOOLKIT_PLUGIN_URL . '/assets/js/backend.js', array('jquery'), null, true);
		}

		public function setup_constants()
		{
			// Plugin version.
			if ( !defined( 'BIANCO_TOOLKIT_VERSION' ) ) {
				define( 'BIANCO_TOOLKIT_VERSION', '1.0.0' );
			}
			// Plugin Folder Path.
			if ( !defined( 'BIANCO_TOOLKIT_PLUGIN_DIR' ) ) {
				define( 'BIANCO_TOOLKIT_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
			}
			// Plugin Folder URL.
			if ( !defined( 'BIANCO_TOOLKIT_PLUGIN_URL' ) ) {
				define( 'BIANCO_TOOLKIT_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
			}
		}

		public function setup_plugins(){
			require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'plugins-3rd-party/ovic-vc-addon/addon.php';
			require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/frontend/framework.php';
			require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/admin/dashboard.php';
			require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/admin/settings/ovic-settings.php';
		}

		public function includes(){
			/* extends */
			require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/extends/mailchimp/mailchimp.php';
			require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/extends/megamenu/megamenu.php';
			require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/extends/post-like/post-like.php';
			require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/extends/footer-builder/footer-builder.php';
			if ( class_exists( 'WooCommerce' ) ) {
				require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/extends/product-brand/product-brand.php';
				require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/extends/shop-ajax/shop.php';
				require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/extends/attributes-swatches/product-attribute-meta.php';
			}
			/* load text domain */
			load_plugin_textdomain( 'bianco-toolkit', false, BIANCO_TOOLKIT_PLUGIN_DIR . 'languages' );
		}
	}
}
if ( !function_exists( 'bianco_framework' ) ) {
	function bianco_framework(){
		return BIANCO_TOOLKIT::instance();
	}
	bianco_framework();
}