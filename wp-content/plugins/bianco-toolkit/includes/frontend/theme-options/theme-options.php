<?php if ( !defined( 'ABSPATH' ) ) {
	die;
} // Cannot access pages directly.
defined( 'OVIC_CUSTOMIZE' ) or define( 'OVIC_CUSTOMIZE', '_ovic_customize_options' );
defined( 'OVIC_FRAMEWORK' ) or define( 'OVIC_FRAMEWORK', '_ovic_customize_options' );
if ( !class_exists( 'Ovic_Options_Framework' ) ) {
	class Ovic_Options_Framework
	{
		public function __construct()
		{
			add_action( 'init', array( $this, 'ovic_install_options' ), 10 );
			add_action( 'admin_bar_menu', array( $this, 'ovic_custom_menu' ), 999 );
			add_action( 'wp_ajax_ovic-reset-field', array( $this, 'ovic_reset_field' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'ovic_panels_js' ) );
		}

		function ovic_install_options()
		{
			// helpers
			require_once plugin_dir_path( __FILE__ ) . 'classes/setup.class.php';
			/**
			 * Add Theme Options
			 *
			 * @Active: add_theme_support( 'ovic-theme-option' );
			 */
			$this->config_framework();
			$this->config_customize();
			if ( in_array( $GLOBALS['pagenow'], array( 'edit-tags.php', 'term.php' ) ) )
				$this->config_taxonomy();
			if ( in_array( $GLOBALS['pagenow'], array( 'edit.php', 'post.php', 'post-new.php' ) ) )
				$this->config_metabox();
		}

		public function ovic_custom_menu()
		{
			global $wp_admin_bar;
			if ( !is_super_admin() || !is_admin_bar_showing() ) return;
			// Add Parent Menu
			$args = array(
				'id'    => 'theme_option',
				'title' => esc_html__( 'Theme Options', 'bianco-toolkit' ),
				'href'  => admin_url( 'admin.php?page=ovic_framework' ),
			);
			$wp_admin_bar->add_menu( $args );
		}

		function ovic_reset_field()
		{
			$name_field = isset( $_POST['reset'] ) ? $_POST['reset'] : '';
			ovic_set_customize_option( $name_field, '' );
			die();
		}

		/**
		 * Load dynamic logic for the customizer controls area.
		 */
		function ovic_panels_js()
		{
			wp_enqueue_script( 'ovic-customize-controls', OVIC_PLUGIN_URL . '/assets/js/customize-controls.js', array(), '1.0', true );
		}

		function config_options()
		{
			$temp_path        = get_template_directory_uri();
			$header_options   = Array(
                'appliances'       => Array(
                    'title'   => 'Appliances',
                    'preview' => "{$temp_path}/templates/header/header-appliances.jpg",
                ),
				'child'      => Array(
					'title'   => "Child",
					'preview' => "{$temp_path}/templates/header/header-child.jpg",
				),
				'market'     => Array(
					'title'   => 'Market',
					'preview' => "{$temp_path}/templates/header/header-market.jpg",
				),
				'tool'       => Array(
					'title'   => 'Tool',
					'preview' => "{$temp_path}/templates/header/header-tool.jpg",
				),
				'digital'       => Array(
					'title'   => 'Digital',
					'preview' => "{$temp_path}/templates/header/header-digital.jpg",
				),
				'furniture'       => Array(
					'title'   => 'Furniture',
					'preview' => "{$temp_path}/templates/header/header-furniture.jpg",
				),
			);
			$arr_hero_types   = array(
				'banner' => esc_html__( 'Banner', 'bianco-toolkit' ),
			);
			$revolution_alias = array();
			if ( class_exists( 'RevSlider' ) ) {
				$rev_slider                   = new RevSlider();
				$arr_hero_types['rev_slider'] = esc_html__( 'Revolution slider', 'bianco-toolkit' );
				$arr_rev_alias                = $rev_slider->getAllSliderAliases();
				if ( !empty( $arr_rev_alias ) ) {
					foreach ( $arr_rev_alias as $alias ) {
						$revolution_alias[$alias] = $alias;
					}
				}
			}
			$carousel_options          = array(
				'1' => __( '1 Item', 'bianco-toolkit' ),
				'2' => __( '2 Items', 'bianco-toolkit' ),
				'3' => __( '3 Items', 'bianco-toolkit' ),
				'4' => __( '4 Items', 'bianco-toolkit' ),
				'5' => __( '5 Items', 'bianco-toolkit' ),
				'6' => __( '6 Items', 'bianco-toolkit' ),
			);
			$sections                  = array();
			$sections['general']       = array(
				'name'   => 'general',
				'title'  => esc_html__( 'General', 'bianco-toolkit' ),
				'icon'   => 'fa fa-tachometer',
				'fields' => array(
					'ovic_logo'            => array(
						'id'    => 'ovic_logo',
						'type'  => 'image',
						'title' => esc_html__( 'Logo', 'bianco-toolkit' ),
						'desc'  => esc_html__( 'Setting Logo For Site', 'bianco-toolkit' ),
					),
					'ovic_gmap_api_key'    => array(
						'id'        => 'ovic_gmap_api_key',
						'type'      => 'text',
						'transport' => 'postMessage',
						'title'     => esc_html__( 'Google Map API Key', 'bianco-toolkit' ),
						'desc'      => esc_html__( 'Enter your Google Map API key. ', 'bianco-toolkit' ) . '<a href="' . esc_url( 'https://developers.google.com/maps/documentation/javascript/get-api-key' ) . '" target="_blank">' . esc_html__( 'How to get?', 'bianco-toolkit' ) . '</a>',
					),
					'ovic_theme_lazy_load' => array(
						'id'    => 'ovic_theme_lazy_load',
						'type'  => 'switcher',
						'title' => esc_html__( 'Use image Lazy Load', 'bianco-toolkit' ),
					),
					'ovic_main_color'      => array(
						'id'    => 'ovic_main_color',
						'type'  => 'color_picker',
						'rgba'  => true,
						'title' => esc_html__( 'Main Color', 'bianco-toolkit' ),
					),
					'bianco_bg_color'      => array(
						'id'      => 'bianco_bg_color',
						'title'   => esc_html__( 'Main background color', 'bianco-toolkit' ),
						'desc'    => esc_html__( 'This setting will be applied to every page in your theme', 'bianco-toolkit' ),
						'type'    => 'color_picker',
						'rgba'    => true,
						'default' => '#ffffff',
					),
					'enable_back_to_top'   => array(
						'id'    => 'enable_back_to_top',
						'type'  => 'switcher',
						'title' => esc_html__( 'Enable Back To Top Button', 'bianco-toolkit' ),
					),
					'ovic_ace_script'      => array(
						'id'        => 'ovic_ace_script',
						'transport' => 'postMessage',
						'type'      => 'ace_editor',
						'title'     => esc_html__( 'Editor javascript', 'bianco-toolkit' ),
					),
					'ovic_ace_style'       => array(
						'id'        => 'ovic_ace_style',
						'transport' => 'postMessage',
						'type'      => 'ace_editor',
						'options'   => array(
							'mode' => 'ace/mode/css',
						),
						'title'     => esc_html__( 'Editor Style', 'bianco-toolkit' ),
					),
				),
			);
			$sections['sidebar']       = array(
				'name'   => 'sidebar',
				'title'  => esc_html__( 'Sidebar Settings', 'bianco-toolkit' ),
				'icon'   => 'fa fa-columns',
				'fields' => array(
					array(
						'id'           => 'multi_sidebar',
						'type'         => 'repeater',
						'transport'    => 'postMessage',
						'button_title' => esc_html__( 'Add Sidebar', 'bianco-toolkit' ),
						'title'        => esc_html__( 'Multi Sidebar', 'bianco-toolkit' ),
						'fields'       => array(
							array(
								'id'    => 'add_sidebar',
								'type'  => 'text',
								'title' => esc_html__( 'Name Sidebar', 'bianco-toolkit' ),
							),
						),
					),
				),
			);
			$sections['vertical']      = array(
				'name'   => 'vertical',
				'title'  => esc_html__( 'Vertical Settings', 'bianco-toolkit' ),
				'icon'   => 'fa fa-tasks',
				'fields' => array(
					'ovic_enable_vertical_menu' => array(
						'id'                => 'ovic_enable_vertical_menu',
						'type'              => 'switcher',
						'selective_refresh' => array(
							'selector' => '.vertical-wapper',
						),
						'attributes'        => array(
							'data-depend-id' => 'enable_vertical_menu',
						),
						'title'             => esc_html__( 'Enable Vertical Menu', 'bianco-toolkit' ),
					),
					'ovic_block_vertical_menu'  => array(
						'id'         => 'ovic_block_vertical_menu',
						'type'       => 'select',
						'title'      => esc_html__( 'Vertical Menu Always Open', 'bianco-toolkit' ),
						'options'    => 'page',
						'class'      => 'chosen',
						'attributes' => array(
							'placeholder' => 'Select a page',
							'multiple'    => 'multiple',
							'style'       => 'width:100%',
						),
						'dependency' => array(
							'enable_vertical_menu', '==', true,
						),
						'after'      => '<i class="ovic-text-desc">' . esc_html__( '-- Vertical menu will be always open --', 'bianco-toolkit' ) . '</i>',
					),
					'ovic_vertical_menu_title'  => array(
						'id'         => 'ovic_vertical_menu_title',
						'type'       => 'text',
						'title'      => esc_html__( 'Vertical Menu Title', 'bianco-toolkit' ),
						'dependency' => array(
							'enable_vertical_menu', '==', true,
						),
						'default'    => esc_html__( 'All department', 'bianco-toolkit' ),
					),
					'ovic_vertical_banner'      => array(
						'id'         => 'ovic_vertical_banner',
						'type'       => 'image',
						'title'      => esc_html__( 'Banner Image', 'bianco-toolkit' ),
						'desc'       => esc_html__( 'The banner is displayed at the bottom of the menu', 'bianco-toolkit' ),
						'add_title'  => esc_html__( 'Add Banner', 'bianco-toolkit' ),
						'dependency' => array( 'enable_vertical_menu', '==', true ),
					),
					'ovic_vertical_banner_link' => array(
						'id'         => 'ovic_vertical_banner_link',
						'type'       => 'text',
						'title'      => esc_html__( 'Banner link', 'bianco-toolkit' ),
						'desc'       => esc_html__( 'Link of the banner', 'bianco-toolkit' ),
						'default'    => '#',
						'dependency' => array( 'enable_vertical_menu', '==', true ),
					),
				),
			);
			$sections['header']        = array(
				'name'   => 'header',
				'title'  => esc_html__( 'Header', 'bianco-toolkit' ),
				'icon'   => 'fa fa-puzzle-piece',
				'fields' => array(
					'header_settings'       => array(
						'id'      => 'header_settings',
						'type'    => 'heading',
						'title'   => esc_html__( 'Header Layout', 'bianco-toolkit' ),
						'content' => esc_html__( 'Header Settings', 'bianco-toolkit' ),
					),

					'bianco_used_header'    => array(
						'id'         => 'bianco_used_header',
						'type'       => 'select_preview',
						'title'      => __( 'Header Layout', 'bianco-toolkit' ),
						'desc'       => __( 'Select a header layout', 'bianco-toolkit' ),
						'options'    => $header_options,
						'default'    => 'market',
						'attributes' => array(
							'data-depend-id' => 'bianco_used_header',
						),
					),

					'ovic_sticky_menu'      => array(
						'id'    => 'ovic_sticky_menu',
						'type'  => 'switcher',
						'title' => __( 'Sticky Menu', 'bianco-toolkit' ),
					),

					'bianco_top_left_menu'  => array(
						'id'              => 'bianco_top_left_menu',
						'type'            => 'group',
						'title'           => esc_html__( 'Top Left Menu', 'bianco-toolkit' ),
						'desc'            => esc_html__( 'The vertical menu, That is showed on the top left area of header', 'bianco-toolkit' ),
						'button_title'    => esc_html__( 'Add Item', 'bianco-toolkit' ),
						'accordion_title' => esc_html__( 'Menu Item', 'bianco-toolkit' ),
						'dependency'      => array( 'bianco_used_header', '!=', 'tool' ),
						'fields'          => array(
							array(
								'id'      => 'icon',
								'type'    => 'icon',
								'title'   => esc_html__( 'Icon', 'bianco-toolkit' ),
								'default' => 'fa fa-heart',
							),
							array(
								'id'      => 'label',
								'type'    => 'text',
								'title'   => esc_html__( 'Text', 'bianco-toolkit' ),
								'default' => 'text',
							),
							array(
								'id'      => 'link',
								'type'    => 'text',
								'title'   => esc_html__( 'Link', 'bianco-toolkit' ),
								'default' => '#',
							),
						),
					),

					'bianco_top_right_menu' => array(
						'id'              => 'bianco_top_right_menu',
						'type'            => 'group',
						'title'           => esc_html__( 'Top Right Menu', 'bianco-toolkit' ),
						'desc'            => esc_html__( 'The vertical menu, That is showed on the top right area of header', 'bianco-toolkit' ),
						'button_title'    => esc_html__( 'Add Item', 'bianco-toolkit' ),
						'accordion_title' => esc_html__( 'Menu Item', 'bianco-toolkit' ),
						'fields'          => array(
							array(
								'id'      => 'icon',
								'type'    => 'icon',
								'title'   => esc_html__( 'Icon', 'bianco-toolkit' ),
								'default' => 'fa fa-heart',
							),
							array(
								'id'      => 'label',
								'type'    => 'text',
								'title'   => esc_html__( 'Text', 'bianco-toolkit' ),
								'default' => 'text',
							),
							array(
								'id'      => 'link',
								'type'    => 'text',
								'title'   => esc_html__( 'Link', 'bianco-toolkit' ),
								'default' => '#',
							),
						),
					),

                    'bianco_suport_info'    => array(
                        'id'         => 'bianco_suport_info',
                        'type'       => 'text',
                        'title'      => __( 'Support Info', 'bianco-toolkit' ),
                        'default'    => '24/7 Online Support',
                        'dependency' => array( 'bianco_used_header', 'any', 'digital,child' ),
                    ),
                    'bianco_working_time'    => array(
                        'id'         => 'bianco_working_time',
                        'type'       => 'text',
                        'title'      => __( 'Working time:', 'bianco-toolkit' ),
                        'default'    => 'Mon: 8:00am-8:00pm; Sat-Sun:(none)',
                        'dependency' => array( 'bianco_used_header', '==', 'tool' ),
                    ),
                    'bianco_phone_number'    => array(
                        'id'         => 'bianco_phone_number',
                        'type'       => 'text',
                        'title'      => __( 'Tell: ', 'bianco-toolkit' ),
                        'default'    => '(+900) 123 567 911',
                        'dependency' => array( 'bianco_used_header', '==', 'tool' ),
                    ),
				),
			);
			$sections['herro_section'] = array(
				'name'   => 'herro_section',
				'title'  => esc_html__( 'Herro section', 'bianco-toolkit' ),
				'icon'   => 'fa fa-puzzle-piece',
				'fields' => array(
					'bianco_used_hero_banner'  => array(
						'id'         => 'bianco_used_hero_banner',
						'type'       => 'switcher',
						'default'    => false,
						'title'      => esc_html__( 'Hero Section', 'bianco-toolkit' ),
						'attributes' => array( 'data-depend-id' => 'bianco_used_hero_banner' ),
					),
					'bianco_used_hero_type'   => array(
						'id'         => 'bianco_used_hero_type',
						'type'       => 'select',
						'title'      => esc_html__( 'Type', 'bianco-toolkit' ),
						'options'    => $arr_hero_types,
						'default'    => 'banner',
						'dependency' => array( 'bianco_used_hero_banner', '==', 'true' ),
						'attributes' => array( 'data-depend-id' => 'bianco_used_hero_type' ),
					),
					'bianco_rev_hero'    => array(
						'id'         => 'bianco_rev_hero',
						'type'       => 'select',
						'title'      => esc_html__( 'Revolution Slider', 'bianco-toolkit' ),
						'options'    => $revolution_alias,
						'dependency' => array( 'bianco_used_hero_banner|bianco_used_hero_type', '==|==', 'true|rev_slider' ),
						'default'    => '',
					),
					'bianco_hero_image' => array(
						'id'         => 'bianco_hero_image',
						'type'       => 'image',
						'title'      => esc_html__( 'Banner Image', 'bianco-toolkit' ),
						'add_title'  => esc_html__( 'Add Banner', 'bianco-toolkit' ),
						'dependency' => array( 'bianco_used_hero_banner|bianco_used_hero_type', '==|==', 'true|banner' ),
					),
				),
			);
			$sections['footer']        = array(
				'name'   => 'footer',
				'title'  => esc_html__( 'Footer', 'bianco-toolkit' ),
				'icon'   => 'fa fa-puzzle-piece',
				'fields' => array(
					'footer_settings' => array(
						'id'      => 'footer_settings',
						'type'    => 'heading',
						'content' => esc_html__( 'Footer Settings', 'bianco-toolkit' ),
					),
				),
			);
			$sections['blog']          = array(
				'name'   => 'blog',
				'title'  => esc_html__( 'Blog', 'bianco-toolkit' ),
				'icon'   => 'fa fa-folder-open-o',
				'fields' => array(
					'ovic_blog_list_style'     => array(
						'id'      => 'ovic_blog_list_style',
						'type'    => 'select',
						'title'   => esc_html__( 'Blog Style', 'bianco-toolkit' ),
						'options' => array(
							'default'  => esc_html__( 'Default', 'bianco-toolkit' ),
							'grid'     => esc_html__( 'Grid', 'bianco-toolkit' ),
						),
						'default' => 'default',
					),
                    'bianco_used_socials_media'      => array(
                        'id'         => 'bianco_used_socials_media',
                        'type'       => 'switcher',
                        'default'    => false,
                        'title'      => esc_html__( 'Socail Media', 'bianco-toolkit' ),
                        'dependency' => array( 'ovic_blog_list_style', '==', 'grid' ),
                    ),
					'ovic_sidebar_blog_layout' => array(
						'id'                => 'ovic_sidebar_blog_layout',
						'type'              => 'image_select',
						'title'             => esc_html__( 'Sidebar Blog Layout', 'bianco-toolkit' ),
						'desc'              => esc_html__( 'Select sidebar position on Blog.', 'bianco-toolkit' ),
						'options'           => array(
							'left'  => esc_attr( ' data:image/png;base64,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' ),
							'right' => esc_attr( ' data:image/png;base64,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' ),
							'full'  => esc_attr( ' data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAkCAYAAAAdFbNSAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKT2lDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2AfkIaKOg6OIisr74Xuja9a89+bN/rXXPues852zzwfACAyWSDNRNYAMqUIeEeCDx8TG4eQuQIEKJHAAEAizZCFz/SMBAPh+PDwrIsAHvgABeNMLCADATZvAMByH/w/qQplcAYCEAcB0kThLCIAUAEB6jkKmAEBGAYCdmCZTAKAEAGDLY2LjAFAtAGAnf+bTAICd+Jl7AQBblCEVAaCRACATZYhEAGg7AKzPVopFAFgwABRmS8Q5ANgtADBJV2ZIALC3AMDOEAuyAAgMADBRiIUpAAR7AGDIIyN4AISZABRG8lc88SuuEOcqAAB4mbI8uSQ5RYFbCC1xB1dXLh4ozkkXKxQ2YQJhmkAuwnmZGTKBNA/g88wAAKCRFRHgg/P9eM4Ors7ONo62Dl8t6r8G/yJiYuP+5c+rcEAAAOF0ftH+LC+zGoA7BoBt/qIl7gRoXgugdfeLZrIPQLUAoOnaV/Nw+H48PEWhkLnZ2eXk5NhKxEJbYcpXff5nwl/AV/1s+X48/Pf14L7iJIEyXYFHBPjgwsz0TKUcz5IJhGLc5o9H/LcL//wd0yLESWK5WCoU41EScY5EmozzMqUiiUKSKcUl0v9k4t8s+wM+3zUAsGo+AXuRLahdYwP2SycQWHTA4vcAAPK7b8HUKAgDgGiD4c93/+8//UegJQCAZkmScQAAXkQkLlTKsz/HCAAARKCBKrBBG/TBGCzABhzBBdzBC/xgNoRCJMTCQhBCCmSAHHJgKayCQiiGzbAdKmAv1EAdNMBRaIaTcA4uwlW4Dj1wD/phCJ7BKLyBCQRByAgTYSHaiAFiilgjjggXmYX4IcFIBBKLJCDJiBRRIkuRNUgxUopUIFVIHfI9cgI5h1xGupE7yAAygvyGvEcxlIGyUT3UDLVDuag3GoRGogvQZHQxmo8WoJvQcrQaPYw2oefQq2gP2o8+Q8cwwOgYBzPEbDAuxsNCsTgsCZNjy7EirAyrxhqwVqwDu4n1Y8+xdwQSgUXACTYEd0IgYR5BSFhMWE7YSKggHCQ0EdoJNwkDhFHCJyKTqEu0JroR+cQYYjIxh1hILCPWEo8TLxB7iEPENyQSiUMyJ7mQAkmxpFTSEtJG0m5SI+ksqZs0SBojk8naZGuyBzmULCAryIXkneTD5DPkG+Qh8lsKnWJAcaT4U+IoUspqShnlEOU05QZlmDJBVaOaUt2ooVQRNY9aQq2htlKvUYeoEzR1mjnNgxZJS6WtopXTGmgXaPdpr+h0uhHdlR5Ol9BX0svpR+iX6AP0dwwNhhWDx4hnKBmbGAcYZxl3GK+YTKYZ04sZx1QwNzHrmOeZD5lvVVgqtip8FZHKCpVKlSaVGyovVKmqpqreqgtV81XLVI+pXlN9rkZVM1PjqQnUlqtVqp1Q61MbU2epO6iHqmeob1Q/pH5Z/YkGWcNMw09DpFGgsV/jvMYgC2MZs3gsIWsNq4Z1gTXEJrHN2Xx2KruY/R27iz2qqaE5QzNKM1ezUvOUZj8H45hx+Jx0TgnnKKeX836K3hTvKeIpG6Y0TLkxZVxrqpaXllirSKtRq0frvTau7aedpr1Fu1n7gQ5Bx0onXCdHZ4/OBZ3nU9lT3acKpxZNPTr1ri6qa6UbobtEd79up+6Ynr5egJ5Mb6feeb3n+hx9L/1U/W36p/VHDFgGswwkBtsMzhg8xTVxbzwdL8fb8VFDXcNAQ6VhlWGX4YSRudE8o9VGjUYPjGnGXOMk423GbcajJgYmISZLTepN7ppSTbmmKaY7TDtMx83MzaLN1pk1mz0x1zLnm+eb15vft2BaeFostqi2uGVJsuRaplnutrxuhVo5WaVYVVpds0atna0l1rutu6cRp7lOk06rntZnw7Dxtsm2qbcZsOXYBtuutm22fWFnYhdnt8Wuw+6TvZN9un2N/T0HDYfZDqsdWh1+c7RyFDpWOt6azpzuP33F9JbpL2dYzxDP2DPjthPLKcRpnVOb00dnF2e5c4PziIuJS4LLLpc+Lpsbxt3IveRKdPVxXeF60vWdm7Obwu2o26/uNu5p7ofcn8w0nymeWTNz0MPIQ+BR5dE/C5+VMGvfrH5PQ0+BZ7XnIy9jL5FXrdewt6V3qvdh7xc+9j5yn+M+4zw33jLeWV/MN8C3yLfLT8Nvnl+F30N/I/9k/3r/0QCngCUBZwOJgUGBWwL7+Hp8Ib+OPzrbZfay2e1BjKC5QRVBj4KtguXBrSFoyOyQrSH355jOkc5pDoVQfujW0Adh5mGLw34MJ4WHhVeGP45wiFga0TGXNXfR3ENz30T6RJZE3ptnMU85ry1KNSo+qi5qPNo3ujS6P8YuZlnM1VidWElsSxw5LiquNm5svt/87fOH4p3iC+N7F5gvyF1weaHOwvSFpxapLhIsOpZATIhOOJTwQRAqqBaMJfITdyWOCnnCHcJnIi/RNtGI2ENcKh5O8kgqTXqS7JG8NXkkxTOlLOW5hCepkLxMDUzdmzqeFpp2IG0yPTq9MYOSkZBxQqohTZO2Z+pn5mZ2y6xlhbL+xW6Lty8elQfJa7OQrAVZLQq2QqboVFoo1yoHsmdlV2a/zYnKOZarnivN7cyzytuQN5zvn//tEsIS4ZK2pYZLVy0dWOa9rGo5sjxxedsK4xUFK4ZWBqw8uIq2Km3VT6vtV5eufr0mek1rgV7ByoLBtQFr6wtVCuWFfevc1+1dT1gvWd+1YfqGnRs+FYmKrhTbF5cVf9go3HjlG4dvyr+Z3JS0qavEuWTPZtJm6ebeLZ5bDpaql+aXDm4N2dq0Dd9WtO319kXbL5fNKNu7g7ZDuaO/PLi8ZafJzs07P1SkVPRU+lQ27tLdtWHX+G7R7ht7vPY07NXbW7z3/T7JvttVAVVN1WbVZftJ+7P3P66Jqun4lvttXa1ObXHtxwPSA/0HIw6217nU1R3SPVRSj9Yr60cOxx++/p3vdy0NNg1VjZzG4iNwRHnk6fcJ3/ceDTradox7rOEH0x92HWcdL2pCmvKaRptTmvtbYlu6T8w+0dbq3nr8R9sfD5w0PFl5SvNUyWna6YLTk2fyz4ydlZ19fi753GDborZ752PO32oPb++6EHTh0kX/i+c7vDvOXPK4dPKy2+UTV7hXmq86X23qdOo8/pPTT8e7nLuarrlca7nuer21e2b36RueN87d9L158Rb/1tWeOT3dvfN6b/fF9/XfFt1+cif9zsu72Xcn7q28T7xf9EDtQdlD3YfVP1v+3Njv3H9qwHeg89HcR/cGhYPP/pH1jw9DBY+Zj8uGDYbrnjg+OTniP3L96fynQ89kzyaeF/6i/suuFxYvfvjV69fO0ZjRoZfyl5O/bXyl/erA6xmv28bCxh6+yXgzMV70VvvtwXfcdx3vo98PT+R8IH8o/2j5sfVT0Kf7kxmTk/8EA5jz/GMzLdsAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAAAHpJREFUeNrs2TEOgCAMRuGHYcYT6Mr9j8PsCfQCuDAY42pCk/cvXRi+Nkxt6r0TLRmgtfaUX8BMnaRRC3DUWvf88ahMPOQNYAn2M86IaESLFi1atGjRokWLFi1atGjRokWLFi36r6wwluqvTL1UB0gRzxc3AAAA//8DAMyCEVUq/bK3AAAAAElFTkSuQmCC' ),
						),
						'selective_refresh' => array(
							'selector' => '.main-content',
						),
						'default'           => 'left',
					),
					'ovic_blog_used_sidebar'   => array(
						'id'         => 'ovic_blog_used_sidebar',
						'type'       => 'select',
						'default'    => 'widget-area',
						'title'      => esc_html__( 'Blog Sidebar', 'bianco-toolkit' ),
						'options'    => ovic_sidebar_options(),
						'dependency' => array( 'ovic_sidebar_blog_layout_full', '==', false ),
					),
					'ovic_blog_bg_items'       => array(
						'id'         => 'ovic_blog_bg_items',
						'type'       => 'select',
						'title'      => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device >= 1500px )', 'bianco-toolkit' ),
						'options'    => array(
							'12' => esc_html__( '1 item', 'bianco-toolkit' ),
							'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
							'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
							'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
							'15' => esc_html__( '5 items', 'bianco-toolkit' ),
							'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
						),
						'default'    => '4',
						'dependency' => array( 'ovic_blog_list_style', '==', 'grid' ),
					),
					'ovic_blog_lg_items'       => array(
						'id'         => 'ovic_blog_lg_items',
						'default'    => '4',
						'type'       => 'select',
						'title'      => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'bianco-toolkit' ),
						'options'    => array(
							'12' => esc_html__( '1 item', 'bianco-toolkit' ),
							'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
							'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
							'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
							'15' => esc_html__( '5 items', 'bianco-toolkit' ),
							'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
						),
						'dependency' => array( 'ovic_blog_list_style', '==', 'grid' ),
					),
					'ovic_blog_md_items'       => array(
						'id'         => 'ovic_blog_md_items',
						'default'    => '4',
						'type'       => 'select',
						'title'      => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'bianco-toolkit' ),
						'options'    => array(
							'12' => esc_html__( '1 item', 'bianco-toolkit' ),
							'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
							'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
							'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
							'15' => esc_html__( '5 items', 'bianco-toolkit' ),
							'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
						),
						'dependency' => array( 'ovic_blog_list_style', '==', 'grid' ),
					),
					'ovic_blog_sm_items'       => array(
						'id'         => 'ovic_blog_sm_items',
						'default'    => '4',
						'type'       => 'select',
						'title'      => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'bianco-toolkit' ),
						'options'    => array(
							'12' => esc_html__( '1 item', 'bianco-toolkit' ),
							'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
							'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
							'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
							'15' => esc_html__( '5 items', 'bianco-toolkit' ),
							'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
						),
						'dependency' => array( 'ovic_blog_list_style', '==', 'grid' ),
					),
					'ovic_blog_xs_items'       => array(
						'id'         => 'ovic_blog_xs_items',
						'default'    => '6',
						'type'       => 'select',
						'title'      => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'bianco-toolkit' ),
						'options'    => array(
							'12' => esc_html__( '1 item', 'bianco-toolkit' ),
							'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
							'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
							'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
							'15' => esc_html__( '5 items', 'bianco-toolkit' ),
							'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
						),
						'dependency' => array( 'ovic_blog_list_style', '==', 'grid' ),
					),
					'ovic_blog_ts_items'       => array(
						'id'         => 'ovic_blog_ts_items',
						'default'    => '12',
						'type'       => 'select',
						'title'      => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device < 480px)', 'bianco-toolkit' ),
						'options'    => array(
							'12' => esc_html__( '1 item', 'bianco-toolkit' ),
							'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
							'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
							'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
							'15' => esc_html__( '5 items', 'bianco-toolkit' ),
							'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
						),
						'dependency' => array( 'ovic_blog_list_style', '==', 'grid' ),
					),
				),
			);
			$sections['blog_single']   = array(
				'name'   => 'blog_single',
				'title'  => esc_html__( 'Blog Single', 'bianco-toolkit' ),
				'icon'   => 'fa fa-file-text-o',
				'fields' => array(
					'ovic_sidebar_single_layout'     => array(
						'id'      => 'ovic_sidebar_single_layout',
						'type'    => 'image_select',
						'default' => 'left',
						'title'   => esc_html__( ' Sidebar Single Post Layout', 'bianco-toolkit' ),
						'desc'    => esc_html__( 'Select sidebar position on Blog.', 'bianco-toolkit' ),
						'options' => array(
							'left'  => esc_attr( ' data:image/png;base64,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' ),
							'right' => esc_attr( ' data:image/png;base64,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' ),
							'full'  => esc_attr( ' data:image/png;base64,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' ),
						),
					),
					'ovic_single_used_sidebar'       => array(
						'id'         => 'ovic_single_used_sidebar',
						'type'       => 'select',
						'default'    => 'widget-area',
						'title'      => esc_html__( 'Blog Single Sidebar', 'bianco-toolkit' ),
						'options'    => ovic_sidebar_options(),
						'dependency' => array( 'ovic_sidebar_single_layout_full', '==', false ),
					),
					'bianco_used_related_posts'      => array(
						'id'         => 'bianco_used_related_posts',
						'type'       => 'switcher',
						'default'    => false,
						'title'      => esc_html__( 'Related posts', 'bianco-toolkit' ),
						'attributes' => array( 'data-depend-id' => 'bianco_used_related_posts' ),
					),
                    'bianco_used_socials_media_in_single'      => array(
						'id'         => 'bianco_used_socials_media_in_single',
						'type'       => 'switcher',
						'default'    => false,
						'title'      => esc_html__( 'Socail Media', 'bianco-toolkit' ),
					),
					'bianco_related_title'           => array(
						'id'         => 'bianco_related_title',
						'type'       => 'text',
						'default'    => 'Post you’d might like',
						'title'      => esc_html__( 'Related posts', 'bianco-toolkit' ),
						'dependency' => array( 'bianco_used_related_posts', '==', 'true' ),
					),
					'bianco_single_related_ls_items' => array(
						'id'         => 'bianco_single_related_ls_items',
						'type'       => 'select',
						'title'      => esc_html__( 'Related products items per row on Desktop', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device >= 1500px )', 'bianco-toolkit' ),
						'options'    => $carousel_options,
						'default'    => 2,
						'dependency' => array( 'bianco_used_related_posts', '==', 'true' ),
					),
					'bianco_single_related_lg_items' => array(
						'id'         => 'bianco_single_related_lg_items',
						'type'       => 'select',
						'title'      => esc_html__( 'Related products items per row on Desktop', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'bianco-toolkit' ),
						'options'    => $carousel_options,
						'default'    => 2,
						'dependency' => array( 'bianco_used_related_posts', '==', 'true' ),
					),
					'bianco_single_related_md_items' => array(
						'id'         => 'bianco_single_related_md_items',
						'type'       => 'select',
						'title'      => esc_html__( 'Related products items per row on Desktop', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'bianco-toolkit' ),
						'options'    => $carousel_options,
						'default'    => 2,
						'dependency' => array( 'bianco_used_related_posts', '==', 'true' ),
					),
					'bianco_single_related_sm_items' => array(
						'id'         => 'bianco_single_related_sm_items',
						'type'       => 'select',
						'title'      => esc_html__( 'Related products items per row on Desktop', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'bianco-toolkit' ),
						'options'    => $carousel_options,
						'default'    => 2,
						'dependency' => array( 'bianco_used_related_posts', '==', 'true' ),
					),
					'bianco_single_related_xs_items' => array(
						'id'         => 'bianco_single_related_xs_items',
						'type'       => 'select',
						'title'      => esc_html__( 'Related products items per row on Desktop', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'bianco-toolkit' ),
						'options'    => $carousel_options,
						'default'    => 2,
						'dependency' => array( 'bianco_used_related_posts', '==', 'true' ),
					),
					'bianco_single_related_ts_items' => array(
						'id'         => 'bianco_single_related_ts_items',
						'type'       => 'select',
						'title'      => esc_html__( 'Related products items per row on Desktop', 'bianco-toolkit' ),
						'desc'       => esc_html__( '(Screen resolution of device < 480px)', 'bianco-toolkit' ),
						'options'    => $carousel_options,
						'default'    => 2,
						'dependency' => array( 'bianco_used_related_posts', '==', 'true' ),
					),
				),
			);
			if ( class_exists( 'WooCommerce' ) ) :
				$sections['woocommerce']       = array(
					'name'   => 'woocommerce',
					'title'  => esc_html__( 'WooCommerce', 'bianco-toolkit' ),
					'icon'   => 'fa fa-opencart ',
					'fields' => array(
						'ovic_woo_enable_ajax' => array(
							'id'    => 'ovic_woo_enable_ajax',
							'type'  => 'switcher',
							'title' => esc_html__( 'Enable Ajax WooCommerce', 'bianco-toolkit' ),
						),
						array(
							'id'      => 'ovic_show_categories_on_hero_baner',
							'type'    => 'switcher',
							'title'   => esc_html__( 'Show Category Info On Hero Banner', 'bianco-toolkit' ),
							'default' => false,
						),
						array(
							'id'             => 'ovic_chose_category_for_hero_banner',
							'type'           => 'select',
							'title'          => esc_html__( 'Chose Product Categories', 'bianco-toolkit' ),
							'options'        => 'categories',
							'class'          => 'chosen',
							'attributes'     => array(
								'multiple'    => 'multiple',
								'style'       => 'width:100%',
								'placeholder' => esc_html__( 'Select some product category', 'bianco-toolkit' ),
							),
							'query_args'     => array(
								'type'     => 'product',
								'taxonomy' => 'product_cat',
								'orderby'  => 'post_date',
								'order'    => 'DESC',
							),
							'default_option' => esc_html__( 'Select category', 'bianco-toolkit' ),
							'dependency'     => array( 'ovic_show_categories_on_hero_baner', '==', true ),
						),
						array(
							'id'      => 'ovic_product_newness',
							'default' => '10',
							'type'    => 'number',
							'title'   => esc_html__( 'Products Newness', 'bianco-toolkit' ),
						),
						array(
							'id'      => 'ovic_sidebar_shop_layout',
							'type'    => 'image_select',
							'default' => 'left',
							'title'   => esc_html__( 'Shop Page Sidebar Layout', 'bianco-toolkit' ),
							'desc'    => esc_html__( 'Select sidebar position on Shop Page.', 'bianco-toolkit' ),
							'options' => array(
								'left'  => esc_attr( ' data:image/png;base64,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' ),
								'right' => esc_attr( ' data:image/png;base64,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' ),
								'full'  => esc_attr( ' data:image/png;base64,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' ),
							),
						),
						array(
							'id'         => 'ovic_shop_used_sidebar',
							'type'       => 'select',
							'title'      => esc_html__( 'Sidebar Used For Shop', 'bianco-toolkit' ),
							'options'    => ovic_sidebar_options(),
							'dependency' => array( 'ovic_sidebar_shop_layout_full', '==', false ),
						),
						array(
							'id'                => 'ovic_shop_list_style',
							'type'              => 'image_select',
							'default'           => 'grid',
							'selective_refresh' => array(
								'selector' => '.grid-view-mode',
							),
							'title'             => esc_html__( 'Shop Default Layout', 'bianco-toolkit' ),
							'desc'              => esc_html__( 'Select default layout for shop, product category archive.', 'bianco-toolkit' ),
							'options'           => array(
								'grid' => esc_attr( ' data:image/png;base64,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' ),
								'list' => esc_attr( ' data:image/png;base64,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' ),
							),
						),
						array(
							'id'      => 'ovic_product_per_page',
							'type'    => 'number',
							'default' => '10',
							'title'   => esc_html__( 'Products perpage', 'bianco-toolkit' ),
							'desc'    => esc_html__( 'Number of products on shop page.', 'bianco-toolkit' ),
						),
						array(
							'id'      => 'ovic_shop_product_style',
							'type'    => 'select_preview',
							'default' => '1',
							'title'   => esc_html__( 'Product Shop Layout', 'bianco-toolkit' ),
							'desc'    => esc_html__( 'Select a Product layout in shop page', 'bianco-toolkit' ),
							'options' => ovic_product_options( 'Theme Option' ),
						),
						array(
							'id'      => 'product_carousel',
							'type'    => 'heading',
							'content' => esc_html__( 'Grid Settings', 'bianco-toolkit' ),
						),
						array(
							'id'      => 'ovic_woo_bg_items',
							'type'    => 'select',
							'title'   => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device >= 1500px )', 'bianco-toolkit' ),
							'options' => array(
								'12' => esc_html__( '1 item', 'bianco-toolkit' ),
								'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
								'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
								'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
								'15' => esc_html__( '5 items', 'bianco-toolkit' ),
								'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
							),
							'default' => '4',
						),
						array(
							'id'      => 'ovic_woo_lg_items',
							'type'    => 'select',
							'title'   => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'bianco-toolkit' ),
							'options' => array(
								'12' => esc_html__( '1 item', 'bianco-toolkit' ),
								'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
								'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
								'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
								'15' => esc_html__( '5 items', 'bianco-toolkit' ),
								'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
							),
							'default' => '4',
						),
						array(
							'id'      => 'ovic_woo_md_items',
							'type'    => 'select',
							'title'   => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'bianco-toolkit' ),
							'options' => array(
								'12' => esc_html__( '1 item', 'bianco-toolkit' ),
								'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
								'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
								'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
								'15' => esc_html__( '5 items', 'bianco-toolkit' ),
								'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
							),
							'default' => '4',
						),
						array(
							'id'      => 'ovic_woo_sm_items',
							'type'    => 'select',
							'title'   => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'bianco-toolkit' ),
							'options' => array(
								'12' => esc_html__( '1 item', 'bianco-toolkit' ),
								'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
								'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
								'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
								'15' => esc_html__( '5 items', 'bianco-toolkit' ),
								'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
							),
							'default' => '4',
						),
						array(
							'id'      => 'ovic_woo_xs_items',
							'type'    => 'select',
							'title'   => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'bianco-toolkit' ),
							'options' => array(
								'12' => esc_html__( '1 item', 'bianco-toolkit' ),
								'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
								'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
								'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
								'15' => esc_html__( '5 items', 'bianco-toolkit' ),
								'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
							),
							'default' => '6',
						),
						array(
							'id'      => 'ovic_woo_ts_items',
							'type'    => 'select',
							'title'   => esc_html__( 'Items per row on Desktop( For grid mode )', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device < 480px)', 'bianco-toolkit' ),
							'options' => array(
								'12' => esc_html__( '1 item', 'bianco-toolkit' ),
								'6'  => esc_html__( '2 items', 'bianco-toolkit' ),
								'4'  => esc_html__( '3 items', 'bianco-toolkit' ),
								'3'  => esc_html__( '4 items', 'bianco-toolkit' ),
								'15' => esc_html__( '5 items', 'bianco-toolkit' ),
								'2'  => esc_html__( '6 items', 'bianco-toolkit' ),
							),
							'default' => '12',
						),
					),
				);
				$sections['single_product']    = array(
					'id'   => 'single_product',
					'name'   => 'single_product',
					'title'  => esc_html__( 'Single Products', 'bianco-toolkit' ),
					'icon'   => 'fa fa-cubes',
					'fields' => array(
						'ovic_sidebar_single_product_layout' => array(
							'id'      => 'ovic_sidebar_single_product_layout',
							'type'    => 'image_select',
							'title'   => esc_html__( 'Single Product Sidebar Position', 'bianco-toolkit' ),
							'desc'    => esc_html__( 'Select sidebar position on single product page.', 'bianco-toolkit' ),
							'options' => array(
								'left'  => esc_attr( ' data:image/png;base64,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' ),
								'right' => esc_attr( ' data:image/png;base64,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' ),
								'full'  => esc_attr( ' data:image/png;base64,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' ),
							),
							'default' => 'left',
						),
						'ovic_single_product_used_addthis'   => array(
							'id'    => 'ovic_single_product_used_addthis',
							'type'  => 'switcher',
							'title' => esc_html__( 'Enable Share Toolbar', 'bianco-toolkit' ),
							'desc'  => esc_html__( 'Enable to Show sharing toolbar on the individual product summary', 'bianco-toolkit' ),
                            'default' => false,
						),
                        'ovic_single_product_used_social_follow'   => array(
                            'id'    => 'ovic_single_product_used_social_follow',
                            'type'  => 'switcher',
                            'default' => false,
                            'title' => esc_html__( 'Enable Social Follow', 'bianco-toolkit' ),
                            'desc'  => esc_html__( 'That is showing on product meta', 'bianco-toolkit' ),
                        ),
						'ovic_single_product_used_sidebar'   => array(
							'id'         => 'ovic_single_product_used_sidebar',
							'type'       => 'select',
							'title'      => esc_html__( 'Sidebar Used For Single Product', 'bianco-toolkit' ),
							'options'    => ovic_sidebar_options(),
							'dependency' => array( 'ovic_sidebar_single_product_layout_full', '==', false ),
						),
						'ovic_product_thumbnail_ls_items'    => array(
							'id'      => 'ovic_product_thumbnail_ls_items',
							'type'    => 'slider',
							'title'   => esc_html__( 'Thumbnail items per row on Desktop', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device >= 1500px )', 'bianco-toolkit' ),
							'options' => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default' => '4',
						),
						'ovic_product_thumbnail_lg_items'    => array(
							'id'      => 'ovic_product_thumbnail_lg_items',
							'type'    => 'slider',
							'title'   => esc_html__( 'Thumbnail items per row on Desktop', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'bianco-toolkit' ),
							'options' => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default' => '4',
						),
						'ovic_product_thumbnail_md_items'    => array(
							'id'      => 'ovic_product_thumbnail_md_items',
							'type'    => 'slider',
							'title'   => esc_html__( 'Thumbnail items per row on landscape tablet', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'bianco-toolkit' ),
							'options' => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default' => '3',
						),
						'ovic_product_thumbnail_sm_items'    => array(
							'id'      => 'ovic_product_thumbnail_sm_items',
							'type'    => 'slider',
							'title'   => esc_html__( 'Thumbnail items per row on portrait tablet', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'bianco-toolkit' ),
							'options' => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default' => '2',
						),
						'ovic_product_thumbnail_xs_items'    => array(
							'id'      => 'ovic_product_thumbnail_xs_items',
							'type'    => 'slider',
							'title'   => esc_html__( 'Thumbnail items per row on Mobile', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'bianco-toolkit' ),
							'options' => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default' => '1',
						),
						'ovic_product_thumbnail_ts_items'    => array(
							'id'      => 'ovic_product_thumbnail_ts_items',
							'type'    => 'slider',
							'title'   => esc_html__( 'Thumbnail items per row on Mobile', 'bianco-toolkit' ),
							'desc'    => esc_html__( '(Screen resolution of device < 480px)', 'bianco-toolkit' ),
							'options' => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default' => '1',
						),
					),
				);
				$sections['related_product']   = array(
					'parent'   => 'single_product',
					'name'   => 'ovic_related_product',
					'title'  => esc_html__( 'Related Products', 'bianco-toolkit' ),
					'icon'   => 'fa fa-link',
					'fields' => array(
						'ovic_woo_related_enable'             => array(
							'id'                => 'ovic_woo_related_enable',
							'type'              => 'select',
							'default'           => 'enable',
							'options'           => array(
								'enable'  => esc_html__( 'Enable', 'bianco-toolkit' ),
								'disable' => esc_html__( 'Disable', 'bianco-toolkit' ),
							),
							'selective_refresh' => array(
								'selector' => '.ovic_woo_related-product',
							),
							'title'             => esc_html__( 'Enable Related Products', 'bianco-toolkit' ),
						),
						'ovic_woo_related_products_title'     => array(
							'id'         => 'ovic_woo_related_products_title',
							'type'       => 'text',
							'title'      => esc_html__( 'Related products title', 'bianco-toolkit' ),
							'desc'       => esc_html__( 'Related products title', 'bianco-toolkit' ),
							'dependency' => array( 'ovic_woo_related_enable', '==', 'enable' ),
							'default'    => esc_html__( 'Related Products', 'bianco-toolkit' ),
						),
						'ovic_woo_related_max_product_number' => array(
							'id'         => 'ovic_woo_related_max_product_number',
							'type'       => 'number',
							'title'      => esc_html__( 'Max product number', 'bianco-toolkit' ),
							'desc'       => esc_html__( 'Limit number of product list', 'bianco-toolkit' ),
							'dependency' => array( 'ovic_woo_related_enable', '==', 'enable' ),
							'default'    => 8,
						),
						'ovic_woo_related_ls_items'           => array(
							'id'         => 'ovic_woo_related_ls_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Related products items per row on Desktop', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >= 1500px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '3',
							'dependency' => array( 'ovic_woo_related_enable', '==', 'enable' ),
						),
						'ovic_woo_related_lg_items'           => array(
							'id'         => 'ovic_woo_related_lg_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Related products items per row on Desktop', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '3',
							'dependency' => array( 'ovic_woo_related_enable', '==', 'enable' ),
						),
						'ovic_woo_related_md_items'           => array(
							'id'         => 'ovic_woo_related_md_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Related products items per row on landscape tablet', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '3',
							'dependency' => array( 'ovic_woo_related_enable', '==', 'enable' ),
						),
						'ovic_woo_related_sm_items'           => array(
							'id'         => 'ovic_woo_related_sm_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Related product items per row on portrait tablet', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '2',
							'dependency' => array( 'ovic_woo_related_enable', '==', 'enable' ),
						),
						'ovic_woo_related_xs_items'           => array(
							'id'         => 'ovic_woo_related_xs_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Related products items per row on Mobile', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '1',
							'dependency' => array( 'ovic_woo_related_enable', '==', 'enable' ),
						),
						'ovic_woo_related_ts_items'           => array(
							'id'         => 'ovic_woo_related_ts_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Related products items per row on Mobile', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device < 480px)', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '1',
							'dependency' => array( 'ovic_woo_related_enable', '==', 'enable' ),
						),
					),
				);
				$sections['crosssell_product'] = array(
					'name'   => 'crosssell_product',
					'title'  => esc_html__( 'Cross Sell Products', 'bianco-toolkit' ),
					'icon'   => 'fa fa-arrows-alt',
					'fields' => array(
						'ovic_woo_crosssell_enable'         => array(
							'id'                => 'ovic_woo_crosssell_enable',
							'type'              => 'select',
							'default'           => 'enable',
							'options'           => array(
								'enable'  => esc_html__( 'Enable', 'bianco-toolkit' ),
								'disable' => esc_html__( 'Disable', 'bianco-toolkit' ),
							),
							'selective_refresh' => array(
								'selector' => '.ovic_woo_crosssell-product',
							),
							'title'             => esc_html__( 'Enable Cross Sell Products', 'bianco-toolkit' ),
						),
						'ovic_woo_crosssell_products_title' => array(
							'id'         => 'ovic_woo_crosssell_products_title',
							'type'       => 'text',
							'title'      => esc_html__( 'Cross Sell products title', 'bianco-toolkit' ),
							'desc'       => esc_html__( 'Cross Sell products title', 'bianco-toolkit' ),
							'dependency' => array( 'ovic_woo_crosssell_enable', '==', 'enable' ),
							'default'    => esc_html__( 'Cross Sell Products', 'bianco-toolkit' ),
						),
						'ovic_woo_crosssell_ls_items'       => array(
							'id'         => 'ovic_woo_crosssell_ls_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Cross Sell products items per row on Desktop', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >= 1500px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '3',
							'dependency' => array( 'ovic_woo_crosssell_enable', '==', 'enable' ),
						),
						'ovic_woo_crosssell_lg_items'       => array(
							'id'         => 'ovic_woo_crosssell_lg_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Cross Sell products items per row on Desktop', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '3',
							'dependency' => array( 'ovic_woo_crosssell_enable', '==', 'enable' ),
						),
						'ovic_woo_crosssell_md_items'       => array(
							'id'         => 'ovic_woo_crosssell_md_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Cross Sell products items per row on landscape tablet', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '3',
							'dependency' => array( 'ovic_woo_crosssell_enable', '==', 'enable' ),
						),
						'ovic_woo_crosssell_sm_items'       => array(
							'id'         => 'ovic_woo_crosssell_sm_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Cross Sell product items per row on portrait tablet', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '2',
							'dependency' => array( 'ovic_woo_crosssell_enable', '==', 'enable' ),
						),
						'ovic_woo_crosssell_xs_items'       => array(
							'id'         => 'ovic_woo_crosssell_xs_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Cross Sell products items per row on Mobile', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '1',
							'dependency' => array( 'ovic_woo_crosssell_enable', '==', 'enable' ),
						),
						'ovic_woo_crosssell_ts_items'       => array(
							'id'         => 'ovic_woo_crosssell_ts_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Cross Sell products items per row on Mobile', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device < 480px)', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '1',
							'dependency' => array( 'ovic_woo_crosssell_enable', '==', 'enable' ),
						),
					),
				);
				$sections['upsell_product']    = array(
					'name'   => 'upsell_product',
					'title'  => esc_html__( 'Upsell Products', 'bianco-toolkit' ),
					'icon'   => 'fa fa-reply-all',
					'fields' => array(
						'ovic_woo_upsell_enable'         => array(
							'id'                => 'ovic_woo_upsell_enable',
							'type'              => 'select',
							'default'           => 'enable',
							'options'           => array(
								'enable'  => esc_html__( 'Enable', 'bianco-toolkit' ),
								'disable' => esc_html__( 'Disable', 'bianco-toolkit' ),
							),
							'selective_refresh' => array(
								'selector' => '.ovic_woo_upsell-product',
							),
							'title'             => esc_html__( 'Enable Upsell Products', 'bianco-toolkit' ),
						),
						'ovic_woo_upsell_products_title' => array(
							'id'         => 'ovic_woo_upsell_products_title',
							'type'       => 'text',
							'title'      => esc_html__( 'Upsell products title', 'bianco-toolkit' ),
							'desc'       => esc_html__( 'Upsell products title', 'bianco-toolkit' ),
							'dependency' => array( 'ovic_woo_upsell_enable', '==', 'enable' ),
							'default'    => esc_html__( 'Upsell Products', 'bianco-toolkit' ),
						),
						'ovic_woo_upsell_ls_items'       => array(
							'id'         => 'ovic_woo_upsell_ls_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Upsell products items per row on Desktop', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >= 1500px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '3',
							'dependency' => array( 'ovic_woo_upsell_enable', '==', 'enable' ),
						),
						'ovic_woo_upsell_lg_items'       => array(
							'id'         => 'ovic_woo_upsell_lg_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Upsell products items per row on Desktop', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >= 1200px < 1500px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '3',
							'dependency' => array( 'ovic_woo_upsell_enable', '==', 'enable' ),
						),
						'ovic_woo_upsell_md_items'       => array(
							'id'         => 'ovic_woo_upsell_md_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Upsell products items per row on landscape tablet', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >=992px and < 1200px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '3',
							'dependency' => array( 'ovic_woo_upsell_enable', '==', 'enable' ),
						),
						'ovic_woo_upsell_sm_items'       => array(
							'id'         => 'ovic_woo_upsell_sm_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Upsell product items per row on portrait tablet', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >=768px and < 992px )', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '2',
							'dependency' => array( 'ovic_woo_upsell_enable', '==', 'enable' ),
						),
						'ovic_woo_upsell_xs_items'       => array(
							'id'         => 'ovic_woo_upsell_xs_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Upsell products items per row on Mobile', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device >=480  add < 768px)', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '1',
							'dependency' => array( 'ovic_woo_upsell_enable', '==', 'enable' ),
						),
						'ovic_woo_upsell_ts_items'       => array(
							'id'         => 'ovic_woo_upsell_ts_items',
							'type'       => 'slider',
							'title'      => esc_html__( 'Upsell products items per row on Mobile', 'bianco-toolkit' ),
							'desc'       => esc_html__( '(Screen resolution of device < 480px)', 'bianco-toolkit' ),
							'options'    => array(
								'min'  => 0,
								'max'  => 6,
								'step' => 1,
								'unit' => esc_html__( 'item(s)', 'bianco-toolkit' ),
							),
							'default'    => '1',
							'dependency' => array( 'ovic_woo_upsell_enable', '==', 'enable' ),
						),
					),
				);
			endif;
			$sections['social'] = array(
				'name'   => 'social',
				'title'  => esc_html__( 'Social Share Buttons', 'bianco-toolkit' ),
				'icon'   => 'fa fa-share-alt',
				'fields' => array(
					array(
						'id'              => 'user_all_social',
						'type'            => 'group',
						'title'           => esc_html__( 'Social Button lists', 'bianco-toolkit' ),
						'button_title'    => esc_html__( 'Add New Social', 'bianco-toolkit' ),
						'accordion_title' => esc_html__( 'Social Settings', 'bianco-toolkit' ),
						'fields'          => array(
							array(
								'id'      => 'title_social',
								'type'    => 'text',
								'title'   => esc_html__( 'Title Social', 'bianco-toolkit' ),
								'default' => 'Facebook',
							),
							array(
								'id'      => 'link_social',
								'type'    => 'text',
								'title'   => esc_html__( 'Link Social', 'bianco-toolkit' ),
								'default' => 'https://facebook.com',
							),
							array(
								'id'      => 'icon_social',
								'type'    => 'icon',
								'title'   => esc_html__( 'Icon Social', 'bianco-toolkit' ),
								'default' => 'fa fa-facebook',
							),
						),
					),
				),
			);
			$sections['backup'] = array(
				'name'   => 'backup',
				'title'  => esc_html__( 'Backup / Reset', 'bianco-toolkit' ),
				'icon'   => 'fa fa-recycle',
				'fields' => array(
					'ovic_reset' => array(
						'id'    => 'ovic_reset',
						'type'  => 'backup',
						'title' => esc_html__( 'Reset', 'bianco-toolkit' ),
					),
				),
			);

			$current_header  = apply_filters( 'ovic_get_option', 'bianco_used_header','market');
			$reject_vertical = array('child', 'tool');
			if(in_array($current_header, $reject_vertical)){
				unset($sections['vertical']);
			}elseif ($current_header == 'furniture') {
				unset($sections['vertical']['fields']['ovic_block_vertical_menu']);
				unset($sections['vertical']['fields']['ovic_vertical_menu_title']);
				unset($sections['vertical']['fields']['ovic_vertical_banner']);
				unset($sections['vertical']['fields']['ovic_vertical_banner_link']);
			}
			return apply_filters( 'ovic_config_customize_sections', $sections );
		}

		function config_framework()
		{
		    /*Framework Settings*/
			$settings = array(
				'option_name'      => OVIC_FRAMEWORK,
				'menu_title'       => 'Theme Options',
				'menu_type'        => 'submenu',
				'menu_parent'      => 'ovic-dashboard',
				'menu_slug'        => 'ovic_framework',
				'menu_position'    => 5,
				'show_search'      => true,
				'show_reset'       => true,
				'show_footer'      => false,
				'show_all_options' => true,
				'ajax_save'        => false,
				'sticky_header'    => false,
				'save_defaults'    => true,
				'framework_title'  => 'Ovic Framework <small>by <a href="https://kutethemes.com/" target="_blank">Kutethemes</a></small>',
			);
			$settings = apply_filters( 'ovic_setting_options_framework', $settings );

			OVIC_Options::instance( $settings, $this->config_options() );
		}

		function config_customize()
		{
			// -----------------------------------------
			// Customize Panel Options Fields          -
			// -----------------------------------------
			$options[] = array(
				'name'     => 'ovic_framework_customize',
				'title'    => esc_html__( 'Ovic Framework', 'bianco-toolkit' ),
				'sections' => $this->config_options(),
			);
			OVIC_Customize::instance( $options, OVIC_CUSTOMIZE );
		}

		function config_metabox()
		{
			// -----------------------------------------
			// Customize Panel Options Fields          -
			// -----------------------------------------
			$options = array();
			OVIC_Metabox::instance( $options );
		}

		function config_taxonomy()
		{
			// -----------------------------------------
			// Customize Panel Options Fields          -
			// -----------------------------------------
			$options = array();
			OVIC_Taxonomy::instance( $options );
		}
	}

	new Ovic_Options_Framework();
}