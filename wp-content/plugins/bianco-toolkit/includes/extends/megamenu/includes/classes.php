<?php
/**
 * Ovic Megamenu Settings
 *
 * @author   KHANH
 * @category API
 * @package  Ovic_Megamenu_Settings
 * @since    1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( !class_exists( 'Ovic_Megamenu_Settings' ) ) {
	class Ovic_Megamenu_Settings
	{
		public $key           = '_ovic_menu_settings';
		public $defaults_atts = array(
			'enable_mega'     => 0,
			'hide_title'      => 0,
			'sub_position'    => 'fullwidth',
			'disable_link'    => 0,
			'bold_item'       => 0,
			'menu_width'      => '',
			'menu_icon'       => '',
			'menu_content_id' => 0,
			'menu_bg'         => 0,
			'menu_content'    => '',
		);

		public function __construct()
		{
			add_action( 'wp_ajax_ovic_menu_save_all_settings', array( $this, 'ovic_menu_save_all_settings' ) );
			add_action( 'wp_ajax_ovic_menu_create_mega_menu', array( $this, 'ovic_menu_create_mega_menu' ) );
			add_action( 'wp_ajax_ovic_get_form_settings', array( $this, 'ovic_ajax_form_settings' ) );
			add_action( 'wp_ajax_ovic_button_settings', array( $this, '_ovic_button_settings' ) );
			/* EDIT WALKER */
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker' ), PHP_INT_MAX, 2 );
			add_filter( 'wp_nav_menu_args', array( $this, '_change_nav_menu_args' ), PHP_INT_MAX, 1 );
			add_filter( 'nav_menu_css_class', array( $this, '_change_class_menu_items' ), PHP_INT_MAX, 4 );
			add_filter( 'nav_menu_item_title', array( $this, '_change_title_menu_items' ), PHP_INT_MAX, 4 );
			add_filter( 'walker_nav_menu_start_el', array( $this, '_change_output_menu_items' ), PHP_INT_MAX, 4 );
			/*
			ADD MOBILE MENU OPTION
			add_action( 'after_setup_theme', array( $this, '_theme_setup' ) );
			add_action( 'wp_head', array( $this, 'clone_mobile_menu' ) ); */
			/* ADD CONTENT */
			add_action( 'admin_footer', array( $this, '_add_content' ) );
			add_action( 'init', array( $this, '_register' ), 100, 0 );
		}

		public function edit_walker()
		{
			return 'Walker_Nav_Menu_Edit_Custom';
		}

		public function _theme_setup()
		{
			register_nav_menus( array(
					'ovic_mobile_menu' => esc_html__( 'Mobile Menu', 'ocolus' ),
				)
			);
		}

		public function _register()
		{
			$labels = array(
				'name'          => esc_html__( 'Ovic Mega Menu Items', 'bianco-toolkit' ),
				'singular_name' => esc_html__( 'Ovic Mega Menu Item', 'bianco-toolkit' ),
				'all_items'     => esc_html__( 'All Menu Items', 'bianco-toolkit' ),
			);
			$args   = array(
				'labels'       => $labels,
				'public'       => true,
				'show_ui'      => true,
				'show_in_menu' => false,
				'supports'     => array( 'title', 'editor' ),
			);
			register_post_type( 'ovic_menu', $args );
		}

		public function _add_content()
		{
			if ( $GLOBALS['pagenow'] == 'nav-menus.php' ) {
				include_once OVIC_MEGAMENU_DIR . 'templates/template.php';
			}
		}

		public function _ovic_button_settings()
		{
			$response       = array(
				'icon'     => '',
				'label'    => '',
				'megamenu' => '',
				'success'  => 'no',
			);
			$icon           = '';
			$label          = '';
			$item_id        = isset( $_POST['item_id'] ) ? $_POST['item_id'] : '';
			$settings       = get_post_meta( $item_id, $this->key, true );
			$menu_icon_type = isset( $settings['menu_icon_type'] ) ? $settings['menu_icon_type'] : 'font-icon';
			if ( $settings['menu_icon'] != '' || $settings['icon_image'] != '' ) {
				if ( $menu_icon_type == 'font-icon' ):
					if ( isset( $settings['menu_icon'] ) && $settings['menu_icon'] != "" ):
						$icon = '<span class="' . $settings['menu_icon'] . '"></span>';
					endif;
				endif;
				if ( $menu_icon_type == 'image' ):
					if ( isset( $settings['icon_image'] ) && $settings['icon_image'] != "" ):
						$icon = wp_get_attachment_image( $settings['icon_image'], 'thumbnail' );
					endif;
				endif;
			}
			if ( isset( $settings['label_image'] ) && $settings['label_image'] > 0 ):
				$label = wp_get_attachment_image( $settings['label_image'], 'thumbnail' );
			endif;
			if ( $settings['enable_mega'] == 1 ) {
				$response['megamenu'] = 'button-primary';
			}
			$response['success'] = 'yes';
			$response['icon']    = $icon;
			$response['label']   = $label;
			wp_send_json( $response );
			wp_die();
		}

		function clone_mobile_menu()
		{
			$locations = get_nav_menu_locations();
			if ( isset( $locations['ovic_mobile_menu'] ) ) {
				$menu           = wp_get_nav_menu_object( $locations['ovic_mobile_menu'] );
				$menu_locations = array( $menu->name );
				$count          = 0;
				$mobile_menu    = '';
				$array_menus    = array();
				$array_child    = array();
				$mobile_menu    .= "<div class='ovic-menu-clone-wrap open'>";
				$mobile_menu    .= "<div class='ovic-menu-panels-actions-wrap'>";
				$mobile_menu    .= "<span class='ovic-menu-current-panel-title'>" . __( 'Main Menu', 'bianco-toolkit' ) . "</span>";
				$mobile_menu    .= "<a href='#' class='ovic-menu-close-btn ovic-menu-close-panels'>x</a>";
				$mobile_menu    .= "</div>";
				$mobile_menu    .= "<div class='ovic-menu-panels'>";
				if ( !empty( $menu_locations ) ) {
					foreach ( $menu_locations as $location ) {
						if ( $menu_items = wp_get_nav_menu_items( $location ) ) {
							foreach ( $menu_items as $key => $menu_item ) {
								$parent_id = $menu_item->menu_item_parent;
								/* REND ARGS */
								$array_menus[$parent_id][$menu_item->ID] = array(
									'mega'  => false,
									'url'   => $menu_item->url,
									'title' => $menu_item->title,
								);
								if ( $parent_id > 0 ) {
									$array_child[] = $parent_id;
								} else {
									$settings    = get_post_meta( $menu_item->ID, $this->key, true );
									$enable_mega = false;
									if ( isset( $settings['enable_mega'] ) && $settings['enable_mega'] == 1 ) {
										$enable_mega = true;
									}
									if ( $enable_mega == true ) {
										$css             = '';
										$html            = '';
										$menu_width      = ( isset( $settings['menu_width'] ) && is_numeric( $settings['menu_width'] ) && $settings['menu_width'] > 0 ) ? $settings['menu_width'] : 1170;
										$menu_content_id = isset( $settings['menu_content_id'] ) ? $settings['menu_content_id'] : 0;
										$menu_content    = isset( $settings['menu_content'] ) ? $settings['menu_content'] : '';
										if ( $menu_content_id > 0 && $enable_mega == true ) {
											$content = apply_filters( 'the_content', $menu_content );
											$content = str_replace( ']]>', ']]>', $content );
											if ( $menu_width > 0 ) {
												$css .= 'width:' . $menu_width . 'px;';
											}
											$image = '';
											if ( isset( $settings['menu_bg'] ) && $settings['menu_bg'] > 0 ) {
												$image = wp_get_attachment_image_url( $settings['menu_bg'], 'full' );
												if ( $image )
													$css .= "background-size: cover;";
												if ( isset( $settings['bg_position'] ) )
													$css .= "background-position: {$settings['bg_position']};";
											}
											$responsive = isset( $settings['mega_responsive'] ) ? $settings['mega_responsive'] : '';
											$html       .= '<div data-src="' . esc_url( $image ) . '" style="' . $css . '" class="lazy sub-menu megamenu" data-responsive="' . esc_attr( $responsive ) . '">' . $content . '</div>';
										}
										$array_menus[$menu_item->ID][$menu_item->ID] = array(
											'mega'  => true,
											'url'   => $menu_item->url,
											'title' => $html,
										);
										/* ADD CHILD */
										$array_child[] = $menu_item->ID;
									}
								}
							}
						}
					}
					foreach ( $array_menus as $parent_id => $menus ) {
						if ( $count == 0 ) {
							$mobile_menu .= "<div id='ovic-menu-panel-main' class='ovic-menu-panel ovic-menu-panel-main'>";
						} else {
							$mobile_menu .= "<div id='ovic-menu-panel-{$parent_id}' class='ovic-menu-panel ovic-menu-sub-panel ovic-menu-hidden'>";
						}
						$mobile_menu .= "<ul class='depth-{$count}'>";
						foreach ( $menus as $id => $menu ) {
							if ( $menu['mega'] == true ) {
								$mobile_menu .= "<li id='ovic-menu-clone-megamenu-item-{$id}' class='menu-item'>";
								$mobile_menu .= "{$menu['title']}";
							} else {
								$mobile_menu .= "<li id='ovic-menu-clone-menu-item-{$id}' class='menu-item'>";
								if ( in_array( $id, $array_child ) ) {
									$mobile_menu .= "<a class='ovic-menu-next-panel' href='#ovic-menu-panel-{$id}' data-target='#ovic-menu-panel-{$id}'></a>";
								}
								$mobile_menu .= "<a href='{$menu['url']}'>{$menu['title']}</a>";
							}
							$mobile_menu .= "</li>";
						}
						$mobile_menu .= "</ul></div>";
						$count++;
					}
				}
				$mobile_menu .= "</div></div>";
				echo wp_kses_post( $mobile_menu );
			}
		}

		function _return_title_menu_item( $settings, $title )
		{
			if ( isset( $settings['hide_title'] ) && $settings['hide_title'] == 1 ) {
				$title = '';
			}
			$menu_icon_type = isset( $settings['menu_icon_type'] ) ? $settings['menu_icon_type'] : 'font-icon';
			if ( $menu_icon_type == 'font-icon' ) {
				if ( isset( $settings['menu_icon'] ) && $settings['menu_icon'] != '' ) {
					$title = '<span class="icon icon-font ' . esc_attr( $settings['menu_icon'] ) . '"></span>' . $title;
				}
			}
			if ( $menu_icon_type == 'image' ) {
				if ( isset( $settings['icon_image'] ) && $settings['icon_image'] != '' && $settings['icon_image'] > 0 ) {
					$image = wp_get_attachment_image( $settings['icon_image'], 'full', false, [ 'class' => 'icon icon-image' ] );
					if ( $image ) {
						$title = $image . $title;
					}
				}
			}
			$label_image = isset( $settings['label_image'] ) ? $settings['label_image'] : 0;
			if ( $label_image > 0 ) {
				$image = wp_get_attachment_image( $label_image, 'full', false, [ 'class' => 'label-image' ] );
				if ( $image ) {
					$title = $title . $image;
				}
			}

			return $title;
		}

		function _return_megamenu_menu_item( $settings, $depth = 0 )
		{
			$_output     = '';
			$enable_mega = false;
			if ( isset( $settings['enable_mega'] ) && $settings['enable_mega'] == 1 && $depth == 0 ) {
				$enable_mega = true;
			}
			$mega_classes = 'lazy sub-menu megamenu mega-type-';
            $mega_classes .= !empty($settings['mega_type']) ? $settings['mega_type'] : 'default';
			if ( $enable_mega == true ) {
				$css             = '';
				$menu_width      = ( isset( $settings['menu_width'] ) && is_numeric( $settings['menu_width'] ) && $settings['menu_width'] > 0 ) ? $settings['menu_width'] : 1170;
				$menu_content_id = isset( $settings['menu_content_id'] ) ? $settings['menu_content_id'] : 0;
				$menu_content    = isset( $settings['menu_content'] ) ? $settings['menu_content'] : '';
				if ( $menu_content_id > 0 && $enable_mega == true ) {
					if ( base64_encode( base64_decode( $menu_content, true ) ) === $menu_content ) {
						$menu_content = base64_decode( $menu_content );
					}
					$content = apply_filters( 'the_content', $menu_content );
					$content = str_replace( ']]>', ']]>', $content );
					if ( $menu_width > 0 ) {
						$css .= 'width:' . $menu_width . 'px;';
					}
					$image = '';
					if ( isset( $settings['menu_bg'] ) && $settings['menu_bg'] > 0 ) {
						$image = wp_get_attachment_image_url( $settings['menu_bg'], 'full' );
						if ( $image )
							$css .= "background-size: cover;";
						if ( isset( $settings['bg_position'] ) )
							$css .= "background-position: {$settings['bg_position']};";
					}
					$responsive = isset( $settings['mega_responsive'] ) ? $settings['mega_responsive'] : '';
					$_output    .= '<div data-src="' . esc_url( $image ) . '" style="' . $css . '" class="'.$mega_classes.'" data-responsive="' . esc_attr( $responsive ) . '">' . $content . '</div>';
				}
			}

			return $_output;
		}

		public function _change_output_menu_items( $item_output, $item, $depth, $args )
		{
			$settings = get_post_meta( $item->ID, $this->key, true );
			if ( $item->description ) {
				$item_output .= '<span class="desc">' . $item->description . '</span>';
			}
			$item_output .= $this->_return_megamenu_menu_item( $settings, $depth );

			return $item_output;
		}

		public function _change_title_menu_items( $title, $item, $args, $depth )
		{
			$settings = get_post_meta( $item->ID, $this->key, true );
			$title    = $this->_return_title_menu_item( $settings, $title );

			return $title;
		}

		public function _change_class_menu_items( $classes, $item, $args, $depth )
		{
			$settings    = get_post_meta( $item->ID, $this->key, true );
			$enable_mega = false;
			$bold_item = false;
			if ( isset( $settings['enable_mega'] ) && $settings['enable_mega'] == 1 && $depth == 0 ) {
				$enable_mega = true;
			}
            if ( isset( $settings['bold_item'] ) && $settings['bold_item'] == 1 && $depth == 0 ) {
                $bold_item = true;
            }
			if ( !empty( $settings['sub_position'] ) && $depth == 0 ) {
                $classes[] = 'mega-position-type-'.$settings['sub_position'];
			}
			if ($enable_mega) {
				$classes[] = 'menu-item-has-mega-menu';
				$classes[] = 'menu-item-has-children';
				$classes[] = 'item-megamenu';
			}
			if($bold_item){
                $classes[] = 'bold-item';
            }
			return $classes;
		}

		public function _change_nav_menu_args( $args )
		{
			if ( is_admin() ) {
				return $args;
			}
			$locations = get_nav_menu_locations();
			if ( !empty( $locations[$args['theme_location']] ) ) {
				$menu = wp_get_nav_menu_object( $locations[$args['theme_location']] );
			} elseif ( !empty( $args['menu'] ) ) {
				$menu = wp_get_nav_menu_object( $args['menu'] );
			} else {
				$menus = (array)wp_get_nav_menus();
				if ( $menus ) {
					foreach ( $menus as $menu ) {
						$has_items = wp_get_nav_menu_items( $menu->term_id, array(
								'update_post_term_cache' => false,
							)
						);
						if ( $has_items ) {
							break;
						}
					}
				}
			}
			if ( !isset( $menu ) || is_wp_error( $menu ) || !is_object( $menu ) ) {
				return $args;
			}
			$megamenu_layout         = get_term_meta( $menu->term_id, '_megamenu_layout', true );
			$megamenu_layout         = $megamenu_layout != "" ? $megamenu_layout : 'horizontal'; //vertical
			$megamenu_layout         = isset( $args['megamenu_layout'] ) ? $args['megamenu_layout'] : $megamenu_layout;
			$container_class         = $args['container_class'] . ' ovic-menu-wapper ' . $megamenu_layout;
			$args['container']       = 'div';
			$args['container_class'] = $container_class;
			$args['menu_class']      = $args['menu_class'] . ' ovic-menu';
			if ( isset( $args['mobile_enable'] ) && $args['mobile_enable'] == 1 ) {
				$args['menu_class']      = $args['menu_class'] . ' ovic-clone-mobile-menu';
				$args['container_class'] = $args['container_class'] . ' support-mobile-menu';
			}

			return $args;
		}

		/**
		 * Get the current menu ID.
		 *
		 * Most of this taken from wp-admin/nav-menus.php (no built in functions to do this)
		 *
		 * @since 1.0
		 * @return int
		 */
		public function get_selected_menu_id()
		{
			$nav_menus            = wp_get_nav_menus( array( 'orderby' => 'name' ) );
			$menu_count           = count( $nav_menus );
			$nav_menu_selected_id = isset( $_REQUEST['menu'] ) ? (int)$_REQUEST['menu'] : 0;
			$add_new_screen       = ( isset( $_GET['menu'] ) && 0 == $_GET['menu'] ) ? true : false;
			// If we have one theme location, and zero menus, we take them right into editing their first menu
			$page_count                  = wp_count_posts( 'page' );
			$one_theme_location_no_menus = ( 1 == count( get_registered_nav_menus() ) && !$add_new_screen && empty( $nav_menus ) && !empty( $page_count->publish ) ) ? true : false;
			// Get recently edited nav menu
			$recently_edited = absint( get_user_option( 'nav_menu_recently_edited' ) );
			if ( empty( $recently_edited ) && is_nav_menu( $nav_menu_selected_id ) )
				$recently_edited = $nav_menu_selected_id;
			// Use $recently_edited if none are selected
			if ( empty( $nav_menu_selected_id ) && !isset( $_GET['menu'] ) && is_nav_menu( $recently_edited ) )
				$nav_menu_selected_id = $recently_edited;
			// On deletion of menu, if another menu exists, show it
			if ( !$add_new_screen && 0 < $menu_count && isset( $_GET['action'] ) && 'delete' == $_GET['action'] )
				$nav_menu_selected_id = $nav_menus[0]->term_id;
			// Set $nav_menu_selected_id to 0 if no menus
			if ( $one_theme_location_no_menus ) {
				$nav_menu_selected_id = 0;
			} elseif ( empty( $nav_menu_selected_id ) && !empty( $nav_menus ) && !$add_new_screen ) {
				// if we have no selection yet, and we have menus, set to the first one in the list
				$nav_menu_selected_id = $nav_menus[0]->term_id;
			}

			return $nav_menu_selected_id;
		}

		public function ovic_ajax_form_settings()
		{
			$response        = array(
				'html'    => '',
				'message' => '',
				'success' => 'no',
			);
			$item_id         = isset( $_POST['item_id'] ) ? $_POST['item_id'] : '';
			$title           = isset( $_POST['item_title'] ) ? $_POST['item_title'] : '';
			$item_depth      = isset( $_POST['depth'] ) ? $_POST['depth'] : '';
			$settings        = get_post_meta( $item_id, $this->key, true );
			$settings        = wp_parse_args( ( array )$settings, $this->defaults_atts );
			if(empty($settings['mega_type'])) {
				$settings['mega_type'] = 'default';
			}
			$menu_icon_type  = isset( $settings['menu_icon_type'] ) ? $settings['menu_icon_type'] : 'font-icon';
			$menu_content_id = isset( $settings['menu_content_id'] ) ? $settings['menu_content_id'] : 0;
			if ( $menu_content_id > 0 ) {
				$item_iframe = admin_url( 'post.php?post=' . $menu_content_id . '&action=edit&ovic_menu_item_id=' . $item_id . '&depth=' . $item_depth . '' );
			} else {
				$item_iframe = '';
			}
			$placeholder         = OVIC_MEGAMENU_URL . 'assets/images/placeholder.png';
			$bg_thumbnail        = $settings['menu_bg'] ? wp_get_attachment_image_url( $settings['menu_bg'], 'thumbnail' ) : $placeholder;
			$icon_image_thumb    = $settings['icon_image'] ? wp_get_attachment_image_url( $settings['icon_image'], 'thumbnail' ) : $placeholder;
			$label_image_thumb   = $settings['label_image'] ? wp_get_attachment_image_url( $settings['label_image'], 'thumbnail' ) : $placeholder;
			$data_template       = array(
				'item_id'        => $item_id,
				'title'          => $title,
				'item_depth'     => $item_depth,
				'menu_icon_type' => $menu_icon_type,
				'iframe'         => $item_iframe,
				'settings'       => array(
					'menu_icon'         => $settings['menu_icon'],
					'mega_responsive'   => $settings['mega_responsive'],
					'enable_mega'       => $settings['enable_mega'],
					'hide_title'        => $settings['hide_title'],
					'menu_width'        => $settings['menu_width'],
					'disable_link'      => $settings['disable_link'],
					'mega_type'         => $settings['mega_type'],
					'menu_bg'           => $settings['menu_bg'],
					'bg_position'       => $settings['bg_position'],
					'icon_image'        => $settings['icon_image'],
                    'bold_item'         => $settings['bold_item'],
                    'label_image'       => $settings['label_image'],
                    'icon_image_thumb'  => $icon_image_thumb,
                    'label_image_thumb' => $label_image_thumb,
					'bg_thumbnail'      => $bg_thumbnail,
					'menu_content_id'   => $menu_content_id,
				),
			);
			$response['html']    = $data_template;
			$response['success'] = 'yes';
			wp_send_json( $response );
			wp_die();
		}

		public function ovic_menu_save_all_settings()
		{
			$response                 = array(
				'url'       => '',
				'status'    => false,
				'errors'    => array(),
				'is_update' => true,
				'settings'  => array(),
			);
			$item_id                  = !empty( $_POST['item_id'] ) ? intval( $_POST['item_id'] ) : 0;
			$settings                 = !isset( $_POST['menu_settings'] ) ? array() : $_POST['menu_settings'];
			$settings['enable_mega']  = !isset( $settings['enable_mega'] ) ? 0 : 1;
			$settings['hide_title']   = !isset( $settings['hide_title'] ) ? 0 : 1;
			$settings['disable_link'] = !isset( $settings['disable_link'] ) ? 0 : 1;
			$settings['bold_item']    = !isset( $settings['bold_item'] ) ? 0 : 1;
			if ( $settings['enable_mega'] == 1 && $settings['megamenu_content'] != 0 ) {
				$_post                    = get_post( $settings['megamenu_content'] );
				$settings['menu_content'] = $_post->post_content;
			}
			$settings_saved = get_post_meta( $item_id, $this->key, true );
			if ( is_array( $settings_saved ) && !empty( $settings_saved ) ) {
				$settings = wp_parse_args( ( array )$settings, $settings_saved );
			} else {
				$settings = wp_parse_args( ( array )$settings, $this->defaults_atts );
			}
			if ( !$item_id ) {
				$response['errors'][] = esc_html__( 'Menu item not exists.', 'bianco-toolkit' );
				exit( json_encode( $response ) );
			}
			update_post_meta( $item_id, $this->key, $settings );
			$response['settings'] = $settings;
			$response['status']   = true;
			wp_send_json( $response );
			wp_die();
		}

		public function ovic_menu_create_mega_menu()
		{
			$response = array(
				'url'     => '',
				'post_id' => 0,
				'status'  => false,
				'errors'  => array(),
			);
			$item_id  = !empty( $_POST['item_id'] ) ? intval( $_POST['item_id'] ) : 0;
			$settings = get_post_meta( $item_id, $this->key, true );
			$settings = wp_parse_args( ( array )$settings, $this->defaults_atts );
			if ( !$item_id ) {
				$response['errors'][] = esc_html__( 'Menu item not exists.', 'bianco-toolkit' );
				exit( json_encode( $response ) );
			}
			$menu_content_id = isset( $settings['menu_content_id'] ) ? $settings['menu_content_id'] : 0;
			if ( $menu_content_id == 0 ) {
				// Create post object
				$ovic_menu_post = array(
					'post_title'   => 'Mega menu - ' . $item_id,
					'post_content' => '',
					'post_status'  => 'publish',
					'post_type'    => 'ovic_menu',
				);
				// Insert the post into the database
				$menu_content_id             = wp_insert_post( $ovic_menu_post );
				$settings['menu_content_id'] = $menu_content_id;
				update_post_meta( $item_id, $this->key, $settings );
			}
			$response['url']     = admin_url( 'post.php?post=' . $menu_content_id . '&action=edit&ovic_menu_item_id=' . $item_id );
			$response['post_id'] = $menu_content_id;
			$response['status']  = true;
			wp_send_json( $response );
			wp_die();
		}
	}

	new Ovic_Megamenu_Settings();
}