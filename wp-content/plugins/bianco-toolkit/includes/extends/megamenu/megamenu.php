<?php
/**
 * Ovic Megamenu
 *
 * @author   KHANH
 * @category API
 * @package  Ovic_Megamenu
 * @since    1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( !class_exists( 'Ovic_Megamenu' ) ) {
	class Ovic_Megamenu
	{
		private static $instance;

		public static function instance()
		{
			if ( !isset( self::$instance ) && !( self::$instance instanceof Ovic_Megamenu ) ) {
				self::$instance = new Ovic_Megamenu;
				self::$instance->setup_constants();
				self::$instance->includes();
				add_action( 'admin_enqueue_scripts', array( self::$instance, 'admin_scripts' ), 999 );
				add_action( 'wp_enqueue_scripts', array( self::$instance, 'shortcodes_css_megamenu' ), 999 );
			}

			return self::$instance;
		}

		public function setup_constants()
		{
			// Plugin Folder Path.
			if ( !defined( 'OVIC_MEGAMENU_DIR' ) ) {
				define( 'OVIC_MEGAMENU_DIR', plugin_dir_path( __FILE__ ) );
			}
			// Plugin Folder URL.
			if ( !defined( 'OVIC_MEGAMENU_URL' ) ) {
				define( 'OVIC_MEGAMENU_URL', plugin_dir_url( __FILE__ ) );
			}
		}

		public function includes()
		{
			require_once OVIC_MEGAMENU_DIR . 'includes/walker_nav_menu_edit_custom.php';
			require_once OVIC_MEGAMENU_DIR . 'includes/classes.php';
		}

		public function admin_scripts( $hook_suffix )
		{
			if ( ( $hook_suffix === 'post-new.php' || $hook_suffix === 'post.php' ) ) {
				if ( $GLOBALS['post']->post_type === 'ovic_menu' && isset( $_GET['ovic_menu_item_id'] ) ) {
					wp_enqueue_style( 'content-megamenu', OVIC_MEGAMENU_URL . 'assets/css/content-megamenu.css' );
					wp_add_inline_style( 'content-megamenu', '#screen-meta,#screen-meta-links,#wpadminbar,#adminmenumain{display:none;}' );
				}
			}
			if ( $hook_suffix == 'nav-menus.php' ) {
				wp_enqueue_media();
				wp_enqueue_style( 'megamenu-backend', OVIC_MEGAMENU_URL . 'assets/css/megamenu-backend.css' );
				wp_enqueue_script( 'megamenu-backend', OVIC_MEGAMENU_URL . 'assets/js/megamenu-backend.js', array( 'jquery', 'wp-util' ), '1.0' );
			}
			wp_localize_script( 'megamenu-backend', 'ovic_megamenu_backend', array(
					'ajaxurl'     => admin_url( 'admin-ajax.php' ),
					'security'    => wp_create_nonce( 'ovic_megamenu_backend' ),
					'placeholder' => OVIC_MEGAMENU_URL . 'assets/images/placeholder.png',
				)
			);
		}

		public function shortcodes_css_megamenu()
		{
			$css   = '';
			$args  = array(
				'posts_per_page' => -1,
				'post_type'      => 'ovic_menu',
				'post_status'    => 'publish',
				'fields'         => 'ids',
			);
			$posts = get_posts( $args );
			if ( $posts ) {
				foreach ( $posts as $post_id ) {
					$css .= get_post_meta( $post_id, '_wpb_post_custom_css', true );
					$css .= get_post_meta( $post_id, '_wpb_shortcodes_custom_css', true );
					$css .= get_post_meta( $post_id, '_Ovic_Shortcode_custom_css', true );
					$css .= get_post_meta( $post_id, '_Ovic_VC_Shortcode_Custom_Css', true );
				}
			}
			wp_enqueue_style(
				'megamenu-frontend',
				OVIC_MEGAMENU_URL . 'assets/css/megamenu-frontend.css'
			);
			if ( $css != '' ) {
				wp_add_inline_style( 'megamenu-frontend', $css );
			}
			wp_enqueue_script( 'jquery-actual', OVIC_MEGAMENU_URL . 'assets/js/jquery.actual.min.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'megamenu-frontend', OVIC_MEGAMENU_URL . 'assets/js/megamenu-frontend.js', array( 'jquery' ), false, true );
			wp_localize_script( 'megamenu-frontend', 'ovic_megamenu_frontend', array(
					'title' => esc_html__( 'MAIN MENU', 'bianco-toolkit' ),
				)
			);
		}
	}
}
if ( !function_exists( 'Ovic_Megamenu' ) ) {
	function Ovic_Megamenu()
	{
		return Ovic_Megamenu::instance();
	}

	Ovic_Megamenu();
}