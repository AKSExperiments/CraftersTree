<?php
/*==========================================================================
FUNCTIONS
===========================================================================*/
add_action( 'vc_after_init', 'add_cta_button_super_color' );
if ( !function_exists( 'add_cta_button_super_color' ) ) {
	function add_cta_button_super_color()
	{
		$param                                         = WPBMap::getParam( 'vc_btn', 'style' );
		$param['value'][esc_html__( 'Ovic Button', 'bianco' )] = 'ovic-button';
		vc_update_shortcode_param( 'vc_btn', $param );
	}
}
add_filter( 'vc_iconpicker-type-oviccustomfonts', 'bianco_iconpicker_type_oviccustomfonts' );
if ( !function_exists( 'bianco_iconpicker_type_oviccustomfonts' ) ) {
	function bianco_iconpicker_type_oviccustomfonts()
	{
		$icons['Custom Fonts'] = array(
			array( "bianco-icon icon-shoes" => "Icon shoes"),
			array( "bianco-icon icon-man-jacket" => "Icon man jacket"),
			array( "bianco-icon icon-handbag" => "Icon handbag"),
			array( "bianco-icon icon-cancel" => "Icon cancel"),
			array( "bianco-icon icon-compare" => "Icon compare"),
			array( "bianco-icon icon-time-zone" => "Icon time zone"),
			array( "bianco-icon icon-heart" => "Icon heart"),
			array( "bianco-icon icon-dress" => "Icon dress"),
			array( "bianco-icon icon-order-car" => "Icon order car"),
			array( "bianco-icon icon-building" => "Icon building"),
			array( "bianco-icon icon-suporter" => "Icon suporter"),
			array( "bianco-icon icon-home-furniture" => "Icon home furniture"),
			array( "bianco-icon icon-magnifier" => "Icon magnifier"),
			array( "bianco-icon icon-round-cancel" => "Icon round cancel"),
			array( "bianco-icon icon-location" => "Icon location"),
			array( "bianco-icon icon-setup" => "Icon setup"),
			array( "bianco-icon icon-vertical-menu" => "Icon vertical menu"),
			array( "bianco-icon icon-evelope" => "Icon evelope"),
			array( "bianco-icon icon-digital-equipment" => "Icon digital equipment"),
			array( "bianco-icon icon-agent" => "Icon agent"),
			array( "bianco-icon icon-user" => "Icon user"),
			array( "bianco-icon icon-duck-wood" => "Icon duck wood"),
			array( "bianco-icon icon-washing-machine" => "Icon washing machine"),
		);

		return $icons;
	}
}
if ( !function_exists( 'bianco_vc_after_init' ) ) {
	function bianco_vc_after_init()
	{
		/* For vc_tta_section shortcode */
		vc_remove_param( 'vc_tta_section', 'title_image' );
		$attributes = array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Extra Icon', 'bianco' ),
				'value'      => array(
					esc_html__( 'Image', 'bianco' )      => 'image',
					esc_html__( 'Ovic Fonts', 'bianco' ) => 'oviccustomfonts',
				),
				'param_name' => 'extra_icon',
				'group'      => esc_html__( 'Extra Icon', 'bianco' ),
			),
			array(
				'type'       => 'attach_image',
				'heading'    => esc_html__( 'Image', 'bianco' ),
				'group'      => esc_html__( 'Extra Icon', 'bianco' ),
				'param_name' => 'image_icon',
				'dependency' => array(
					'element' => 'extra_icon',
					'value'   => 'image',
				),
			),
			array(
				'param_name' => 'icon_oviccustomfonts',
				'heading'    => esc_html__( 'Icon', 'bianco' ),
				'group'      => esc_html__( 'Extra Icon', 'bianco' ),
				'type'       => 'iconpicker',
				'settings'   => array(
					'emptyIcon' => false,
					'type'      => 'oviccustomfonts',
				),
				'dependency' => array(
					'element' => 'extra_icon',
					'value'   => 'oviccustomfonts',
				),
			),
		);
		vc_add_params( 'vc_tta_section', $attributes );
	}
}
add_action( 'vc_after_init', 'bianco_vc_after_init' );
if ( !function_exists( 'bianco_post_autocomplete_suggester' ) ) {
	function bianco_post_autocomplete_suggester( $query )
	{
		global $wpdb;
		$post_id      = (int)$query;
		$post_results = $wpdb->get_results(
			$wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title FROM {$wpdb->posts} AS a WHERE a.post_type = 'post' AND a.post_status != 'trash' AND ( a.ID = '%d' OR a.post_title LIKE '%%%s%%' )", $post_id > 0 ? $post_id : -1, stripslashes( $query ), stripslashes( $query )
			), ARRAY_A
		);
		$results      = array();
		if ( is_array( $post_results ) && !empty( $post_results ) ) {
			foreach ( $post_results as $value ) {
				$data          = array();
				$data['value'] = $value['id'];
				$data['label'] = $value['title'];
				$results[]     = $data;
			}
		}

		return $results;
	}
}
if ( !function_exists( 'bianco_post_autocomplete_suggester_render' ) ) {
	function bianco_post_autocomplete_suggester_render( $query ){
		$query = trim( $query['value'] );
		/* get value from requested*/
		if ( !empty( $query ) ) {
			$post_object = get_post( (int)$query );
			if ( is_object( $post_object ) ) {
				$post_title    = $post_object->post_title;
				$post_id       = $post_object->ID;
				$data          = array();
				$data['value'] = $post_id;
				$data['label'] = $post_title;
				return !empty( $data ) ? $data : false;
			}
			return false;
		}
		return false;
	}
}
if ( !function_exists( 'bianco_add_result_autocomplete' ) ) {
	function bianco_add_result_autocomplete()
	{
		if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
			$vendor_woocommerce = new Vc_Vendor_Woocommerce();
			//Filters For autocomplete param:
			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_ovic_products_ids_callback',
				array(
					$vendor_woocommerce,
					'productIdAutocompleteSuggester',
				), 10, 1
			); // Get suggestion(find). Must return an array

			//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
			add_filter( 'vc_autocomplete_ovic_products_ids_render',
				array(
					$vendor_woocommerce,
					'productIdAutocompleteRender',
				), 10, 1
			); // Render exact product. Must return an array (label,value)
            add_filter( 'vc_autocomplete_ovic_banner_ids_callback',
                array(
                    $vendor_woocommerce,
                    'productIdAutocompleteSuggester',
                ), 10, 1
            ); // Get suggestion(find). Must return an array

            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_filter( 'vc_autocomplete_ovic_banner_ids_render',
                array(
                    $vendor_woocommerce,
                    'productIdAutocompleteRender',
                ), 10, 1
            ); // Render exact product. Must return an array (label,value)
			//For param: ID default value filter
			add_filter( 'vc_form_fields_render_field_ovic_products_ids_param_value',
				array(
					$vendor_woocommerce,
					'productsIdsDefaultValue',
				), 10, 4
			); // Defines default value for param if not provided. Takes from other param value.
			//For param: "filter" param value
			//vc_form_fields_render_field_{shortcode_name}_{param_name}_param
			add_filter( 'vc_form_fields_render_field_ovic_products_filter_param',
				array(
					$vendor_woocommerce,
					'productAttributeFilterParamValue',
				), 10, 4
			); /*Defines default value for param if not provided. Takes from other param value.*/
		}
		/* AUTOCOMPLETE POST */
		add_filter( 'vc_autocomplete_ovic_blog_ids_callback', 'bianco_post_autocomplete_suggester', 10, 1 );
		add_filter( 'vc_autocomplete_ovic_blog_ids_render', 'bianco_post_autocomplete_suggester_render', 10, 1 );
	}
}
function bianco_getCSSAnimation( $css_animation ) {
    $output = '';
    if ( '' !== $css_animation && 'none' !== $css_animation ) {
        wp_enqueue_script( 'waypoints' );
        wp_enqueue_style( 'animate-css' );
        $output = ' wpb_animate_when_almost_visible wpb_' . $css_animation . ' ' . $css_animation;
    }
    return $output;
}
add_action( 'vc_after_mapping', 'bianco_add_result_autocomplete', 10 );
if ( !function_exists( 'Bianco_VC_Functions_Param' ) ) {
	add_filter( 'ovic_vc_add_param_visual_composer', 'Bianco_VC_Functions_Param' );
	function Bianco_VC_Functions_Param( $param )
	{
		$icom_uri               = get_theme_file_uri( 'assets/images/icons' );
		$shortcode_preview      = get_theme_file_uri( 'assets/images/shortcode-preview' );
		$product_templates_uri  = get_theme_file_uri( 'woocommerce/product-styles' );
		$blogpost_templates_uri = get_theme_file_uri( 'templates/blog/blog-style/content-blog-' );
		$main_color				= Bianco_Functions::get_option( 'ovic_main_color', '#63ab04' );

		/* Map New Custom menu */
		$all_menu = array();
		$menus    = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		if ( $menus && count( $menus ) > 0 ) {
			foreach ( $menus as $m ) {
				$all_menu[$m->name] = $m->slug;
			}
		}
		/* Map New Custom social */
		$socials     = array();
		$all_socials = Bianco_Functions::get_option('user_all_social','');
		if ( !empty( $all_socials ) ) {
			foreach ( $all_socials as $key => $social ) {
				$socials[$social['title_social']] = $key;
			}
		}
		$attributes_tax = array();
		if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
			$attributes_tax = wc_get_attribute_taxonomies();
		}
		$attributes = array();
		if ( is_array( $attributes_tax ) && count( $attributes_tax ) > 0 ) {
			foreach ( $attributes_tax as $attribute ) {
				$attributes[$attribute->attribute_label] = $attribute->attribute_name;
			}
		}
		/*GET ALL CATEGORY*/
        $categories_array = array(
            esc_html__( 'All', 'bianco' ) => '',
        );
        $args             = array();
        $categories       = get_categories( $args );
        foreach ( $categories as $category ) {
            $categories_array[$category->name] = $category->slug;
        }
        /*ANIMATION FOR BANNER*/
        $bianco_animation_for_banner = vc_map_add_css_animation(false);
        $bianco_animation_for_banner['dependency'] = array( "element" => "layout", "value" => 'style23');

		 /*CUSTOM PRODUCT SIZE*/
		$product_size_list = array();
		$size              = array(
                                'width'  => 300,
                                'height' => 300,
                                'crop'   => 1,
                            );
		if ( function_exists( 'wc_get_image_size' ) ) {
			$size                                                                        = wc_get_image_size( 'shop_catalog' );
			$product_size_list["Shop Thumbnail ({$size['width']}x{$size['height']})"]    = "{$size['width']}x{$size['height']}";
			$size                                                                        = wc_get_image_size( 'shop_single' );
			$product_size_list["Single ({$size['width']}x{$size['width']})"]             = "{$size['width']}x{$size['width']}";
			$size                                                                        = wc_get_image_size( 'shop_thumbnail' );
			$product_size_list["Gallery Thumbnail ({$size['width']}x{$size['height']})"] = "{$size['width']}x{$size['height']}";
		}
		$product_size_list['Custom'] = 'custom';

		vc_add_params( 'vc_single_image', array(
				array(
                    'param_name' => 'image_effect',
                    'heading'    => esc_html__( 'Effect', 'bianco' ),
                    'group'      => esc_html__( 'Image Effect', 'bianco' ),
                    'type'       => 'dropdown',
                    'value'      => array(
                        esc_html__( 'None', 'bianco' )                      => 'none',
                        esc_html__( 'Normal Effect', 'bianco' )             => 'effect normal-effect',
                        esc_html__( 'Normal Effect Dark Color', 'bianco' )  => 'effect normal-effect dark-bg',
                        esc_html__( 'Normal Effect Light Color', 'bianco' ) => 'effect normal-effect light-bg',
                        esc_html__( 'Bounce In', 'bianco' )                 => 'effect bounce-in',
                        esc_html__( 'Plus Zoom', 'bianco' )                 => 'effect plus-zoom',
                        esc_html__( 'Border Zoom', 'bianco' )               => 'effect border-zoom',
                        esc_html__( 'Border ScaleUp', 'bianco' )            => 'effect border-scale',
                        esc_html__( 'Box Shadow Hover', 'bianco' )          => 'effect box-shadow',
                    ),
                    'sdt'        => 'none',
                ),
                array(
                    'type'       => 'colorpicker',
                    'value'      => '#e6e6e6',
                    'heading'    => esc_html__( "Effect Color:", 'bianco' ),
                    'param_name' => "_effect_color",
                    'group'      => esc_html__( 'Image Effect', 'bianco' ),
                    'dependency'  => array( 'element' => 'image_effect', 'value' => array( 'effect border-zoom' ) ),
                ),
			)
		);

		$banner_options = array(
            'default' => array(
                'title'   => esc_html__( 'Default', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/default.jpg",
            ),
            'deal'    => array(
                'title'   => esc_html__( 'Deal', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/deal.png",
            ),
            'deal_2'  => array(
                'title'   => esc_html__( 'Deal 2', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/deal2.jpg",
            ),
            'style1'  => array(
                'title'   => esc_html__( 'Style 01', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style1.jpg",
            ),
            'style2'  => array(
                'title'   => esc_html__( 'Style 02', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style2.jpg",
            ),
            'style3'  => array(
                'title'   => esc_html__( 'Style 03', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style3.jpg",
            ),
            'style4'  => array(
                'title'   => esc_html__( 'Style 04', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style4.jpg",
            ),
            'style5'  => array(
                'title'   => esc_html__( 'Style 05', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style5.jpg",
            ),
            'style6'  => array(
                'title'   => esc_html__( 'Style 06', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style6.jpg",
            ),
            'style7'  => array(
                'title'   => esc_html__( 'Style 07', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style7.jpg",
            ),
            'style8'  => array(
                'title'   => esc_html__( 'Style 08', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style8.jpg",
            ),
            'style9'  => array(
                'title'   => esc_html__( 'Style 09', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style9.jpg",
            ),
            'style10' => array(
                'title'   => esc_html__( 'Style 10', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style10.jpg",
            ),
            'style11' => array(
                'title'   => esc_html__( 'Style 11', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style11.jpg",
            ),
            'style12' => array(
                'title'   => esc_html__( 'Style 12', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style12.jpg",
            ),
            'style13' => array(
                'title'   => esc_html__( 'Style 13', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style13.jpg",
            ),
            'style14' => array(
                'title'   => esc_html__( 'Style 14', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style14.jpg",
            ),
            'style15' => array(
                'title'   => esc_html__( 'Style 15', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style15.jpg",
            ),
            'style16' => array(
                'title'   => esc_html__( 'Style 16', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style16.jpg",
            ),
            'style17' => array(
                'title'   => esc_html__( 'Style 17', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style17.jpg",
            ),
            'style18' => array(
                'title'   => esc_html__( 'Style 18', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style18.jpg",
            ),
            'style19' => array(
                'title'   => esc_html__( 'Style 19', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style19.jpg",
            ),
            'style20' => array(
                'title'   => esc_html__( 'Style 20', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style20.jpg",
            ),
            'style21' => array(
                'title'   => esc_html__( 'Style 21', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style21.jpg",
            ),
            'style22' => array(
                'title'   => esc_html__( 'Style 22', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style22.jpg",
            ),
            'style23' => array(
                'title'   => esc_html__( 'Style 23', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style23.jpg",
            ),
            'style24' => array(
                'title'   => esc_html__( 'Style 24', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style24.jpg",
            ),
            'style25' => array(
                'title'   => esc_html__( 'Style 25', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style25.jpg",
            ),
            'style26' => array(
                'title'   => esc_html__( 'Style 26', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style26.jpg",
            ),
            'style27' => array(
                'title'   => esc_html__( 'Style 27', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style27.jpg",
            ),
            'style28' => array(
                'title'   => esc_html__( 'Style 28', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style28.jpg",
            ),
            'style29' => array(
                'title'   => esc_html__( 'Style 29', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style29.jpg",
            ),
            'style30' => array(
                'title'   => esc_html__( 'Style 30', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style30.jpg",
            ),
            'style31' => array(
                'title'   => esc_html__( 'Style 31', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style31.jpg",
            ),
            'style32' => array(
                'title'   => esc_html__( 'Style 32', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style32.jpg",
            ),
            'style33' => array(
                'title'   => esc_html__( 'Style 33', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style33.jpg",
            ),
            'style34' => array(
                'title'   => esc_html__( 'Style 34', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style34.jpg",
            ),
            'style35' => array(
                'title'   => esc_html__( 'Style 35', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style35.jpg",
            ),
            'style36' => array(
                'title'   => esc_html__( 'Style 36', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style36.jpg",
            ),
            'style37' => array(
                'title'   => esc_html__( 'Style 37', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style37.jpg",
            ),
            'style38' => array(
                'title'   => esc_html__( 'Style 38', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/no-banner.png",
            ),
            'style39' => array(
                'title'   => esc_html__( 'Style 39', 'bianco' ),
                'preview' => "{$shortcode_preview}/ovic_banner/style39.jpg",
            ),
        );
        $banner_text3_dependencies = array(
            'deal', 'deal_2',
            'style1', 'style3', 'style4', 'style5', 'style6', 'style7',
            'style12', 'style13', 'style14', 'style15', 'style18', 'style19',
            'style21', 'style22', 'style23', 'style26', 'style28', 'style29',
            'style30', 'style31', 'style33', 'style34', 'style36', 'style37',
            'style39'
        );
        $banner_text4_dependencies = array(
            'deal','deal_2',
            'style1', 'style4', 'style5', 'style6', 'style12', 'style13',
            'style14', 'style21','style22','style23','style29','style30',
            'style31', 'style37',
        );
        $except_effect_to_banners = array(
            'default', 'deal', 'deal_2', 'style14', 'style23', 'style24', 'style25',
            'style26', 'style27', 'style28', 'style29', 'style30', 'style36', 'style37',
            'style38', 'style39'
        );
        $dependencies_btn_bgcolor = array(
            'deal', 'style8', 'style10', 'style11', 'style13', 'style14', 'style15',
            'style17', 'style25', 'style28', 'style30'
        );

		/* TODO: ovic_iconbox */
		$param['ovic_iconbox'] = array(
			'base'            => 'ovic_iconbox',
			'name'            => esc_html__( 'Ovic: Icon Box', 'bianco' ),
			'icon'            => "{$icom_uri}/rating_2.svg",
			'category'        => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description'     => esc_html__( 'Display Icon Box', 'bianco' ),
			'content_element' => true,
			'params'          => array(
				array(
					'type'        => 'select_preview',
					'param_name'  => 'style',
					'heading'     => esc_html__( 'Select style', 'bianco' ),
					'admin_label' => true,
					'value'       => array(
						'default' => array(
							'title'   => esc_html__( 'Default', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic_iconbox/default-layout.jpg",
						),
						'02'      => array(
							'title'   => esc_html__( 'Layout 02', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic_iconbox/layout-02.jpg",
						),
                        '03'      => array(
                            'title'   => esc_html__( 'Layout 03', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_iconbox/layout-03.jpg",
                        ),
                        '04'      => array(
                            'title'   => esc_html__( 'Layout 04', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_iconbox/layout-04.jpg",
                        ),
                        '05'      => array(
                            'title'   => esc_html__( 'Layout 05', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_iconbox/layout-05.jpg",
                        ),
                        '06'   => array(
                            'title'   => esc_html__( 'Layout 06', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_iconbox/layout-06.jpg",
                        ),
						'group'   => array(
							'title'   => esc_html__( 'Group Type 01', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic_iconbox/layout-group.jpg",
						),
                        'group-t2'   => array(
                            'title'   => esc_html__( 'Group Type 02', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_iconbox/layout-group-type-2.jpg",
                        ),
					),
					'default'     => 'default',

				),
				array(
					'type'        => 'dropdown',
					'param_name'  => 'type',
					'heading'     => esc_html__( 'Icon library', 'bianco' ),
					'admin_label' => true,
					'value'       => array(
						esc_html__( 'Font Awesome', 'bianco' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'bianco' )  => 'openiconic',
						esc_html__( 'Typicons', 'bianco' )     => 'typicons',
						esc_html__( 'Entypo', 'bianco' )       => 'entypo',
						esc_html__( 'Linecons', 'bianco' )     => 'linecons',
						esc_html__( 'Mono Social', 'bianco' )  => 'monosocial',
						esc_html__( 'Material', 'bianco' )     => 'material',
						esc_html__( 'Custom Fonts', 'bianco' ) => 'oviccustomfonts',
						esc_html__( 'Image', 'bianco' )        => 'image',
					),
					'description' => esc_html__( 'Select icon library.', 'bianco' ),
					'dependency'  => array( 'element' => 'style', 'value_not_equal_to' => array('group','group-t2')),
				),
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__( 'Image', 'bianco' ),
					'param_name' => 'image',
					'dependency' => array( 'element' => 'type', 'value' => 'image', ),

				),
				array(
					'param_name'  => 'icon_oviccustomfonts',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
					'type'        => 'iconpicker',
					'settings'    => array(
						'emptyIcon' => false,
						'type'      => 'oviccustomfonts',
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'oviccustomfonts',
					),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_fontawesome',
					'value'       => 'fa fa-adjust',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'fontawesome',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_openiconic',
					'value'       => 'vc-oi vc-oi-dial',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'openiconic',
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'openiconic',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_typicons',
					'value'       => 'typcn typcn-adjust-brightness',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'typicons',
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'typicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'bianco' ),
					'param_name' => 'icon_entypo',
					'value'      => 'entypo-icon entypo-icon-note',
					'settings'   => array(
						'emptyIcon'    => false,
						'type'         => 'entypo',
						'iconsPerPage' => 100,
					),
					'dependency' => array(
						'element' => 'type',
						'value'   => 'entypo',
					),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_linecons',
					'value'       => 'vc_li vc_li-heart',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'linecons',
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'linecons',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_monosocial',
					'value'       => 'vc-mono vc-mono-fivehundredpx',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'monosocial',
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'monosocial',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_material',
					'value'       => 'vc-material vc-material-cake',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'material',
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'material',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					"type"       => 'colorpicker',
					"value"      => '#03a9f4',
					"heading"    => esc_html__( "Background color", 'bianco' ),
					"param_name" => "background_color",
					'dependency' => array( "element" => "style", "value" => array( 'default','03','06') ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'bianco' ),
					'param_name'  => 'title',
					'admin_label' => true,
                    'dependency'  => array( 'element' => 'style', 'value_not_equal_to' => array( 'group','group-t2') ),
				),
				array(
					"type"       => "textarea",
					"class"      => "",
					"heading"    => esc_html__( 'Subtitle', 'bianco' ),
					"param_name" => "subtitle",
					"value"      => '',
                    'dependency'  => array( 'element' => 'style', 'value_not_equal_to' => array( 'group','group-t2') ),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Second Title', 'bianco' ),
					'param_name' => 's_title',
					'dependency' => array( "element" => "style", "value" => 'default' ),
				),
				array(
					'type'       => 'textarea',
					'heading'    => esc_html__( 'Second Subtitle', 'bianco' ),
					'param_name' => 's_subtitle',
					'dependency' => array( "element" => "style", "value" => 'default' ),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Link', 'bianco' ),
					'param_name'  => 'link',
					'description' => esc_html__( 'The Link to Icon', 'bianco' ),
					'dependency'  => array( "element" => "style", "value" => 'default' ),
				),
				array(
					'type'        => 'dropdown',
					'param_name'  => 'gutter_group',
					'heading'     => esc_html__( 'Gutter Group', 'bianco' ),
					'admin_label' => true,
					'value'       => array(
						esc_html__( 'No Gutter', 'bianco' ) => '',
						esc_html__( 'Gutter', 'bianco' )    => 'gutter',
					),
					'dependency'  => array( "element" => "style", "value" => 'group' ),
				),
				array(
					'type'       => 'param_group',
					'heading'    => esc_html__( 'Group icons', 'bianco' ),
					'value'      => '',
					'param_name' => 'icon_group',
                    'dependency' => array( 'element' => 'style', 'value' => 'group' ),
					'params'     => array(
						array(
							'type'        => 'dropdown',
							'param_name'  => 'type',
							'heading'     => esc_html__( 'Icon library', 'bianco' ),
							'admin_label' => true,
							'value'       => array(
								esc_html__( 'Font Awesome', 'bianco' ) => 'fontawesome',
								esc_html__( 'Image', 'bianco' )        => 'image',
							),
							'description' => esc_html__( 'Select icon library.', 'bianco' ),
						),
						array(
							'type'       => 'attach_image',
							'heading'    => esc_html__( 'Image', 'bianco' ),
							'param_name' => 'image',
							'dependency' => array( 'element' => 'type', 'value' => 'image', ),
						),
						array(
							'type'        => 'iconpicker',
							'heading'     => esc_html__( 'Icon', 'bianco' ),
							'param_name'  => 'icon_fontawesome',
							'value'       => 'fa fa-adjust',
							'settings'    => array(
								'emptyIcon'    => false,
								'iconsPerPage' => 100,
							),
							'dependency'  => array(
								'element' => 'type',
								'value'   => 'fontawesome',
							),
							'description' => esc_html__( 'Select icon from library.', 'bianco' ),
						),
						array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Title', 'bianco' ),
							'param_name' => 'title',
							"value"      => '',
						),
						array(
							"type"       => "textarea",
							"param_name" => "subtitle",
							"heading"    => esc_html__( 'Subtitle', 'bianco' ),
							"class"      => "",
							"value"      => '',
						),
						array(
							"type"       => 'colorpicker',
							"value"      => '#ffffff',
							"heading"    => esc_html__( "Background color", 'bianco' ),
							"param_name" => "background_color",
						),
						array(
							"type"       => 'colorpicker',
							"value"      => '#e6e6e6',
							"heading"    => esc_html__( "Border color", 'bianco' ),
							"param_name" => "border_color",
						),
					),
				),
                array(
                    'type'       => 'param_group',
                    'heading'    => esc_html__( 'Group icons', 'bianco' ),
                    'value'      => '',
                    'param_name' => 'icon_group_2',
                    'dependency' => array( 'element' => 'style', 'value' => 'group-t2'),
                    'params'     => array(
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'type',
                            'heading'     => esc_html__( 'Icon library', 'bianco' ),
                            'value'       => array(
                                esc_html__( 'Font Awesome', 'bianco' ) => 'fontawesome',
                                esc_html__( 'Image', 'bianco' )        => 'image',
                            ),
                            'description' => esc_html__( 'Select icon library.', 'bianco' ),
                        ),
                        array(
                            'type'       => 'attach_image',
                            'heading'    => esc_html__( 'Image', 'bianco' ),
                            'param_name' => 'image',
                            'dependency' => array( 'element' => 'type', 'value' => 'image', ),
                        ),
                        array(
                            'type'        => 'iconpicker',
                            'heading'     => esc_html__( 'Icon', 'bianco' ),
                            'param_name'  => 'icon_fontawesome',
                            'value'       => 'fa fa-adjust',
                            'settings'    => array(
                                'emptyIcon'    => false,
                                'iconsPerPage' => 100,
                            ),
                            'dependency'  => array(
                                'element' => 'type',
                                'value'   => 'fontawesome',
                            ),
                            'description' => esc_html__( 'Select icon from library.', 'bianco' ),
                        ),
                        array(
                            'type'       => 'textfield',
                            'heading'    => esc_html__( 'Title', 'bianco' ),
                            'param_name' => 'title',
                            "value"      => '',
                        ),
                        array(
                            "type"       => "textarea",
                            "param_name" => "subtitle",
                            "heading"    => esc_html__( 'Subtitle', 'bianco' ),
                            "class"      => "",
                            "value"      => '',
                        ),
                        array(
                            "type"       => 'colorpicker',
                            "value"      => '#f96332',
                            "heading"    => esc_html__( "Background color", 'bianco' ),
                            "param_name" => "bg_color",
                        ),
                    ),
                ),
			),
		);

		/* TODO ovic_person */
		$param['ovic_person'] = array(
			'base'        => 'ovic_person',
			'name'        => esc_html__( 'Ovic: Person', 'bianco' ),
			'icon'        => "{$icom_uri}/customer-support.svg",
			'category'    => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description' => esc_html__( 'Display Person', 'bianco' ),
			'params'      => array(
				array(
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Select layout', 'bianco' ),
					'value'       => array(
						'style1' => array(
							'title'   => esc_html__( 'Style 01', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic_person/default.jpg",
						),
					),
					'default'     => 'style1',
					'admin_label' => true,
					'param_name'  => 'layout',
				),
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__( 'Avatar Person', 'bianco' ),
					'param_name' => 'avatar',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Name:', 'bianco' ),
					'param_name'  => 'name',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title:', 'bianco' ),
					'param_name'  => 'title',
				),
				array(
					'type'       => 'textarea',
					'heading'    => esc_html__( 'Message:', 'bianco' ),
					'param_name' => 'message',
				),
				array(
					'type'       => 'vc_link',
					'heading'    => esc_html__( 'Link', 'bianco' ),
					'param_name' => 'link',
				),
			),
		);

		/* TODO ovic_products */
		$param['ovic_products'] = array(
			'base'        => 'ovic_products',
			'name'        => esc_html__( 'Ovic: Products', 'bianco' ),
			'icon'        => "{$icom_uri}/box.svg",
			'category'    => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description' => esc_html__( 'Display Products', 'bianco' ),
			'params'      => array(
				array(
					'param_name'  => 'productsliststyle',
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Product List Style', 'bianco' ),
					'description' => esc_html__( 'Select a style for list', 'bianco' ),
					'value'       => array(
						esc_html__( 'Grid Bootstrap', 'bianco' )     => 'grid',
						esc_html__( 'Carousel', 'bianco' )           => 'owl',
						esc_html__( 'Combined Countdown', 'bianco' ) => 'combined',
						esc_html__( 'Widget', 'bianco' )             => 'wgt',
						esc_html__( 'Products Right Overflow', 'bianco' ) => 'onbanner',
					),
					'std'         => 'grid',
				),
				array(
					'type'        => 'select_preview',
					'param_name'  => 'layout',
					'admin_label' => true,
					'heading'     => esc_html__( 'Select layout', 'bianco' ),
					'value'       => array(
						'default' => array(
							'title'   => esc_html__( 'Default Layout', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic_products/default.jpg",
						),
					),
					'default'     => 'default',
					'dependency'  => array( 'element' => 'productsliststyle', 'value' => 'combined' ),
				),
				array(
					'type'        => 'select_preview',
					'param_name'  => 'owl_layout',
					'heading'     => esc_html__( 'Select Layout', 'bianco' ),
					'admin_label' => true,
					'value'       => array(
						'default'   => array(
							'title'   => esc_html__( 'Default', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic_products/owl-default.jpg",
						),
						'layout-01' => array(
							'title'   => esc_html__( 'Layout 01', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic_products/carousel-innertab.jpg",
						),
                        'layout-02' => array(
                            'title'   => esc_html__( 'Layout 02', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_products/carousel-style-2.jpg",
                        ),
                        'layout-03' => array(
                            'title'   => esc_html__( 'Layout 03', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_products/carousel-style-3.jpg",
                        ),
                        'layout-04' => array(
                            'title'   => esc_html__( 'Layout 04', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_products/carousel-style-4.jpg",
                        ),
                        'layout-05' => array(
                            'title'   => esc_html__( 'Layout 05', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_products/carousel-style-5.jpg",
                        ),
					),
					'default'     => 'default',
					'dependency'  => array( 'element' => 'productsliststyle', 'value' => 'owl' ),
				),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Distance', 'bianco' ),
                    'description' => esc_html__( 'The distances between two items in a row', 'bianco' ),
                    'param_name'  => 'grid_distance',
                    'value'       => array(
                        esc_html__( 'Default (30px)', 'bianco' ) => 'default-distance',
                        esc_html__( 'Medium (10px)', 'bianco' )  => 'medium-distance',
                    ),
                    'std'         => 'default-distance',
                    'dependency'  => array(
                        'element' => 'productsliststyle',
                        'value'   => 'grid',
                    ),
                ),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'bianco' ),
					'param_name'  => 'title',
					'admin_label' => true,
                    'dependency'  => array(
                        "element" => "productsliststyle",
                        'value_not_equal_to' => 'onbanner',
                    ),
				),
                array(
                    "type"       => 'colorpicker',
                    "value"      => $main_color,
                    "heading"    => esc_html__( "Background Of Title", 'bianco' ),
                    "param_name" => "title_bg",
                    'dependency' => array( 'element' => 'productsliststyle', 'value' => 'wgt' ),
                ),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Sub Title', 'bianco' ),
					'param_name' => 'sub_title',
					'dependency' => array(
						'element' => 'layout',
						'value'   => array( 'style1', 'style2' ),
					),
				),
				array(
					'type'       => 'textarea',
					'heading'    => esc_html__( 'Sub Title', 'bianco' ),
					'param_name' => 'owl_sub_title',
					'dependency' => array(
						'element' => 'owl_layout',
						'value'   => array( 'default', 'layout-02' ),
					),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Title\'s Underline Color', 'bianco' ),
					'rgba'       => true,
					'param_name' => 'title_underline_color',
					'value'      => $main_color,
					'dependency' => array(
						'element' => 'productsliststyle',
						'value'   => array( 'owl', 'combined' ),
					),
				),
				array(
					"type"        => "vc_link",
					"class"       => "",
					"heading"     => esc_html__( "Button", "bianco" ),
					"param_name"  => "btn_link",
					"value"       => '',
					"description" => esc_html__( 'This button is used to redirect users', "bianco" ),
					'dependency'  => array(
						'element' => 'owl_layout',
						'value'   => array( 'default' ),
					),
				),
				array(
					'type'       => 'number',
					'heading'    => esc_html__( 'Number columns', 'bianco' ),
					'param_name' => 'lg_items',
					'value'      => 4,
					'dependency' => array(
						'element' => 'layout',
						'value'   => array( 'style100' ),
					),
				),
				array(
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Product style', 'bianco' ),
					'param_name'  => 'product_style',
					'description' => esc_html__( 'Select a style for product item', 'bianco' ),
					'admin_label' => true,
					'value'       => array(
						'style-1' => array(
							'title'   => 'Style 01',
							'preview' => "{$product_templates_uri}/content-product-style-1.jpg",
						),
						'style-2' => array(
							'title'   => 'Style 02',
							'preview' => "{$product_templates_uri}/content-product-style-2.jpg",
						),
						'style-3' => array(
							'title'   => 'Style 03',
							'preview' => "{$product_templates_uri}/content-product-style-3.jpg",
						),
						'style-4' => array(
							'title'   => 'Style 04',
							'preview' => "{$product_templates_uri}/content-product-style-4.jpg",
						),
						'style-5' => array(
							'title'   => 'Style 05',
							'preview' => "{$product_templates_uri}/content-product-style-5.jpg",
						),
						'style-6' => array(
							'title'   => 'Style 06',
							'preview' => "{$product_templates_uri}/content-product-style-6.jpg",
						),
                        'style-7' => array(
							'title'   => 'Style 07',
							'preview' => "{$product_templates_uri}/content-product-style-7.jpg",
						),
                        'style-8' => array(
                            'title'   => 'Style 08',
                            'preview' => "{$product_templates_uri}/content-product-style-8.jpg",
                        ),
                        'style-9' => array(
                            'title'   => 'Style 09',
                            'preview' => "{$product_templates_uri}/content-product-style-9.jpg",
                        ),
                        'style-10' => array(
                            'title'   => 'Style 10',
                            'preview' => "{$product_templates_uri}/content-product-style-10.jpg",
                        ),
                        'style-11' => array(
                            'title'   => 'Style 11',
                            'preview' => "{$product_templates_uri}/content-product-style-11.jpg",
                        ),
                        'style-12' => array(
                            'title'   => 'Style 12',
                            'preview' => "{$product_templates_uri}/content-product-style-12.jpg",
                        ),
                        'style-13' => array(
                            'title'   => 'Style 13',
                            'preview' => "{$product_templates_uri}/content-product-style-13.jpg",
                        ),
                        'style-14' => array(
                            'title'   => 'Style 14 ( One Line )',
                            'preview' => "{$product_templates_uri}/content-product-style-14.jpg",
                        ),
					),
					'default'     => 'style-1',
					'dependency'  => array(
						'element' => 'productsliststyle',
						'value'   => array( 'grid', 'owl', 'onbanner'),
					),
				),
                array(
                    "type"        => "attach_image",
                    "heading"     => esc_html__( "Main Background", 'bianco' ),
                    "param_name"  => "bg_image",
                    'dependency'  => array(
                        "element" => "productsliststyle",
                        'value' => 'onbanner',
                    ),
                ),
				array(
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Yes', 'bianco' ) => 'true',
						esc_html__( 'No', 'bianco' )  => 'false',
					),
					'std'        => 'false',
					'heading'    => esc_html__( 'Show only icon', 'bianco' ),
					'param_name' => 'only_icon',
					'dependency' => array(
						'element' => 'product_style', 'value' => array( '2', '4', '7', '8', '9', '11', '12' ),
					),
				),
				array(
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Yes', 'bianco' ) => 'true',
						esc_html__( 'No', 'bianco' )  => 'false',
					),
					'std'        => 'false',
					'heading'    => esc_html__( 'Hide label', 'bianco' ),
					'param_name' => 'hide_label',
					'dependency' => array(
						'element' => 'product_style', 'value' => array( '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12' ),
					),
				),
				array(
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Yes', 'bianco' ) => 'true',
						esc_html__( 'No', 'bianco' )  => 'false',
					),
					'std'        => 'false',
					'heading'    => esc_html__( 'Hide review', 'bianco' ),
					'param_name' => 'hide_review',
					'dependency' => array(
						'element' => 'product_style', 'value' => array( '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12' ),
					),
				),
				array(
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Yes', 'bianco' ) => 'true',
						esc_html__( 'No', 'bianco' )  => 'false',
					),
					'std'        => 'false',
					'heading'    => esc_html__( 'Hide quickview', 'bianco' ),
					'param_name' => 'hide_quickview',
					'dependency' => array(
						'element' => 'product_style', 'value' => array( '2', '4', '5', '6', '7', '8', '9', '10', '11', '12' ),
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Image size', 'bianco' ),
					'param_name'  => 'product_image_size',
					'value'       => $product_size_list,
					'description' => esc_html__( 'Select a size for product', 'bianco' ),
					'dependency'  => array(
						'element' => 'productsliststyle',
						'value'   => array( 'grid', 'owl' ),
					),
				),
				array(
					'type'       => 'number',
					'heading'    => esc_html__( 'Width', 'bianco' ),
					'param_name' => 'product_custom_thumb_width',
					'suffix'     => esc_html__( 'px', 'bianco' ),
					'dependency' => array(
						'element' => 'product_image_size',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'       => 'number',
					'heading'    => esc_html__( 'Height', 'bianco' ),
					'param_name' => 'product_custom_thumb_height',
					'suffix'     => esc_html__( 'px', 'bianco' ),
					'dependency' => array(
						'element' => 'product_image_size',
						'value'   => array( 'custom' ),
					),
				),
				/* Products */
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Enable Loadmore', 'bianco' ),
					'param_name' => 'enable_loadmore',
					'value'      => array( esc_html__( 'Yes', 'bianco' ) => 'yes' ),
					'group'      => esc_html__( 'Products options', 'bianco' ),
					'dependency' => array(
						'element' => 'productsliststyle',
						'value'   => array( 'grid' ),
					),
				),
				array(
					'type'        => 'taxonomy',
					'heading'     => esc_html__( 'Product Category', 'bianco' ),
					'param_name'  => 'taxonomy',
					'settings'    => array(
						'multiple'   => true,
						'hide_empty' => true,
						'taxonomy'   => 'product_cat',
					),
					'placeholder' => esc_html__( 'Choose category', 'bianco' ),
					'description' => esc_html__( 'Note: If you want to narrow output, select category(s) above. Only selected categories will be displayed.', 'bianco' ),
					'group'       => esc_html__( 'Products options', 'bianco' ),
					'dependency'  => array(
						'element'            => 'target',
						'value_not_equal_to' => array(
							'products',
						),
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Target', 'bianco' ),
					'param_name'  => 'target',
					'value'       => array(
						esc_html__( 'Best Selling Products', 'bianco' ) => 'best-selling',
						esc_html__( 'Top Rated Products', 'bianco' )    => 'top-rated',
						esc_html__( 'Recent Products', 'bianco' )       => 'recent-product',
						esc_html__( 'Product Category', 'bianco' )      => 'product-category',
						esc_html__( 'Products', 'bianco' )              => 'products',
						esc_html__( 'Featured Products', 'bianco' )     => 'featured_products',
						esc_html__( 'On Sale', 'bianco' )               => 'on_sale',
						esc_html__( 'On New', 'bianco' )                => 'on_new',
					),
					'description' => esc_html__( 'Choose the target to filter products', 'bianco' ),
					'std'         => 'recent-product',
					'group'       => esc_html__( 'Products options', 'bianco' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order by', 'bianco' ),
					'param_name'  => 'orderby',
					'value'       => array(
						esc_html__( 'Date', 'bianco' )          => 'date',
						esc_html__( 'ID', 'bianco' )            => 'ID',
						esc_html__( 'Author', 'bianco' )        => 'author',
						esc_html__( 'Title', 'bianco' )         => 'title',
						esc_html__( 'Modified', 'bianco' )      => 'modified',
						esc_html__( 'Random', 'bianco' )        => 'rand',
						esc_html__( 'Comment count', 'bianco' ) => 'comment_count',
						esc_html__( 'Menu order', 'bianco' )    => 'menu_order',
						esc_html__( 'Sale price', 'bianco' )    => '_sale_price',
					),
					'std'         => 'date',
					'description' => esc_html__( 'Select how to sort.', 'bianco' ),
					'dependency'  => array(
						'element'            => 'target',
						'value_not_equal_to' => array(
							'products',
						),
					),
					'group'       => esc_html__( 'Products options', 'bianco' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order', 'bianco' ),
					'param_name'  => 'order',
					'value'       => array(
						esc_html__( 'ASC', 'bianco' )  => 'ASC',
						esc_html__( 'DESC', 'bianco' ) => 'DESC',
					),
					'std'         => 'DESC',
					'description' => esc_html__( 'Designates the ascending or descending order.', 'bianco' ),
					'dependency'  => array(
						'element'            => 'target',
						'value_not_equal_to' => array(
							'products',
						),
					),
					'group'       => esc_html__( 'Products options', 'bianco' ),
				),
				array(
					'type'       => 'number',
					'heading'    => esc_html__( 'Product per page', 'bianco' ),
					'param_name' => 'per_page',
					'value'      => 6,
					'dependency' => array(
						'element'            => 'target',
						'value_not_equal_to' => array(
							'products',
						),
					),
					'group'      => esc_html__( 'Products options', 'bianco' ),
				),
				array(
					'type'        => 'autocomplete',
					'heading'     => esc_html__( 'Products', 'bianco' ),
					'param_name'  => 'ids',
					'settings'    => array(
						'multiple'      => true,
						'sortable'      => true,
						'unique_values' => true,
					),
					'save_always' => true,
					'description' => esc_html__( 'Enter List of Products', 'bianco' ),
					'dependency'  => array(
						'element' => 'target',
						'value'   => array( 'products' ),
					),
					'group'       => esc_html__( 'Products options', 'bianco' ),
				),
				array(
					'type'       => 'vc_link',
					'heading'    => esc_html__( 'Extent URL', 'bianco' ),
					'param_name' => 'link',
					'dependency' => array(
						'element' => 'layout',
						'value'   => array( 'style2' ),
					),
				),
				array(
					'type'       => 'bootstrap_v3',
					'heading'    => esc_html__( 'Bootstrap', 'bianco' ),
					'param_name' => 'bootstrap',
					'group'      => esc_html__( 'Bootstrap Settings', 'bianco' ),
					'dependency' => array(
						'element' => 'productsliststyle',
						'value'   => array( 'grid' ),
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Rows space', 'bianco' ),
					'param_name'  => 'owl_rows_space',
					'value'       => array(
						esc_html__( 'Default', 'bianco' ) => 'rows-space-0',
						esc_html__( '5px', 'bianco' )     => 'rows-space-5',
						esc_html__( '10px', 'bianco' )    => 'rows-space-10',
						esc_html__( '15px', 'bianco' )    => 'rows-space-15',
						esc_html__( '20px', 'bianco' )    => 'rows-space-20',
						esc_html__( '30px', 'bianco' )    => 'rows-space-30',
						esc_html__( '40px', 'bianco' )    => 'rows-space-40',
						esc_html__( '50px', 'bianco' )    => 'rows-space-50',
						esc_html__( '60px', 'bianco' )    => 'rows-space-60',
						esc_html__( '70px', 'bianco' )    => 'rows-space-70',
						esc_html__( '80px', 'bianco' )    => 'rows-space-80',
						esc_html__( '90px', 'bianco' )    => 'rows-space-90',
						esc_html__( '100px', 'bianco' )   => 'rows-space-100',
					),
					'std'         => 'rows-space-0',
					'save_always' => true,
					'dependency'  => array(
						'element' => 'productsliststyle',
						'value'   => array( 'owl','onbanner' ),
					),
					'group'       => esc_html__( 'Carousel Settings', 'bianco' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Navigation style', 'bianco' ),
					'param_name'  => 'owl_navigation_style',
                    'group'       => esc_html__( 'Carousel Settings', 'bianco' ),
					'value'       => array(
                        esc_html__( 'Default', 'bianco' ) => 'nav-default',
                        esc_html__( 'Style 1', 'bianco' ) => 'nav-style1',
                        esc_html__( 'Style 2', 'bianco' ) => 'nav-style2',
                        esc_html__( 'Style Top Right', 'bianco' ) => 'nav-top-right',
                        esc_html__( 'Style Bottom Right', 'bianco' ) => 'nav-bottom-right',
                        esc_html__( 'Style Bottom Label', 'bianco' ) => 'nav-bottom-label',
					),
					'std'         => 'nav-default',
					'save_always' => true,
					'dependency'  => array( 'element' => 'productsliststyle', 'value'   => array('owl', 'onbanner')),
				),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Next Label', 'bianco' ),
                    'param_name'  => 'lbl_next_nav',
                    'group'       => esc_html__( 'Carousel Settings', 'bianco' ),
                    'std'         => 'Next',
                    'dependency'  => array( 'element' => 'owl_navigation_style', 'value' => 'nav-bottom-label' ),
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Previous Label', 'bianco' ),
                    'param_name'  => 'lbl_prev_nav',
                    'group'       => esc_html__( 'Carousel Settings', 'bianco' ),
                    'std'         => 'Previuos',
                    'dependency'  => array( 'element' => 'owl_navigation_style', 'value' => 'nav-bottom-label' ),
                ),
				array(
					'type'       => 'carousel',
					'heading'    => esc_html__( 'Carousel', 'bianco' ),
					'param_name' => 'carousel',
					'group'      => esc_html__( 'Carousel Settings', 'bianco' ),
					'dependency' => array(
						'element' => 'productsliststyle',
						'value'   => array( 'owl','onbanner' ),
					),
				),
			),
		);

		/* TODO: ovic_tabs */
		$param['ovic_tabs'] = array(
			'base'                    => 'ovic_tabs',
			'name'                    => esc_html__( 'Ovic: Tabs', 'bianco' ),
			'icon'                    => "{$icom_uri}/tab.svg",
			'category'                => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description'             => esc_html__( 'Display Tabs', 'bianco' ),
			'is_container'            => true,
			'show_settings_on_create' => false,
			'as_parent'               => array(
				'only' => 'vc_tta_section',
			),
			'params'                  => array(
				array(
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Select style', 'bianco' ),
					'value'       => array(
						'default' => array(
							'title'   => esc_html__( 'Default', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic_tabs/tab-default.jpg",
						),
                        'on_left' => array(
                            'title'   => esc_html__( 'Tab On Left', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_tabs/tab-left.jpg",
                        ),
                        'on_right' => array(
                            'title'   => esc_html__( 'Tab On Right', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_tabs/tab-right.jpg",
                        ),
                        'on_right_2' => array(
                            'title'   => esc_html__( 'Tab On Right 2', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_tabs/tab-right-2.jpg",
                        ),
                        'on_top' => array(
                            'title'   => esc_html__( 'Tab On Top', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_tabs/tab-top.jpg",
                        ),
					),
					'default'     => 'default',
					'admin_label' => true,
					'param_name'  => 'style',
				),
				array(
                    "type"       => 'colorpicker',
                    "value"      => $main_color,
                    "heading"    => esc_html__( "Border Active Color", 'bianco' ),
                    "param_name" => "border_active_color",
                    'dependency'  => array( 'element'  => 'style', 'value_not_equal_to' => array('on_right','on_right_2')),
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Tab Title', 'bianco' ),
                    'param_name'  => 'tab_title',
                    'std'         => 'Hot new Arrivals',
                    'dependency'  => array( 'element' => 'style', 'value' => array('on_right','on_right_2')),
                ),
                array(
                    "type"       => 'colorpicker',
                    "value"      => $main_color,
                    "heading"    => esc_html__( "Background Of Active Tab", 'bianco' ),
                    "param_name" => "bg_active_color",
                    'dependency' => array( 'element' => 'style', 'value' => array('on_right','on_right_2')),
                ),
                array(
                    'type'       => 'vc_link',
                    'heading'    => esc_html__( 'Link View More', 'bianco' ),
                    'param_name' => 'link_view_more',
                    'dependency' => array( 'element' => 'style', 'value' => 'on_left' ),
                ),
				vc_map_add_css_animation(),
				array(
					'param_name' => 'ajax_check',
					'heading'    => esc_html__( 'Using Ajax Tabs', 'bianco' ),
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Yes', 'bianco' ) => '1',
						esc_html__( 'No', 'bianco' )  => '0',
					),
					'std'        => '0',
				),
				array(
					'type'       => 'number',
					'heading'    => esc_html__( 'Active Section', 'bianco' ),
					'param_name' => 'active_section',
					'std'        => 0,
				),
			),
			'js_view'                 => 'VcBackendTtaTabsView',
			'custom_markup'           => '
                    <div class="vc_tta-container" data-vc-action="collapse">
                        <div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
                            <div class="vc_tta-tabs-container">'
				. '<ul class="vc_tta-tabs-list">'
				. '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="vc_tta_section"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>'
				. '</ul>
                            </div>
                            <div class="vc_tta-panels vc_clearfix {{container-class}}">
                              {{ content }}
                            </div>
                        </div>
                    </div>',
			'default_content'         => '
                        [vc_tta_section title="' . sprintf( '%s %d', esc_html__( 'Tab', 'bianco' ), 1 ) . '"][/vc_tta_section]
                        [vc_tta_section title="' . sprintf( '%s %d', esc_html__( 'Tab', 'bianco' ), 2 ) . '"][/vc_tta_section]
                    ',
			'admin_enqueue_js'        => array(
				vc_asset_url( 'lib/vc_tabs/vc-tabs.min.js' ),
			),
		);

		/* TODO: ovic_tabs */
		$param['ovic_tab_title'] = array(
			'base'        => 'ovic_tab_title',
			'name'        => esc_html__( 'Ovic: Tab Title', 'bianco' ),
			'icon'        => "{$icom_uri}/edit-text.svg",
			'category'    => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description' => esc_html__( 'Create a title ahead of Tab', 'bianco' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'bianco' ),
					'param_name'  => 'tab_title',
					'description' => esc_html__( 'The title', 'bianco' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'param_name'  => 'type',
					'heading'     => esc_html__( 'Icon library', 'bianco' ),
					'value'       => array(
						esc_html__( 'Font Awesome', 'bianco' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'bianco' )  => 'openiconic',
						esc_html__( 'Typicons', 'bianco' )     => 'typicons',
						esc_html__( 'Entypo', 'bianco' )       => 'entypo',
						esc_html__( 'Linecons', 'bianco' )     => 'linecons',
						esc_html__( 'Mono Social', 'bianco' )  => 'monosocial',
						esc_html__( 'Material', 'bianco' )     => 'material',
						esc_html__( 'Ovic Fonts', 'bianco' )   => 'oviccustomfonts',
					),
					'description' => esc_html__( 'Select icon library.', 'bianco' ),
				),
				array(
					'param_name'  => 'icon_oviccustomfonts',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
					'type'        => 'iconpicker',
					'settings'    => array(
						'emptyIcon' => false,
						'type'      => 'oviccustomfonts',
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'oviccustomfonts',
					),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_fontawesome',
					'value'       => 'fa fa-adjust',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'fontawesome',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_openiconic',
					'value'       => 'vc-oi vc-oi-dial',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'openiconic',
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'openiconic',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_typicons',
					'value'       => 'typcn typcn-adjust-brightness',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'typicons',
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'typicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'bianco' ),
					'param_name' => 'icon_entypo',
					'value'      => 'entypo-icon entypo-icon-note',
					'settings'   => array(
						'emptyIcon'    => false,
						'type'         => 'entypo',
						'iconsPerPage' => 100,
					),
					'dependency' => array(
						'element' => 'type',
						'value'   => 'entypo',
					),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_linecons',
					'value'       => 'vc_li vc_li-heart',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'linecons',
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'linecons',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_monosocial',
					'value'       => 'vc-mono vc-mono-fivehundredpx',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'monosocial',
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'monosocial',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'bianco' ),
					'param_name'  => 'icon_material',
					'value'       => 'vc-material vc-material-cake',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'material',
						'iconsPerPage' => 100,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'material',
					),
					'description' => esc_html__( 'Select icon from library.', 'bianco' ),
				),
				array(
					"type"       => 'colorpicker',
					"value"      => '#03a9f4',
					"heading"    => esc_html__( "Background color", 'bianco' ),
					"param_name" => "background_color",
				),
			),
		);

		/* TODO: ovic_newsletter */
		$param['ovic_newsletter'] = array(
			'base'        => 'ovic_newsletter',
			'name'        => esc_html__( 'Ovic: Newsletter', 'bianco' ),
			'icon'        => "{$icom_uri}/newsletter.svg",
			'category'    => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description' => esc_html__( 'Display Newsletter', 'bianco' ),
			'params'      => array(
				array(
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Select style', 'bianco' ),
					'value'       => array(
						'default-layout' => array(
							'title'   => esc_html__( 'Default', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic_newsletter/default-layout.jpg",
						),
                        'inline' => array(
                            'title'   => esc_html__( 'Inline', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_newsletter/inline.jpg",
                        ),
                        'squares' => array(
                            'title'   => esc_html__( 'Squares', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_newsletter/squares.jpg",
                        ),
					),
					'default'     => 'default-layout',
					'admin_label' => true,
					'param_name'  => 'style',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title', 'bianco' ),
					'param_name' => 'title',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Subtitle', 'bianco' ),
					'param_name' => 'subtitle',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Show Field Name', 'bianco' ),
					'param_name' => 'field_name',
					'value'      => array(
						esc_html__( 'Yes', 'bianco' ) => 'yes',
						esc_html__( 'No', 'bianco' )  => 'no',
					),
					'std'        => 'no',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'First Name Text', 'bianco' ),
					'param_name' => 'fname_text',
					'std'        => esc_html__( 'First Name', 'bianco' ),
					'dependency' => array(
						'element' => 'field_name',
						'value'   => 'yes',
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Last Name Text', 'bianco' ),
					'param_name' => 'lname_text',
					'std'        => esc_html__( 'Last Name', 'bianco' ),
					'dependency' => array(
						'element' => 'field_name',
						'value'   => 'yes',
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Placeholder Text', 'bianco' ),
					'param_name' => 'placeholder',
					'std'        => esc_html__( 'Your email letter', 'bianco' ),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Button Text', 'bianco' ),
					'param_name' => 'button_text',
					'std'        => esc_html__( 'Subscribe', 'bianco' ),
				),
			),
		);

		/* TODO: ovic_banner */
		$param['ovic_banner'] = array(
			'base'        => 'ovic_banner',
			'name'        => esc_html__( 'Ovic: Banner', 'bianco' ),
			'icon'        => "{$icom_uri}/banner.svg",
			'category'    => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description' => esc_html__( 'Your can build banner here', 'bianco' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Layout', 'bianco' ),
					'param_name'  => 'layout',
					'type'        => 'select_preview',
					'value'       => $banner_options,
					'default'     => 'default',
					'admin_label' => true,
				),
                array(
                    'heading'     => esc_html__( 'Banner Style', 'bianco' ),
                    'param_name'  => 'layout_type',
                    'type'        => 'select_preview',
                    'admin_label' => true,
                    'value'       => array(
                        'type01' => array(
                            'title'   => esc_html__( 'Style 01', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_banner/style38_01.jpg",
                        ),
                        'type02' => array(
                            'title'   => esc_html__( 'Style 02', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_banner/style38_02.jpg",
                        ),
                        'type03' => array(
                            'title'   => esc_html__( 'Style 03', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_banner/style38_03.jpg",
                        ),
                        'type04' => array(
                            'title'   => esc_html__( 'Style 04', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_banner/style38_04.jpg",
                        ),
                    ),
                    'default'     => 'style01',
                    'dependency'  => array(
                        'element' => 'layout',
                        'value'   => 'style38',
                    ),
                ),
				array(
					"type"        => "attach_image",
					"heading"     => esc_html__( "Main Background", 'bianco' ),
					"param_name"  => "image",
                    'admin_label' => true,
                    'dependency'  => array(
                        "element" => "layout",
                        'value_not_equal_to' => array( 'style14', 'style25', 'style36', 'style37'),
                    ),
				),
                array(
                    "type"        => "attach_image",
                    "heading"     => esc_html__( 'Object Image', 'bianco' ),
                    "param_name"  => 'obj_image',
                    'admin_label' => true,
                    'dependency'  => array(
                        'element'   => 'layout',
                        'value'     => array( 'style36', 'style37' ),
                    ),
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__( 'Background Color', 'bianco' ),
                    'description' => esc_html__( 'This is the main background color of the banner', 'bianco' ),
                    'value'       => '#fafafa',
                    'param_name'  => 'main_bgcolor',
                    'dependency'  => array(
                        'element' => 'layout',
                        'value'   => array( 'style36', 'style37' ),
                    ),
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Effect Banner', 'bianco' ),
                    'description' => esc_html__( 'Select an effect for this banner', 'bianco' ),
                    'param_name'  => 'banner_effect',
                    'std'         => '',
                    'value'       => array(
                        esc_html__( 'None', 'bianco' )            => '',
                        esc_html__( 'Default', 'bianco' )         => 'default',
                        esc_html__( 'Zoom In', 'bianco' )         => 'banner-effect-1',
                        esc_html__( 'Left Overlay', 'bianco' )    => 'left-overlay-effect',
                        esc_html__( 'Dark Background', 'bianco' ) => 'effect effect16',
                        esc_html__( 'Box Shadow', 'bianco' )      => 'effect effect20',
                    ),
                    'dependency'  => array(
                        'element'               => 'layout',
                        'value_not_equal_to'    => $except_effect_to_banners,
                    ),
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Effect Banner', 'bianco' ),
                    'description' => esc_html__( 'Select an effect for this banner', 'bianco' ),
                    'param_name'  => 'banner_effect_2',
                    'std'         => '',
                    'value'       => array(
                        esc_html__( 'None', 'bianco' )      => '',
                        esc_html__( 'Zoom in', 'bianco' )   => 'banner-effect zoom-in',
                    ),
                    'dependency'  => array(
                        'element'   => 'layout',
                        'value'     => array('style36', 'style37'),
                    ),
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Effect Banner', 'bianco' ),
                    'description' => esc_html__( 'Select an effect for this banner', 'bianco' ),
                    'param_name'  => 'banner_effect_3',
                    'std'         => '',
                    'value'       => array(
                        esc_html__( 'None', 'bianco' )      => '',
                        esc_html__( 'Translate to left', 'bianco' )     => 'bn-effect ef-toleft',
                        esc_html__( 'Translate to right', 'bianco' )    => 'bn-effect ef-toright',
                        esc_html__( 'Overlay Popup', 'bianco' )         => 'bn-effect ef-overlay-popup',
                        esc_html__( 'Border box ', 'bianco' )           => 'bn-effect ef-borderbox',
                    ),
                    'dependency'  => array(
                        'element'   => 'layout',
                        'value'     => array('style38'),
                    ),
                ),
                array(
                    "type"        => "attach_image",
                    "heading"     => esc_html__( 'image title', 'bianco' ),
                    "param_name"  => "img_title",
                    'dependency'  => array(
                        "element" => "layout",
                        "value" => array( 'style17')
                    ),
                ),
                array(
                    "type"        => "attach_image",
                    "heading"     => esc_html__( 'Product Image', 'bianco' ),
                    "param_name"  => "prd_img",
                    'description' => esc_html__( 'Pictures represent the product', 'bianco' ),
                    'dependency'  => array( "element" => "layout", "value" => array('style23', 'style28', 'style29', 'style30')),
                ),
                $bianco_animation_for_banner,
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Text 1', 'bianco' ),
					'description' => esc_html__( 'Enter the text on banner', 'bianco' ),
					'param_name'  => 'text_1',
                    'dependency'  => array(
                        "element" => "layout",
                        'value_not_equal_to' => array('default','style27'),
                    ),
				),
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Text 2', 'bianco' ),
					'description' => esc_html__( 'Enter the text on banner', 'bianco' ),
					'param_name'  => 'text_2',
                    'dependency'  => array(
                        'element' => 'layout',
                        'value_not_equal_to' => array('default','style20','style27','style38'),
                    ),
				),
                array(
                    'type'        => 'textarea',
                    'heading'     => esc_html__( 'Text 3', 'bianco' ),
                    'description' => esc_html__( 'Enter the text on banner', 'bianco' ),
                    'param_name'  => 'text_3',
                    'dependency'  => array(
                        "element" => "layout",
                        "value"   => $banner_text3_dependencies,
					),
				),
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Text 4', 'bianco' ),
					'description' => esc_html__( 'Enter the text on banner', 'bianco' ),
					'param_name'  => 'text_4',
					'dependency'  => array(
						"element" => "layout",
						"value"   => $banner_text4_dependencies,
					),
				),
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Text 5', 'bianco' ),
					'description' => esc_html__( 'Enter the text on banner', 'bianco' ),
					'param_name'  => 'text_5',
					'dependency'  => array(
						"element" => "layout",
						"value"   => array( 'style12', 'style13','style21','style22','style23' ),
					),
				),
                array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Text 6', 'bianco' ),
					'description' => esc_html__( 'Enter the text on banner', 'bianco' ),
					'param_name'  => 'text_6',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => array( 'style21' ),
					),
				),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Button label', 'bianco' ),
                    'param_name'  => 'btn_lable',
                    'dependency'  => array(
                        'element' => 'layout',
                        'value'   => array( 'deal_2' ),
                    ),
                ),
                array(
                    'type'       => 'datepicker',
                    'heading'    => esc_html__( 'Expiration Date', 'bianco' ),
                    'param_name' => 'countdown_date',
                    'dependency' => array(
                        'element'   => 'layout',
                        'value'     => array( 'deal'),
                    ),
                    'std'        => date( 'm/d/Y H:i:s' ),
                ),
                array(
                    'type'        => 'autocomplete',
                    'heading'     => esc_html__( 'Products', 'bianco' ),
                    'param_name'  => 'ids',
                    'settings'    => array(
                        'multiple'      => false,
                        'sortable'      => true,
                        'unique_values' => true,
                    ),
                    'save_always' => true,
                    'description' => esc_html__( 'Enter the Products', 'bianco' ),
                    'dependency'  => array( "element" => "layout", "value" => array( 'deal','deal_2','style23','style27'), ),
                ),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Extent Link', 'bianco' ),
					'param_name'  => 'link',
                    'dependency'  => array(
                        'element'               => 'layout',
                        'value_not_equal_to'    => array('deal_2','style23','style27','style29'),
                    ),
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( "Button color", 'bianco' ),
					'description' => esc_html__( 'This is the background color of the button', 'bianco' ),
					'value'       => $main_color,
					'param_name'  => 'btn_bgcolor',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => $dependencies_btn_bgcolor,
					),
				),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__( "Button color", 'bianco' ),
                    'value'       => $main_color,
                    'param_name'  => 'btn_color',
                    'dependency'  => array(
                        'element' => 'layout',
                        'value'   => 'style39',
                    ),
                ),
			),
		);

		/* TODO: ovic_slide */
		$param['ovic_slide'] = array(
			'base'                    => 'ovic_slide',
			'name'                    => esc_html__( 'Ovic: Slide', 'bianco' ),
			'icon'                    => "{$icom_uri}/slider.svg",
			'category'                => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description'             => esc_html__( 'Display Slide', 'bianco' ),
			'as_parent'               => array(
				'only' => 'vc_single_image, vc_custom_heading, ovic_person, vc_column_text, ovic_iconbox, ovic_banner, ovic_product, ovic_category, ovic_custommenu, ovic_socials, vc_row',
			),
			'content_element'         => true,
			'show_settings_on_create' => true,
			'js_view'                 => 'VcColumnView',
			'params'                  => array(
				array(
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Select style', 'bianco' ),
					'value'       => array(
						'default'        => array(
							'title'   => esc_html__( 'Default', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic-slide/slide_default.jpg",
						),
						'brand-layout'   => array(
							'title'   => esc_html__( 'Brand Layout', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic-slide/brand-layout.jpg",
						),
						'brand-vertical' => array(
							'title'   => esc_html__( 'Brand Vertical', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic-slide/vertical-layout.jpg",
						),
                        'testimonials' => array(
							'title'   => esc_html__( 'Testimonials', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic-slide/testimonials.jpg",
						),
					),
					'default'     => 'default',
					'admin_label' => true,
					'param_name'  => 'style',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'bianco' ),
					'param_name'  => 'slider_title',
					'dependency'  => array(
						'element' => 'style',
						'value'   => array( 'default', 'testimonials' ),
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Rows space', 'bianco' ),
					'param_name'  => 'owl_rows_space',
					'value'       => array(
						esc_html__( 'Default', 'bianco' ) => 'rows-space-0',
						esc_html__( '5px', 'bianco' )     => 'rows-space-5',
						esc_html__( '10px', 'bianco' )    => 'rows-space-10',
						esc_html__( '15px', 'bianco' )    => 'rows-space-15',
						esc_html__( '20px', 'bianco' )    => 'rows-space-20',
						esc_html__( '30px', 'bianco' )    => 'rows-space-30',
						esc_html__( '40px', 'bianco' )    => 'rows-space-40',
						esc_html__( '50px', 'bianco' )    => 'rows-space-50',
						esc_html__( '60px', 'bianco' )    => 'rows-space-60',
						esc_html__( '70px', 'bianco' )    => 'rows-space-70',
						esc_html__( '80px', 'bianco' )    => 'rows-space-80',
						esc_html__( '90px', 'bianco' )    => 'rows-space-90',
						esc_html__( '100px', 'bianco' )   => 'rows-space-100',
					),
					'std'         => 'rows-space-0',
					'save_always' => true,
					'group'       => esc_html__( 'Carousel Settings', 'bianco' ),
				),
				array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Navigation style', 'bianco' ),
                    'param_name'  => 'owl_navigation_style',
                    'value'       => array(
                        esc_html__( 'Default', 'bianco' ) => 'nav-default',
                        esc_html__( 'Style 1', 'bianco' ) => 'nav-style1',
                        esc_html__( 'Style 2', 'bianco' ) => 'nav-style2',
                        esc_html__( 'Style Top Right', 'bianco' ) => 'nav-top-right',
                        esc_html__( 'Style Bottom Right', 'bianco' ) => 'nav-bottom-right',
                    ),
                    'std'         => 'nav-default',
                    'save_always' => true,
                    'group'       => esc_html__( 'Carousel Settings', 'bianco' ),
                ),
                array(
                    "type"       => 'colorpicker',
                    "value"      => '#03a9f4',
                    "heading"    => esc_html__( "Dot Color", 'bianco' ),
                    "param_name" => "dot_color",
                    'dependency' => array( "element" => "style", "value" => array( 'default' ) ),
                ),
				array(
					'type'       => 'carousel',
					'heading'    => esc_html__( 'Carousel', 'bianco' ),
					'param_name' => 'carousel',
					'group'      => esc_html__( 'Carousel Settings', 'bianco' ),
				),
			),
		);

		/* TODO: ovic_blog */
		$param['ovic_blog'] = array(
			'base'        => 'ovic_blog',
			'name'        => esc_html__( 'Ovic: Blog', 'bianco' ),
			'icon'        => "{$icom_uri}/blogger.svg",
			'category'    => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description' => esc_html__( 'Display Blog', 'bianco' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'bianco' ),
					'param_name'  => 'blog_title',
					'admin_label' => true,
				),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Title\'s Position', 'bianco' ),
                    'param_name'  => 'title_type',
                    'value'       => array(
                        esc_html__( 'Center', 'bianco' ) => 'title-center',
                        esc_html__( 'Left', 'bianco' ) => 'title-left',
                    ),
                    'std'         => 'title-center',
                ),
				array(
					'type'        => 'select_preview',
					'param_name'  => 'blog_style',
					'heading'     => esc_html__( 'Blog style', 'bianco' ),
					'description' => esc_html__( 'Select a style for blog item', 'bianco' ),
					'admin_label' => true,
					'value'       => array(
						'style-1' => array(
							'title'   => esc_html__( 'Style 1', 'bianco' ),
							'preview' => "{$blogpost_templates_uri}style-1.jpg",
						),
						'style-2' => array(
							'title'   => esc_html__( 'Style 2', 'bianco' ),
							'preview' => "{$blogpost_templates_uri}style-2.jpg",
						),
                        'style-3' => array(
                            'title'   => esc_html__( 'Style 3', 'bianco' ),
                            'preview' => "{$blogpost_templates_uri}style-3.jpg",
                        ),
					),
					'default'     => 'style-1',
				),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Thumbnail size', 'bianco' ),
                    'param_name'  => 'thumb_size',
                    'value'       => array(
                        esc_html__( 'Default_(370x250)', 'bianco' ) => 'default',
                        esc_html__( 'Size 01_(300x250)', 'bianco' ) => 'size-01',
                        esc_html__( 'Custom', 'bianco' ) => 'custom',
                    ),
                    'std'         => 'default',
                ),
                array(
                    'type'       => 'textfield',
                    'heading'    => esc_html__( 'Custom thumbnail size', 'bianco' ),
                    'description' => esc_html__( 'Enter image size in pixels (Example: 200x100 (Width x Height)).', 'bianco' ),
                    'param_name' => 'thumb_size_custom',
                    'dependency' => array(
                        'element' => 'thumb_size',
                        'value'   => array( 'custom' ),
                    ),
                ),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Target', 'bianco' ),
					'param_name'  => 'target',
					'value'       => array(
						esc_html__( 'Recent Post', 'bianco' ) => 'recent_post',
						esc_html__( 'Popularity', 'bianco' )  => 'popularity',
						esc_html__( 'Select Post', 'bianco' ) => 'post',
					),
					'admin_label' => true,
					'description' => esc_html__( 'Choose the target to filter Blog', 'bianco' ),
					'std'         => 'recent_post',
					'group'       => esc_html__( 'Blog Settings', 'bianco' ),
				),
				array(
					'type'       => 'autocomplete',
					'heading'    => esc_html__( 'Find Post', 'bianco' ),
					'param_name' => 'ids',
					'settings'   => array(
						'multiple' => true,
						'sortable' => true,
						'groups'   => false,
					),
					'dependency' => array(
						'element' => 'target',
						'value'   => array( 'post' ),
					),
					'group'      => esc_html__( 'Blog Settings', 'bianco' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Category Blog', 'bianco' ),
					'param_name'  => 'category',
					'value'       => $categories_array,
					'dependency'  => array(
						'element'            => 'target',
						'value_not_equal_to' => 'post',
					),
					'group'       => esc_html__( 'Blog Settings', 'bianco' ),
					'description' => esc_html__( 'Note: If you want to narrow output, select Category(s) above. Only selected Brand will be displayed.', 'bianco' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Per page', 'bianco' ),
					'value'       => 6,
					'param_name'  => 'limit',
					'admin_label' => true,
					'dependency'  => array(
						'element'            => 'target',
						'value_not_equal_to' => 'post',
					),
					'group'       => esc_html__( 'Blog Settings', 'bianco' ),
					'description' => esc_html__( 'How much items per page to show', 'bianco' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order by', 'bianco' ),
					'param_name'  => 'orderby',
					'value'       => array(
						'',
						esc_html__( 'Date', 'bianco' )          => 'date',
						esc_html__( 'ID', 'bianco' )            => 'ID',
						esc_html__( 'Author', 'bianco' )        => 'author',
						esc_html__( 'Title', 'bianco' )         => 'title',
						esc_html__( 'Modified', 'bianco' )      => 'modified',
						esc_html__( 'Random', 'bianco' )        => 'rand',
						esc_html__( 'Comment count', 'bianco' ) => 'comment_count',
						esc_html__( 'Menu order', 'bianco' )    => 'menu_order',
						esc_html__( 'Post In', 'bianco' )       => 'post__in',
					),
					'dependency'  => array(
						'element'            => 'target',
						'value_not_equal_to' => 'popularity',
					),
					'group'       => esc_html__( 'Blog Settings', 'bianco' ),
					'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'bianco' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Sort order', 'bianco' ),
					'param_name'  => 'order',
					'value'       => array(
						'',
						esc_html__( 'Descending', 'bianco' ) => 'DESC',
						esc_html__( 'Ascending', 'bianco' )  => 'ASC',
					),
					'group'       => esc_html__( 'Blog Settings', 'bianco' ),
					'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'bianco' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Rows space', 'bianco' ),
					'param_name'  => 'owl_rows_space',
					'value'       => array(
						esc_html__( 'Default', 'bianco' ) => 'rows-space-0',
						esc_html__( '5px', 'bianco' )     => 'rows-space-5',
						esc_html__( '10px', 'bianco' )    => 'rows-space-10',
						esc_html__( '15px', 'bianco' )    => 'rows-space-15',
						esc_html__( '20px', 'bianco' )    => 'rows-space-20',
						esc_html__( '30px', 'bianco' )    => 'rows-space-30',
						esc_html__( '40px', 'bianco' )    => 'rows-space-40',
						esc_html__( '50px', 'bianco' )    => 'rows-space-50',
						esc_html__( '60px', 'bianco' )    => 'rows-space-60',
						esc_html__( '70px', 'bianco' )    => 'rows-space-70',
						esc_html__( '80px', 'bianco' )    => 'rows-space-80',
						esc_html__( '90px', 'bianco' )    => 'rows-space-90',
						esc_html__( '100px', 'bianco' )   => 'rows-space-100',
					),
					'std'         => 'rows-space-0',
					'save_always' => true,
					'group'       => esc_html__( 'Carousel Settings', 'bianco' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Navigation style', 'bianco' ),
					'param_name'  => 'owl_navigation_style',
					'value'       => array(
                        esc_html__( 'Default', 'bianco' ) => 'nav-default',
                        esc_html__( 'Style 1', 'bianco' ) => 'nav-style1',
                        esc_html__( 'Style 2', 'bianco' ) => 'nav-style2',
                        esc_html__( 'Style Top Right', 'bianco' ) => 'nav-top-right',
                        esc_html__( 'Style Bottom Right', 'bianco' ) => 'nav-bottom-right',
					),
					'std'         => 'nav-default',
					'save_always' => true,
					'group'       => esc_html__( 'Carousel Settings', 'bianco' ),
				),
				array(
					'type'       => 'carousel',
					'heading'    => esc_html__( 'Carousel', 'bianco' ),
					'param_name' => 'carousel',
					'group'      => esc_html__( 'Carousel Settings', 'bianco' ),
				),
			),
		);

		/* TODO: ovic_socials */
		$param['ovic_socials'] = array(
			'base'        => 'ovic_socials',
			'name'        => esc_html__( 'Ovic: Socials', 'bianco' ),
			'icon'        => "{$icom_uri}/share.svg",
			'category'    => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description' => esc_html__( 'Display Socials', 'bianco' ),
			'params'      => array(
				array(
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Select Style', 'bianco' ),
					'value'       => array(
						'default-layout' => array(
							'title'   => esc_html__( 'Default Layout', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic_socials/default-layout.jpg",
						),
                        'layout-01' => array(
                            'title'   => esc_html__( 'Layout 01', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_socials/layout-01.jpg",
                        ),
                        'layout-02' => array(
                            'title'   => esc_html__( 'Layout 02', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic_socials/layout-02.jpg",
                        ),
					),
					'default'     => 'default-layout',
					'admin_label' => true,
					'param_name'  => 'style',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'bianco' ),
					'param_name'  => 'title',
					'default'     => '',
					'admin_label' => true,
                    'dependency'  => array(
                        'element' => 'style',
                        'value' => 'default-layout',
                    ),
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'List Social', 'bianco' ),
					'param_name' => 'socials',
					'value'      => $socials,
				),
			),
		);

		/* TODO: ovic_custommenu */
		$param['ovic_custommenu'] = array(
			'base'        => 'ovic_custommenu',
			'name'        => esc_html__( 'Ovic: Custom Menu', 'bianco' ),
            'icon'        => "{$icom_uri}/list.svg",
			'category'    => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description' => esc_html__( 'Display Custom Menu', 'bianco' ),
			'params'      => array(
				array(
					'param_name'  => 'style_menu',
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Select Layout Style', 'bianco' ),
					'value'       => array(
						'default'      => array(
							'title'   => esc_html__( 'Default', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic-custom-menu/default.jpg",
						),
						'layout-01' => array(
							'title'   => esc_html__( 'Layout 01', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic-custom-menu/layout-01.jpg",
						),
                        'twice-inline' => array(
							'title'   => esc_html__( 'Double', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic-custom-menu/twice-inline.jpg",
						),
                        'inline' => array(
                            'title'   => esc_html__( 'Inline', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic-custom-menu/inline.jpg",
                        ),
                        'mega-child-01' => array(
							'title'   => esc_html__( 'Mega Child 01', 'bianco' ),
							'preview' => "{$shortcode_preview}/ovic-custom-menu/mega_child_01.jpg",
						),
                        'mega-child-02' => array(
                            'title'   => esc_html__( 'Mega Child 02', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic-custom-menu/mega_child_02.jpg",
                        ),
                        'vertical-mega' => array(
                            'title'   => esc_html__( 'Vertical Mega', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic-custom-menu/vertical_mega.jpg",
                        ),
					),
					'default'     => 'default',
					'admin_label' => true,
				),
                array(
                    "type"        => "attach_image",
                    "heading"     => esc_html__( "Image", 'bianco' ),
                    "param_name"  => "lbl_top",
                    'description' => esc_html__( 'This image is shown on the top of shortcode', 'bianco' ),
                    'admin_label' => true,
                    'dependency'  => array(
                        "element" => "style_menu",
                        "value"   => 'mega-child-02',
                    ),
                ),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'bianco' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'What text use as a widget title. Leave blank to use default widget title.', 'bianco' ),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'style_menu',
						'value'   => array( 'default','mega-child-01','mega-child-02','layout-01','vertical-mega'),
					),
				),
				array(
					"type"       => 'colorpicker',
					"value"      => '#03a9f4',
					"heading"    => esc_html__( 'Color On Hover Item', 'bianco' ),
					"param_name" => "hover_color",
					'dependency' => array( "element" => "style_menu", "value" => array( 'twice-inline' ) ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Menu', 'bianco' ),
					'description' => esc_html__( 'Select menu to display.', 'bianco' ),
					'value'       => $all_menu,
					'admin_label' => true,
					'param_name'  => 'nav_menu',
				),
                array(
                    "type"        => "attach_image",
                    "heading"     => esc_html__( "Image", 'bianco' ),
                    "param_name"  => "menu_banner",
                    'dependency' => array( "element" => "style_menu", "value"   => 'vertical-mega'),
                ),
			),
		);

		/* TODO: ovic_timeline */
		$param['ovic_timeline'] = array(
			'base'                    => 'ovic_timeline',
			'name'                    => esc_html__( 'Ovic: Timeline', 'bianco' ),
			'icon'                    => "{$icom_uri}/timeline.svg",
			'category'                => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description'             => esc_html__( 'Create a list events', 'bianco' ),
			'as_parent'               => array(
				'only' => 'ovic_event',
			),
			'content_element'         => true,
			'show_settings_on_create' => true,
			'js_view'                 => 'VcColumnView',
			'params'                  => array(
				array(
					'type'        => 'select_preview',
					'heading'     => esc_html__( 'Select style', 'bianco' ),
					'value'       => array(
						'default' => array(
							'title'   => esc_html__( 'Default', 'bianco' ),
							'preview' => '',
						),
					),
					'default'     => 'default',
					'admin_label' => true,
					'param_name'  => 'style',
				),
				array(
					'param_name'  => 'title',
					'type'        => 'textfield',
					'heading'     => esc_html__( 'title', 'bianco' ),
					'value'       => esc_html__( 'Company History', 'bianco' ),
					'admin_label' => true,
				),
			),
		);

		/* TODO: ovic_event */
		$param['ovic_event']     = array(
			'base'            => 'ovic_event',
			'name'            => esc_html__( 'Ovic: Event', 'bianco' ),
			'icon'            => "{$icom_uri}/calendar.svg",
			'category'        => esc_html__( 'Ovic Shortcode', 'bianco' ),
			'description'     => esc_html__( 'Create an event', 'bianco' ),
			"content_element" => true,
			"as_child"        => array( 'only' => 'ovic_timeline' ),
			'params'          => array(
				array(
					'param_name'  => 'year',
					'type'        => 'textfield',
					'heading'     => esc_html__( 'In Year', 'bianco' ),
					'value'       => '2018',
					'admin_label' => true,
				),
				array(
					'type'       => 'param_group',
					'value'      => '',
					'heading'    => esc_html__( 'Event info', 'bianco' ),
					'param_name' => 'events',
					// Note params is mapped inside param-group:
					'params'     => array(
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Month of event', 'bianco' ),
							'param_name'  => 'month',
							'admin_label' => true,
							'value'       => array(
								esc_html__( 'January', 'bianco' )   => '01',
								esc_html__( 'February', 'bianco' )  => '02',
								esc_html__( 'March', 'bianco' )     => '03',
								esc_html__( 'April', 'bianco' )     => '04',
								esc_html__( 'May', 'bianco' )       => '05',
								esc_html__( 'June', 'bianco' )      => '06',
								esc_html__( 'July', 'bianco' )      => '07',
								esc_html__( 'August', 'bianco' )    => '08',
								esc_html__( 'September', 'bianco' ) => '09',
								esc_html__( 'October', 'bianco' )   => '10',
								esc_html__( 'November', 'bianco' )  => '11',
								esc_html__( 'December', 'bianco' )  => '12',
							),
							'std'         => '01',
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Type', 'bianco' ),
							'value'       => array(
								esc_html__( 'IMAGE', 'bianco' )    => 'image',
								esc_html__( 'RAW TEXT', 'bianco' ) => 'text',
							),
							'param_name'  => 'type',
							'description' => esc_html__( 'Choose media type you want to use', 'bianco' ),
						),
						array(
							'type'       => 'attach_image',
							'heading'    => esc_html__( 'Image', 'bianco' ),
							'param_name' => 'image',
							'dependency' => array( 'element' => 'type', 'value' => 'image', ),
						),
						array(
							'type'       => 'textarea',
							'value'      => '',
							'heading'    => esc_html__( 'Add more information to describe your event ', 'bianco' ),
							'param_name' => 'desc',
							'dependency' => array( 'element' => 'type', 'value' => 'text', ),
						),
					),
				),
			),
		);

        /* TODO: ovic_map */
        $param['ovic_map']        = array(
            'base'        => 'ovic_map',
            'name'        => esc_html__( 'Ovic: Google Map', 'bianco' ),
            'icon'        => "{$icom_uri}/google.svg",
            'category'    => esc_html__( 'Ovic Shortcode', 'bianco' ),
            'description' => esc_html__( 'Display Google Map', 'bianco' ),
            'params'      => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Title', 'bianco' ),
                    'param_name'  => 'title',
                    'admin_label' => true,
                    'description' => esc_html__( 'title.', 'bianco' ),
                    'std'         => 'KuteThemes',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Phone', 'bianco' ),
                    'param_name'  => 'phone',
                    'description' => esc_html__( 'phone.', 'bianco' ),
                    'std'         => '088-465 9965 02',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Email', 'bianco' ),
                    'param_name'  => 'email',
                    'description' => esc_html__( 'email.', 'bianco' ),
                    'std'         => 'kutethemes@gmail.com',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Address', 'bianco' ),
                    'param_name'  => 'address',
                    'admin_label' => true,
                    'description' => esc_html__( 'address.', 'bianco' ),
                    'std'         => esc_html__( 'Z115 TP. Thai Nguyen', 'bianco' ),
                ),
                array(
                    'type'       => 'number',
                    'heading'    => esc_html__( 'Map Height', 'bianco' ),
                    'param_name' => 'map_height',
                    'std'        => '400',
                ),
                array(
                    'type'       => 'dropdown',
                    'heading'    => esc_html__( 'Maps type', 'bianco' ),
                    'param_name' => 'map_type',
                    'value'      => array(
                        esc_html__( 'ROADMAP', 'bianco' )   => 'ROADMAP',
                        esc_html__( 'SATELLITE', 'bianco' ) => 'SATELLITE',
                        esc_html__( 'HYBRID', 'bianco' )    => 'HYBRID',
                        esc_html__( 'TERRAIN', 'bianco' )   => 'TERRAIN',
                    ),
                    'std'        => 'ROADMAP',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Longitude', 'bianco' ),
                    'param_name'  => 'longitude',
                    'admin_label' => true,
                    'description' => esc_html__( 'longitude.', 'bianco' ),
                    'std'         => '105.800286',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Latitude', 'bianco' ),
                    'param_name'  => 'latitude',
                    'admin_label' => true,
                    'description' => esc_html__( 'latitude.', 'bianco' ),
                    'std'         => '21.587001',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Zoom', 'bianco' ),
                    'param_name'  => 'zoom',
                    'admin_label' => true,
                    'description' => esc_html__( 'zoom.', 'bianco' ),
                    'std'         => '14',
                ),
            ),
        );

        /* TODO: ovic_title */
        $param['ovic_title']        = array(
            'base'        => 'ovic_title',
            'name'        => esc_html__( 'Ovic: Title', 'bianco' ),
            'icon'        => "{$icom_uri}/quill-drawing-a-line.svg",
            'category'    => esc_html__( 'Ovic Shortcode', 'bianco' ),
            'description' => esc_html__( 'Title ahead of the block data', 'bianco' ),
            'params'      => array(
                array(
                    'type'        => 'select_preview',
                    'param_name'  => 'style',
                    'heading'     => esc_html__( 'Select Layout Style', 'bianco' ),
                    'value'       => array(
                        'default'      => array(
                            'title'   => esc_html__( 'Default', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic-title/default.jpg",
                        ),
                        'style-02'      => array(
                            'title'   => esc_html__( 'Style 02', 'bianco' ),
                            'preview' => "{$shortcode_preview}/ovic-title/style-02.jpg",
                        ),
                    ),
                    'default'     => 'default',
                    'admin_label' => true,
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Small Title', 'bianco' ),
                    'description' => esc_html__( 'The small title ahead of main title', 'bianco' ),
                    'param_name'  => 'sm_title',
                    'std'         => 'SmallTitle',
                    'admin_label' => true,
                    'dependency'  => array( 'element' => 'style', 'value' => 'style-02' ),
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Title', 'bianco' ),
                    'description' => esc_html__( 'The main title.', 'bianco' ),
                    'param_name'  => 'title',
                    'std'         => 'Title',
                    'admin_label' => true,
                ),
                array(
                    'type'       => 'colorpicker',
                    'value'      => $main_color,
                    'heading'    => esc_html__( 'Under Line Color', 'bianco' ),
                    'param_name' => 'under_color',
                ),
            ),
        );

		return $param;
	}
}
//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Accordion' );

class WPBakeryShortCode_Ovic_Timeline extends WPBakeryShortCodesContainer
{
}

class WPBakeryShortCode_Ovic_Tabs extends WPBakeryShortCode_VC_Tta_Accordion
{
}

class WPBakeryShortCode_Ovic_Accordion extends WPBakeryShortCode_VC_Tta_Accordion
{
}

class WPBakeryShortCode_Ovic_Slide extends WPBakeryShortCodesContainer
{
}

class WPBakeryShortCode_Ovic_Slide_2 extends WPBakeryShortCodesContainer
{
}