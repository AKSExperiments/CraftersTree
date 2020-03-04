<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( !class_exists( 'Ovic_Header_Builder' ) ) {
	class Ovic_Header_Builder
	{
		public function __construct()
		{
			add_action( 'init', array( &$this, 'post_type' ), 999 );
			$this->includes();
			add_action( 'vc_after_init', array( $this, 'includes' ) );
			add_filter( 'ovic_config_customize_sections', array( $this, 'add_theme_options' ) );
			add_filter( 'ovic_config_customize_sections_v2', array( $this, 'add_theme_options_v2' ) );
			add_filter( 'ovic_main_custom_css', array( $this, 'ovic_shortcodes_custom_css' ) );
			add_action( 'ovic_header_builder_display', array( $this, 'display_header_content' ) );
			add_filter( 'ovic_add_param_visual_composer', array( $this, 'shortcodes_settings' ) );
		}

		public function display_header_content()
		{
			$ovic_enable_header_builder = apply_filters( 'ovic_get_option', 'ovic_enable_header_builder', '0' );
			if ( $ovic_enable_header_builder == 0 ) return '';
			$ovic_used_header_builder = apply_filters( 'ovic_get_option', 'ovic_used_header_builder', '' );
			if ( $ovic_used_header_builder ) {
				$query   = new WP_Query( array( 'p' => $ovic_used_header_builder, 'post_type' => 'ovic_header', 'posts_per_page' => 1 ) );
				$class   = array( 'header' );
				$class[] = 'ovic-header';
				$class   = apply_filters( 'ovic_header_builder_class', $class );
				echo '<header class="' . esc_attr( implode( ' ', $class ) ) . '">';
				do_action( 'ovic_before_header_content' );
				if ( $query->have_posts() ):
					while ( $query->have_posts() ): $query->the_post();
						echo '<div class="container">' . wpb_js_remove_wpautop( get_the_content() ) . '</div>';
					endwhile;
				endif;
				do_action( 'ovic_after_header_content' );
				echo '</header>';
				wp_reset_postdata();
			}
		}

		public function get_headers()
		{
			$headers = array(
				'' => array(
					'title'   => esc_html__( 'None', 'bianco-toolkit' ),
					'preview' => '',
				),
			);
			$args    = array(
				'post_type'      => 'ovic_header',
				'posts_per_page' => -1,
				'orderby'        => 'ASC',
			);
			$loop    = get_posts( $args );
			foreach ( $loop as $value ) {
				setup_postdata( $value );
				$headers[$value->ID] = array(
					'title'   => $value->post_title,
					'preview' => wp_get_attachment_image_url( get_post_thumbnail_id( $value->ID ), 'full' ),
				);
			}

			return $headers;
		}

		public function add_theme_options( $options )
		{
			if ( isset( $options['header']['fields'] ) ) {
				$options['header']['fields']['ovic_enable_header_builder'] = array(
					'id'    => 'ovic_enable_header_builder',
					'type'  => 'switcher',
					'title' => esc_html__( 'Use Header Builder', 'bianco-toolkit' ),
				);
				$options['header']['fields']['ovic_used_header_builder']   = array(
					'id'         => 'ovic_used_header_builder',
					'type'       => 'select_preview',
					'title'      => esc_html__( 'Header', 'bianco-toolkit' ),
					'desc'       => esc_html__( 'Select a Header layout in page', 'bianco-toolkit' ),
					'options'    => $this->get_headers(),
					'dependency' => array( 'ovic_enable_header_builder', '==', 'true' ),
					'default'    => '',
				);
			}

			return $options;
		}

		public function add_theme_options_v2( $options )
		{
			if ( isset( $options['header_main']['sections']['header']['fields'] ) ) {
				$options['header_main']['sections']['header']['fields']['ovic_enable_header_builder'] = array(
					'id'    => 'ovic_enable_header_builder',
					'type'  => 'switcher',
					'title' => esc_html__( 'Use Header Builder', 'bianco-toolkit' ),
				);
				$options['header_main']['sections']['header']['fields']['ovic_used_header_builder']   = array(
					'id'         => 'ovic_used_header_builder',
					'type'       => 'select_preview',
					'title'      => esc_html__( 'Header', 'bianco-toolkit' ),
					'desc'       => esc_html__( 'Select a Header layout in page', 'bianco-toolkit' ),
					'options'    => $this->get_headers(),
					'dependency' => array( 'ovic_enable_header_builder', '==', 'true' ),
					'default'    => '',
				);
			}

			return $options;
		}

		function ovic_shortcodes_custom_css( $css )
		{
			$shortcodes_custom_css      = '';
			$ovic_used_header_builder   = apply_filters( 'ovic_get_option', 'ovic_used_header_builder', '' );
			$ovic_enable_header_builder = apply_filters( 'ovic_get_option', 'ovic_enable_header_builder', '0' );
			if ( $ovic_enable_header_builder == 0 ) return $css;
			$shortcodes_custom_css .= get_post_meta( $ovic_used_header_builder, '_wpb_post_custom_css', true );
			$shortcodes_custom_css .= get_post_meta( $ovic_used_header_builder, '_wpb_shortcodes_custom_css', true );
			$shortcodes_custom_css .= get_post_meta( $ovic_used_header_builder, '_Ovic_Shortcode_custom_css', true );
			$inline_css[]          = $shortcodes_custom_css;
			if ( count( $inline_css ) > 0 ) {
				$css .= implode( ' ', $inline_css );
			}

			return $css;
		}

		function post_type()
		{
			/* Footer */
			$args = array(
				'labels'              => array(
					'name'               => __( 'Headers', 'bianco-toolkit' ),
					'singular_name'      => __( 'Headers', 'bianco-toolkit' ),
					'add_new'            => __( 'Add New', 'bianco-toolkit' ),
					'add_new_item'       => __( 'Add new Header', 'bianco-toolkit' ),
					'edit_item'          => __( 'Edit Header', 'bianco-toolkit' ),
					'new_item'           => __( 'New Header', 'bianco-toolkit' ),
					'view_item'          => __( 'View Header', 'bianco-toolkit' ),
					'search_items'       => __( 'Search template Header', 'bianco-toolkit' ),
					'not_found'          => __( 'No template items found', 'bianco-toolkit' ),
					'not_found_in_trash' => __( 'No template items found in trash', 'bianco-toolkit' ),
					'parent_item_colon'  => __( 'Parent template item:', 'bianco-toolkit' ),
					'menu_name'          => __( 'Header Builder', 'bianco-toolkit' ),
				),
				'hierarchical'        => false,
				'description'         => __( 'To Build Template Header.', 'bianco-toolkit' ),
				'supports'            => array(
					'title',
					'editor',
					'thumbnail',
					'revisions',
				),
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => 'ovic-dashboard',
				'menu_position'       => 4,
				'show_in_nav_menus'   => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'query_var'           => true,
				'can_export'          => true,
				'rewrite'             => false,
				'capability_type'     => 'page',
			);
			register_post_type( 'ovic_header', $args );
		}

		public function shortcodes_settings( $param )
		{
			$param['ovic_headerlogo'] = array(
				'base'        => 'ovic_headerlogo',
				'name'        => esc_html__( 'Ovic: Header Logo', 'bianco-toolkit' ),
				'category'    => esc_html__( 'Ovic Shortcode', 'bianco-toolkit' ),
				'description' => esc_html__( 'Display Logo', 'bianco-toolkit' ),
				'params'      => array(
					array(
						'param_name'  => 'logo_type',
						'heading'     => esc_html__( 'Logo type', 'bianco-toolkit' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Image', 'bianco-toolkit' ) => 'image',
							esc_html__( 'Text', 'bianco-toolkit' )  => 'text',
						),
						'std'         => 'image',
						'admin_label' => true,
					),
					array(
						'type'        => 'attach_image',
						'heading'     => esc_html__( 'Regular logo', 'bianco-toolkit' ),
						'param_name'  => 'logo',
						'dependency'  => array(
							'element' => 'logo_type',
							'value'   => 'image',
						),
						'admin_label' => true,
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Logo content', 'bianco-toolkit' ),
						'param_name'  => 'logo_text',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'logo_type',
							'value'   => 'text',
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => __( 'Use theme default font family?', 'bianco-toolkit' ),
						'param_name'  => 'use_theme_fonts',
						'value'       => array( __( 'Yes', 'bianco-toolkit' ) => 'yes' ),
						'description' => __( 'Use font family from the theme.', 'bianco-toolkit' ),
						'dependency'  => array(
							'element' => 'logo_type',
							'value'   => 'text',
						),
					),
					array(
						'type'       => 'google_fonts',
						'param_name' => 'google_fonts',
						'value'      => 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
						'settings'   => array(
							'fields' => array(
								'font_family_description' => __( 'Select font family.', 'bianco-toolkit' ),
								'font_style_description'  => __( 'Select font styling.', 'bianco-toolkit' ),
							),
						),
						'dependency' => array(
							'element'            => 'use_theme_fonts',
							'value_not_equal_to' => 'yes',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Font Size', 'bianco-toolkit' ),
						'param_name'  => 'fontsize',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'logo_type',
							'value'   => 'text',
						),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Text Color', 'bianco-toolkit' ),
						'param_name'  => 'textcolor',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'logo_type',
							'value'   => 'text',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Letter spacing', 'bianco-toolkit' ),
						'param_name'  => 'letter_spacing',
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'logo_type',
							'value'   => 'text',
						),
					),
				),
			);
			/* Map New Custom menu */
			$all_menu = array();
			$menus    = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
			if ( $menus && count( $menus ) > 0 ) {
				foreach ( $menus as $m ) {
					$all_menu[$m->name] = $m->slug;
				}
			}
			$param['ovic_headermenu'] = array(
				'base'        => 'ovic_headermenu',
				'name'        => esc_html__( 'Ovic: Header Menu', 'bianco-toolkit' ),
				'category'    => esc_html__( 'Ovic Shortcode', 'bianco-toolkit' ),
				'description' => esc_html__( 'Display Menu', 'bianco-toolkit' ),
				'params'      => array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Menu', 'bianco-toolkit' ),
						'value'       => $all_menu,
						'admin_label' => true,
						'param_name'  => 'nav_menu',
						'description' => esc_html__( 'Select menu to display.', 'bianco-toolkit' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Menu align', 'bianco-toolkit' ),
						'value'       => array(
							'None'   => '',
							'Left'   => 'left',
							'Center' => 'center',
							'Right'  => 'right',
						),
						'admin_label' => true,
						'param_name'  => 'menu_align',
						'description' => esc_html__( 'Menu align.', 'bianco-toolkit' ),
					),
					// Settings
					array(
						'type'       => 'tabs_settings',
						'value'      => array(
							'Items Style' => 'item_style',
							'Mouse Hover' => 'mouse_hover',
						),
						'std'        => 'item_style',
						'param_name' => 'item_setting_tabs',
						'group'      => esc_html__( 'Item Options', 'bianco-toolkit' ),
					),
					// Item
					array(
						'type'             => 'checkbox',
						'heading'          => __( 'Use theme default font family?', 'bianco-toolkit' ),
						'param_name'       => 'use_theme_fonts',
						'value'            => array( __( 'Yes', 'bianco-toolkit' ) => 'yes' ),
						'description'      => __( 'Use font family from the theme.', 'bianco-toolkit' ),
						'std'              => 'yes',
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 item_style',
					),
					array(
						'type'             => 'google_fonts',
						'param_name'       => 'google_fonts',
						'value'            => 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
						'settings'         => array(
							'fields' => array(
								'font_family_description' => __( 'Select font family.', 'bianco-toolkit' ),
								'font_style_description'  => __( 'Select font styling.', 'bianco-toolkit' ),
							),
						),
						'dependency'       => array(
							'element'            => 'use_theme_fonts',
							'value_not_equal_to' => 'yes',
						),
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 item_style',
					),
					array(
						'type'             => 'textfield',
						'heading'          => esc_html__( 'Font Size', 'bianco-toolkit' ),
						'param_name'       => 'fontsize',
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 item_style',
					),
					array(
						'type'             => 'colorpicker',
						'heading'          => esc_html__( 'Text Color', 'bianco-toolkit' ),
						'param_name'       => 'textcolor',
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 item_style',
					),
					array(
						'type'             => 'textfield',
						'heading'          => esc_html__( 'Letter spacing', 'bianco-toolkit' ),
						'param_name'       => 'letter_spacing',
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 item_style',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Text transform', 'bianco-toolkit' ),
						'param_name'       => 'text_transform',
						'value'            => array(
							'None'       => 'none',
							'Capitalize' => 'capitalize',
							'Uppercase'  => 'uppercase',
							'Lowercase'  => 'lowercase',
							'Initial'    => 'initial',
							'Inherit'    => 'inherit',
						),
						'std'              => 'none',
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 item_style',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Text decoration', 'bianco-toolkit' ),
						'param_name'       => 'text_decoration',
						'value'            => array(
							'None'         => 'none',
							'Underline'    => 'underline',
							'Line-through' => 'line-through',
						),
						'std'              => 'none',
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 item_style',
					),
					array(
						'type'             => 'css_editor',
						'heading'          => esc_html__( 'Design', 'bianco-toolkit' ),
						'param_name'       => 'css_design_item',
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 item_style',
					),
					// Item Hover
					array(
						'type'             => 'colorpicker',
						'heading'          => esc_html__( 'Text Color', 'bianco-toolkit' ),
						'param_name'       => 'textcolor_hover',
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 mouse_hover hidden',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Text decoration', 'bianco-toolkit' ),
						'param_name'       => 'text_decoration_hover',
						'value'            => array(
							'None'         => 'none',
							'Underline'    => 'underline',
							'Line-through' => 'line-through',
						),
						'std'              => 'none',
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 mouse_hover hidden',
					),
					array(
						'type'             => 'css_editor',
						'heading'          => esc_html__( 'Design', 'bianco-toolkit' ),
						'param_name'       => 'css_design_item_hover',
						'group'            => esc_html__( 'Item Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 mouse_hover hidden',
					),
					//SUB MENU SETTINGS
					array(
						'type'       => 'tabs_settings',
						'value'      => array(
							'General'     => 'sub_menu_general',
							'Items style' => 'submenu_item_style',
							'Mouse hover' => 'submenu_mouse_hover',
						),
						'std'        => 'sub_menu_general',
						'param_name' => 'submenu_setting_tabs',
						'group'      => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
					),
					array(
						'type'             => 'textfield',
						'heading'          => esc_html__( 'Width', 'bianco-toolkit' ),
						'param_name'       => 'submenu_width',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 sub_menu_general',
					),
					array(
						'type'             => 'colorpicker',
						'heading'          => esc_html__( 'Text Color', 'bianco-toolkit' ),
						'param_name'       => 'submenu_textcolor_wapper',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 sub_menu_general',
					),
					array(
						'type'             => 'colorpicker',
						'heading'          => esc_html__( 'Hover Text Color', 'bianco-toolkit' ),
						'param_name'       => 'submenu_textcolor_wapper_hover',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 sub_menu_general',
					),
					array(
						'type'             => 'css_editor',
						'heading'          => esc_html__( 'Design', 'bianco-toolkit' ),
						'param_name'       => 'css_design_sumenu',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 sub_menu_general',
					),
					// Item Submenu
					array(
						'type'             => 'checkbox',
						'heading'          => __( 'Use theme default font family?', 'bianco-toolkit' ),
						'param_name'       => 'use_theme_fonts_submenu',
						'value'            => array( __( 'Yes', 'bianco-toolkit' ) => 'yes' ),
						'description'      => __( 'Use font family from the theme.', 'bianco-toolkit' ),
						'std'              => 'yes',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_item_style hidden',
					),
					array(
						'type'             => 'google_fonts',
						'param_name'       => 'google_fonts_submenu',
						'value'            => 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
						'settings'         => array(
							'fields' => array(
								'font_family_description' => __( 'Select font family.', 'bianco-toolkit' ),
								'font_style_description'  => __( 'Select font styling.', 'bianco-toolkit' ),
							),
						),
						'dependency'       => array(
							'element'            => 'use_theme_fonts_submenu',
							'value_not_equal_to' => 'yes',
						),
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_item_style hidden',
					),
					array(
						'type'             => 'textfield',
						'heading'          => esc_html__( 'Font Size', 'bianco-toolkit' ),
						'param_name'       => 'fontsize_submenu',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_item_style hidden',
					),
					array(
						'type'             => 'colorpicker',
						'heading'          => esc_html__( 'Text Color', 'bianco-toolkit' ),
						'param_name'       => 'textcolor_submenu',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_item_style hidden',
					),
					array(
						'type'             => 'textfield',
						'heading'          => esc_html__( 'Letter spacing', 'bianco-toolkit' ),
						'param_name'       => 'letter_spacing_submenu',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_item_style hidden',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Text transform', 'bianco-toolkit' ),
						'param_name'       => 'text_transform_submenu',
						'value'            => array(
							'None'       => 'none',
							'Capitalize' => 'capitalize',
							'Uppercase'  => 'uppercase',
							'Lowercase'  => 'lowercase',
							'Initial'    => 'initial',
							'Inherit'    => 'inherit',
						),
						'std'              => 'none',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_item_style hidden',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Text decoration', 'bianco-toolkit' ),
						'param_name'       => 'text_decoration_submenu',
						'value'            => array(
							'None'         => 'none',
							'Underline'    => 'underline',
							'Line-through' => 'line-through',
						),
						'std'              => 'none',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_item_style hidden',
					),
					array(
						'type'             => 'css_editor',
						'heading'          => esc_html__( 'Design', 'bianco-toolkit' ),
						'param_name'       => 'css_design_item_submenu',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_item_style hidden',
					),
					/* Submenu Item hover */
					array(
						'type'             => 'colorpicker',
						'heading'          => esc_html__( 'Text Color', 'bianco-toolkit' ),
						'param_name'       => 'textcolor_submenu_hover',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_mouse_hover hidden',
					),
					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Text decoration', 'bianco-toolkit' ),
						'param_name'       => 'text_decoration_submenu_hover',
						'value'            => array(
							'None'         => 'none',
							'Underline'    => 'underline',
							'Line-through' => 'line-through',
						),
						'std'              => 'none',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_mouse_hover hidden',
					),
					array(
						'type'             => 'css_editor',
						'heading'          => esc_html__( 'Design', 'bianco-toolkit' ),
						'param_name'       => 'css_design_item_submenu_hover',
						'group'            => esc_html__( 'Submenu Options', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 submenu_mouse_hover hidden',
					),
					// Extends
					array(
						'type'             => 'checkbox',
						'heading'          => __( 'Enable My account?', 'bianco-toolkit' ),
						'param_name'       => 'enable_my_account',
						'value'            => array( __( 'Yes', 'bianco-toolkit' ) => 'yes' ),
						'description'      => __( 'Display My accout link.', 'bianco-toolkit' ),
						'std'              => 'no',
						'group'            => esc_html__( 'Extends', 'bianco-toolkit' ),
						'edit_field_class' => 'vc_col-xs-12 ',
					),
				),
			);

			return $param;
		}

		public function includes()
		{
			if ( class_exists( 'Vc_Manager' ) ) {
				require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/extends/header-builder/shortcodes/ovic_header_logo.php';
				require_once BIANCO_TOOLKIT_PLUGIN_DIR . 'includes/extends/header-builder/shortcodes/ovic_header_menu.php';
			}
		}
	}

	new Ovic_Header_Builder();
}