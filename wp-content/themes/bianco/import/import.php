<?php
if( !class_exists('Sample_Settings')){
	class Sample_Settings{

		public function __construct(){

			// Filter Sample Data Menu
			add_filter('import_sample_data_menu_args',array($this,'import_sample_data_menu_args'));
			add_filter('import_sample_data_packages',array($this,'import_sample_data_packages'));
			add_filter('import_sample_data_required_plugins',array($this,'import_sample_data_required_plugins'));
			add_filter('import_sample_data_theme_option_key',array($this,'import_sample_data_theme_option_key'));
			add_action('import_sample_data_after_install_sample_data',array($this,'import_sample_data_after_install_sample_data'), 20,1);
		}

		public function import_sample_data_theme_option_key( $theme_option_key){
			return '_ovic_customize_options';
		}

		public function import_sample_data_required_plugins( $plugins ){
			$plugins = array(
				array(
					'name'               => 'WPBakery Visual Composer',
					'slug'               => 'js_composer',
					'source'             => esc_url('https://plugins.kutethemes.net/js_composer.zip'),
					'source_type'        => 'external',
					'file_path'          => 'js_composer/js_composer.php',
				),
				array(
					'name'               => 'Bianco Toolkit',
					'slug'               => 'bianco-toolkit',
					'source'             => esc_url( 'https://plugins.kutethemes.net/bianco-toolkit.zip' ),
					'source_type'        => 'external',
					'file_path'          => 'bianco-toolkit/bianco-toolkit.php',
				),
				array(
					'name'               => 'Revolution Slider',
					'slug'               => 'revslider', 
					'source'             => esc_url('https://plugins.kutethemes.net/revslider.zip'),
					'source_type'        => 'external',
					'file_path'          => 'revslider/revslider.php',
				),
				array(
					'name'      		=> 'WooCommerce',
					'slug'     		 	=> 'woocommerce',
					'required'  		=> true,
					'file_path'         => 'woocommerce/woocommerce.php',
					'source_type'       => 'repo',
				),
				array(
					'name'      		=> 'YITH WooCommerce Compare',
					'slug'      		=> 'yith-woocommerce-compare',
					'required'  		=> false,
					'file_path'         => 'yith-woocommerce-compare/init.php',
					'source_type'       => 'repo',
				),
				array(
					'name' 				=> 'YITH WooCommerce Wishlist',
					'slug' 				=> 'yith-woocommerce-wishlist',
					'required' 			=> false,
					'source_type'       => 'repo',
					'file_path'         => 'yith-woocommerce-wishlist/init.php',
				),
				array(
					'name' 				=> 'YITH WooCommerce Quick View',
					'slug' 				=> 'yith-woocommerce-quick-view',
					'required' 			=> false,
					'source_type'       => 'repo',
					'file_path'         => 'yith-woocommerce-quick-view/init.php',
				),
				array(
					'name'      		=> 'Contact Form 7',
					'slug'      		=> 'contact-form-7',
					'required'  		=> false,
					'source_type'       => 'repo',
					'file_path'         => 'contact-form-7/wp-contact-form-7.php',
				),
			);
			return $plugins;
		}

		/**
		 * Change Menu Sample dataß.
		 *
		 * @param   array   $uri     Remote URI for fetching content.
		 *
		 * @return  array
		 */
		public function import_sample_data_menu_args( $args ){

			$args = array(
				'parent_slug'   => 'ovic-dashboard',
				'page_title'    => esc_html__('Import Demos','bianco'),
				'menu_title'    => esc_html__('Import Demos','bianco'),
				'capability'    => 'manage_options',
				'menu_slug'     => 'sample-data',
				'function'      => 'Import_Sample_Data_Dashboard::dashboard'
			);
			return $args;
		}

		public function import_sample_data_packages( $packages ){
			$menu_location = array(
                'market' => array(
                    'primary'       => 'Primary Menu',
                    'vertical_menu' => 'vertical market',
                ),
                'child' => array(
                    'primary'       => 'Main child',
                    'vertical_menu' => 'vertical market',
                ),
                'tool' => array(
                    'primary'       => 'Main Tool',
                    'vertical_menu' => 'vertical market',
                ),
                'appliances' => array(
                    'primary'       => 'Main Appliances',
                    'vertical_menu' => 'Vertical Appliances',
                ),
                'digital' => array(
                    'primary'       => 'Main Digital',
                    'vertical_menu' => 'Vertical Digital',
                ),
                'furniture' => array(
                    'primary'       => 'Primary Menu',
                    'vertical_menu' => 'vertical market',
                ),
            );

			return array(
                'bianco' => array(
                    'id'            => 'bianco',
                    'name'          => 'bianco',
                    'thumbail'      => get_theme_file_uri('import/previews/bianco-preview.jpg'),
                    'demo'          => '#',
                    'download'      => 'https://bianco.kutethemes.net/sample-data/bianco.zip',
                    'tags'          => array('all','simple'),
                    'main'          => true,
                    'sample-page'   => array(
                        array(
                            'name' 				=> 'Market',
                            'slug' 				=> 'home-market',
                            'thumbail' 			=>get_theme_file_uri('import/previews/market.jpg'),
                            'menu_locations' 	=> $menu_location['market'],
                            'settings' 			=> array(
                                'bianco_used_header' 	=> 'market',
                                'ovic_footer_template' 	=> 237,
                                'bianco_bg_color' 		=> '#fafafa',
                            ),
                        ),
                        array(
                            'name' 				=> 'Child',
                            'slug' 				=> 'home-child',
                            'thumbail' 			=>get_theme_file_uri('import/previews/child.jpg'),
                            'menu_locations' 	=> $menu_location['child'],
                            'settings' 			=> array(
                                'bianco_used_header'    => 'child',
                                'ovic_main_color'       => '#63ab04',
                                'ovic_logo'             => 928,
                                'ovic_footer_template'  => 1015,
                                'user_all_social'       => array(
									array(
										'title_social' => 'twitter',
										'link_social'  => '#',
										'icon_social'  => 'fa fa-twitter'
									),
									array(
										'title_social' => 'facebook',
										'link_social'  => '#',
										'icon_social'  => 'fa fa-facebook'
									),
									array(
										'title_social' => 'pinterest',
										'link_social'  => '#',
										'icon_social'  => 'fa fa-pinterest'
									)
								),
                            ),
                        ),
                        array(
                            'name' 				=> 'Tool',
                            'slug' 				=> 'home-tools',
                            'thumbail' 			=>get_theme_file_uri('import/previews/tool.jpg'),
                            'menu_locations' 	=> $menu_location['tool'],
                            'settings' 			=> array(
                                'bianco_used_header'    => 'tool',
                                'ovic_main_color'       => '#f96332',
                                'ovic_logo'             => 1134,
                                'ovic_footer_template'  => 1319,
                                'bianco_phone_number'   => '(+900) 123 567 911',
                                'bianco_working_time'   => 'Mon: 8:00am-8:00pm; Sat-Sun:(none)'
                            ),
                        ),
                        array(
                            'name' 				=> 'Appliances',
                            'slug' 				=> 'home-appliances',
                            'thumbail' 			=>get_theme_file_uri('import/previews/appliances.jpg'),
                            'menu_locations' 	=> $menu_location['appliances'],
                            'settings' 			=> array(
                                'bianco_used_header'        => 'appliances',
                                'ovic_main_color'           => '#9eac54',
                                'ovic_logo'                 => 1933,
                                'ovic_footer_template'      => 1980,
                                'ovic_block_vertical_menu'  => array('1929'),
                            ),
                        ),
                        array(
                            'name' 				=> 'Digital',
                            'slug' 				=> 'home-digital',
                            'thumbail' 			=>get_theme_file_uri('import/previews/digital.jpg'),
                            'menu_locations' 	=> $menu_location['digital'],
                            'settings' 			=> array(
                                'bianco_used_header'        => 'digital',
                                'ovic_main_color'           => '#03a9f4',
                                'ovic_logo'                 => 1707,
                                'ovic_footer_template'      => 623,
                                'ovic_block_vertical_menu'  => array('131'),
                            ),
                        ),
                        array(
                            'name' 				=> 'Furniture',
                            'slug' 				=> 'home-furniture',
                            'thumbail' 			=>get_theme_file_uri('import/previews/furniture.jpg'),
                            'menu_locations' 	=> $menu_location['furniture'],
                            'settings' 			=> array(
                                'bianco_used_header' 		=> 'furniture',
                                'ovic_main_color' 			=> '#83b735',
                                'ovic_logo' 				=> 2173,
                                'ovic_footer_template' 		=> 2170,
                                'ovic_block_vertical_menu' 	=> array('1929'),
                                'ovic_vertical_banner' 		=> '',
                            ),
                        ),
                    )
                ),
			);
		}

		public function import_sample_data_after_install_sample_data($package){
			/*Do something here!*/
            $sample_page = isset($_POST['sample_page']) ? $_POST['sample_page'] : '';
            if( $sample_page !=''){
            	/*config menu locations*/
                $demo_location = isset($package['sample-page'][$sample_page]['menu_locations']) ? $package['sample-page'][$sample_page]['menu_locations'] : array() ;
                if (is_array( $demo_location ) && !empty($demo_location)){
                    $menu_location = array();
                    $locations     = get_theme_mod( 'nav_menu_locations' );
                    $menus         = wp_get_nav_menus();
                    if ( $menus ) {
                        foreach ( $menus as $menu ) {
                            foreach ( $demo_location as $key => $value ) {
                                if ( $menu->name == $value ) {
                                    $menu_location[$key] = $menu->term_id;
                                }
                            }
                        }
                    }
                    set_theme_mod( 'nav_menu_locations', $menu_location );
                }

                /*config theme option*/
                $all_options = null;
                if ( defined( 'OVIC_CUSTOMIZE' ) ) {
                    $all_options 	= get_option( OVIC_CUSTOMIZE , true);
                    $demo_setting 	= isset($package['sample-page'][$sample_page]['settings']) ? $package['sample-page'][$sample_page]['settings'] : array() ;
                    if( is_array($demo_setting) && !empty($demo_setting)){
                        foreach ($demo_setting as $opt_key => $opt_value ){
                            if(isset($all_options[$opt_key])){
                                $all_options[$opt_key] = $opt_value;
                            }
                        }
                        update_option(OVIC_CUSTOMIZE, $all_options);
                    }
                }
            }

			$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
			$home_url = get_home_url();
			if (!empty($menus)) {
				foreach ($menus as $menu) {
					$items = wp_get_nav_menu_items($menu->term_id);
					if (!empty($items)) {
						foreach ($items as $item) {
							$metas = get_post_meta($item->ID);
							$_menu_item_type 	= get_post_meta($item->ID, '_menu_item_type', true);
							$_menu_item_url 	= get_post_meta($item->ID, '_menu_item_url', true);
							if ($_menu_item_type == 'custom') {
								$_menu_item_url = str_replace('https://bianco.kutethemes.net', $home_url, $_menu_item_url);
								$_menu_item_url = str_replace('http://bianco.kutethemes.net', $home_url, $_menu_item_url);
								update_post_meta($item->ID, '_menu_item_url', $_menu_item_url);
							}
						}
					}
				}
			}
		}
	}
}

new Sample_Settings();