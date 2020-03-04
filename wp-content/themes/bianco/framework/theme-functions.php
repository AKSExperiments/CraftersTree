<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/*==========================================================================
HOOK TEMPLATE FUNCTIONS
===========================================================================*/
// GET HEADER
add_action( 'bianco_header_content', 'bianco_header_content' );
add_action( 'bianco_header_sticky', 'bianco_header_sticky' );
add_action( 'bianco_header_mobile', 'bianco_header_mobile' );
add_action( 'bianco_header_language', 'bianco_header_language' );
add_action( 'bianco_header_vertical', 'bianco_header_vertical', 10, 2 );
add_action( 'bianco_show_hero_section', 'bianco_show_hero_section' );
add_action( 'bianco_top_left_menu', 'bianco_top_left_menu' );
add_action( 'bianco_top_right_menu', 'bianco_top_right_menu' );
add_action( 'bianco_display_account_block', 'bianco_display_account_block' );
// GET FOOTER
add_action( 'bianco_footer', 'bianco_footer_mobile', 45 );

if ( !function_exists( 'bianco_footer_mobile' ) ) {
	function bianco_footer_mobile(){
		$myaccount_link = wp_login_url();
		if ( class_exists( 'WooCommerce' ) ) {
			$myaccount_link = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			$orders_link    = $myaccount_link . get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
		}
		$languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0' );
		?>
        <div class="mobile-wpml-switcher">
            <div class="box-head close-option">
                <span class="text"><?php echo esc_html__( 'Global', 'bianco' ); ?></span>
                <a href="#" class="close-block-sidebar"><span class="ti-close"></span></a>
            </div>
			<?php if ( class_exists('SitePress') && $languages ): ?>
                <div class="wcml-language-switcher-container">
                    <h4><?php echo esc_html__( 'Language', 'bianco' ); ?></h4>
                    <ul>
						<?php foreach ( $languages as $l ): ?>
                            <li>
                                <a href="<?php echo esc_url( $l['url'] ); ?>">><?php echo esc_html( $l['native_name'] ); ?></a>
                            </li>
						<?php endforeach; ?>
                    </ul>
                </div>
                <div class="wcml-currency-switcher-container">
                    <h4><?php echo esc_html__( 'Currency', 'bianco' ); ?></h4>
					<?php echo do_shortcode( '[currency_switcher format="%code%" switcher_style="wcml-vertical-list"]' ); ?>
                </div>
			<?php endif; ?>
            <div class="my-account-container">
                <h4><?php echo esc_html__( 'My Account', 'bianco' ); ?></h4>
                <ul>
                    <li>
                        <a href="<?php echo esc_url( $myaccount_link ); ?>"><?php echo esc_html__( 'My Account', 'bianco' ); ?></a>
                    </li>
                    <li>
						<?php if ( is_user_logged_in() ): ?>
                            <a class="logout-url"
                               href="<?php echo wp_logout_url( get_permalink() ); ?>"><?php esc_html_e( 'Logout', 'bianco' ); ?></a>
						<?php else: ?>
                            <a class="login-url"
                               href="<?php echo wp_login_url(); ?>"><?php echo esc_html__( 'Login', 'bianco' ); ?></a>
						<?php endif; ?>
                    </li>
					<?php if ( class_exists( 'WooCommerce' ) ): ?>
                        <li>
                            <a href="<?php echo esc_url( $orders_link ); ?>"><?php echo esc_html__( 'Track Your Order', 'bianco' ); ?></a>
                        </li>
                        <li><?php do_action( 'bianco_compare_url' ); ?></li>
                        <li><?php do_action( 'bianco_wishlist_url' ); ?></li>
					<?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="mobile-footer">
            <div class="mobile-footer-inner">
                <div class="mobile-block block-menu-main">
                    <a href="#" class="menu-bar menu-toggle">
                        <span class="fa fa-bars"></span>
                        <span class="text"><?php echo esc_html__( 'Menu', 'bianco' ); ?></span>
                    </a>
                </div>
                <div class="mobile-block block-menu-filter">
                    <a href="#" class="menu-bar filter-toggle">
                        <span class="fa fa-long-arrow-right"></span>
                        <span class="text"><?php echo esc_html__( 'Sidebar', 'bianco' ); ?></span>
                    </a>
                </div>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <div class="mobile-block block-minicart">
                        <a class="link-dropdown" href="<?php echo wc_get_cart_url(); ?>">
                            <span class="fa fa-shopping-bag" aria-hidden="true"></span>
                            <span class="text"><?php echo esc_html__( 'Cart', 'bianco' ); ?></span>
                        </a>
                    </div>
				<?php endif; ?>
                <div class="mobile-block mobile-block-global">
                    <a class="menu-bar myaccount-toggle" href="javascript:void(0)">
                        <span class="fa fa-globe"></span>
                        <span class="text"><?php echo esc_html__( 'Global', 'bianco' ); ?></span>
                    </a>
                </div>
            </div>
        </div>
		<?php
	}
}
/*==========================================================================
TEMPLATE FUNCTIONS
===========================================================================*/
if ( !function_exists( 'bianco_display_account_block' ) ) {
	function bianco_display_account_block(){
		$myaccount_link = wp_login_url();
		$currentUser    = wp_get_current_user();
		if ( class_exists( 'WooCommerce' ) ) {
			$myaccount_link = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		}
		$myaccount_page_id                         = get_option( 'woocommerce_myaccount_page_id' );
		$myaccount_link                            = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		$woocommerce_enable_myaccount_registration = get_option( 'woocommerce_enable_myaccount_registration' );
		$login_text                                = esc_html__( 'Sign in', 'bianco' );
		if ( $woocommerce_enable_myaccount_registration == "yes" ) {
			$login_text = esc_html__( 'Register/', 'bianco' ) . $login_text;
		}
		$logout_url = "#";
		if ( $myaccount_page_id ) {
			if ( function_exists( 'wc_get_page_id' ) ) {
				$logout_url = wp_logout_url( get_permalink( wc_get_page_id( 'shop' ) ) );
			}
			if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ) {
				$logout_url = str_replace( 'http:', 'https:', $logout_url );
			}
		}
		?>
        <div class="bianco-account-block">
			<?php if ( is_user_logged_in() ): ?>
				<i class="block-icon bianco-icon icon-user"></i>
                <span class="text-label"><?php echo sprintf( esc_html__( 'Hi, %s', 'bianco' ), esc_html( $currentUser->display_name ) ); ?></span>
                <div class="inner">
                    <ul>
                        <li>
                        	<a class="my-account-url" href="<?php echo esc_url( $myaccount_link ); ?>"><?php echo esc_html__( 'My account', 'bianco' ); ?></a>
                        </li>
                        <li><a class="logout-url" href="<?php echo esc_url( $logout_url ); ?>"><?php esc_html_e( 'Logout', 'bianco' ); ?></a>
                        </li>
                    </ul>
                </div>
			<?php else: ?>
                <a class="myaccount-link" href="<?php echo esc_url( $myaccount_link ); ?>">
                    <i class="block-icon bianco-icon icon-user"></i>
                    <span class="text-label"><?php echo esc_html( $login_text ); ?></span></a>
			<?php endif; ?>
        </div>
		<?php
	}
}

/*GET HEADER*/
if ( !function_exists( 'bianco_header_content' ) ) {
	function bianco_header_content(){
		$header_options      = Bianco_Functions::get_option( 'bianco_used_header', 'market' );
		get_template_part( 'templates/header/header', $header_options );
	}
}

if ( !function_exists( 'bianco_header_sticky' ) ) {
	function bianco_header_sticky(){
		$enable_sticky_menu = Bianco_Functions::get_option( 'ovic_sticky_menu', '');
        $header_options     = Bianco_Functions::get_option( 'bianco_used_header', 'market' );
        if( $header_options == 'child'){
            $classes = 'header-sticky m-sticky-type-2';
        }else{
            $classes = "header-sticky sticky-{$header_options}";
        }
        if ( $enable_sticky_menu ): ?>
            <div class="<?php echo esc_attr($classes); ?>">
                <div class="container">
                    <div class="header-nav-inner header-responsive">
                        <div class="box-header-nav main-menu-wapper">
							<?php
							if ( has_nav_menu( 'primary' ) ) {
								wp_nav_menu( array(
										'menu'            => 'primary',
										'theme_location'  => 'primary',
										'depth'           => 3,
										'container'       => '',
										'container_class' => '',
										'container_id'    => '',
										'menu_class'      => 'clone-main-menu bianco-nav main-menu',
										'megamenu'        => true,
									)
								);
							}
							?>
                        </div>
                        <div class="header-control">
							<?php
							do_action( 'bianco_display_compare_block' );
							do_action( 'bianco_display_wishlist_block' );
							do_action( 'bianco_header_mini_cart' );
							?>
                        </div>
                    </div>
                </div>
            </div>
		<?php endif;
	}
}

/*WPML*/
if ( !function_exists( 'bianco_header_language' ) ) {
	function bianco_header_language(){
		$current_language = '';
		$list_language    = '';
		$menu_language    = '';
		$languages        = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0' );
		if ( !empty( $languages ) ) {
			foreach ( $languages as $l ) {
				if ( !$l['active'] ) {
					$list_language .= '
						<li class="menu-item">
                            <a href="' . esc_url( $l['url'] ) . '"><img src="' . esc_url( $l['country_flag_url'] ) . '" height="12" alt="' . esc_attr( $l['language_code'] ) . '" width="18"/>' . esc_html( $l['native_name'] ) . '</a>
                        </li>';
				} else {
					$current_language = '
						<a href="' . esc_url( $l['url'] ) . '" data-ovic="ovic-dropdown"> <img src="' . esc_url( $l['country_flag_url'] ) . '" height="12" alt="' . esc_attr( $l['language_code'] ) . '" width="18"/>' . esc_html( $l['native_name'] ) . '</a>
                        <span class="toggle-submenu"></span>';
				}
			}
			$menu_language .= '
                 <li class="menu-item ovic-dropdown block-language">
                    ' . $current_language . '
                    <ul class="sub-menu">
                        ' . $list_language . '
                    </ul>
                </li>';
			$menu_language .= '<li class="menu-item block-currency">' . do_shortcode( '[currency_switcher format="%code%" switcher_style="wcml-dropdown"]' ) . '</li>';
		}
		echo wp_specialchars_decode( $menu_language );
	}
}

if ( !function_exists( 'bianco_top_right_menu' ) ) {
	function bianco_top_right_menu(){
		$top_right_menu = Bianco_Functions::get_option( 'bianco_top_right_menu', array() );
		$html_top_right = '<ul class="topbar-menu">';
		if ( !empty( $top_right_menu ) ) {
			foreach ( $top_right_menu as $menu ) {
				$icon      = ( $menu['icon'] ) ? $menu['icon'] : '';
				$label     = ( $menu['label'] ) ? $menu['label'] : 'text';
				$link      = ( $menu['link'] ) ? $menu['link'] : '';
				$menu_item = '';
				if ( $icon )
					$menu_item .= '<i class="' . esc_attr( $icon ) . '"></i>';
				if ( $link ) {
					$menu_item .= esc_html( $label );
					$menu_item = '<a href="' . esc_url( $link ) . '">' . $menu_item . '</a>';
				} else {
					$menu_item .= '<span>' . esc_html( $label ) . '</span>';
				}
				$html_top_right .= '<li class="menu-item">' . $menu_item . '</li>';
			}
		}
		$html_top_right .= '<li class="menu-item">';
		ob_start();
			do_action( 'bianco_display_account_block' );
		$html_top_right .= ob_get_clean();
		$html_top_right .= '</li>';
		$html_top_right .= '</ul>';
		echo wp_specialchars_decode( $html_top_right );
	}
}

if ( !function_exists( 'bianco_get_logo' ) ) {
	function bianco_get_logo(){
		$logo_url = get_template_directory_uri() . '/assets/images/logo_red.png';
		$logo_id  = Bianco_Functions::get_option( 'ovic_logo' );
		if ( $logo_id > 0 ) {
			$logo_url = wp_get_attachment_url( $logo_id );
		}
		$html = '<a href="' . esc_url( get_home_url( '/' ) ) . '"><img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $logo_url ) . '" class="_rw" /></a>';
		echo apply_filters( 'bianco_site_logo', $html );
	}
}

if ( !function_exists( 'bianco_top_left_menu' ) ) {
	function bianco_top_left_menu(){
		$bianco_top_left_menu = Bianco_Functions::get_option( 'bianco_top_left_menu', array() );
		if ( empty( $bianco_top_left_menu ) ) return;
		$html_top_left = '<ul class="topbar-menu">';
		foreach ( $bianco_top_left_menu as $menu ) {
			$icon      = ( $menu['icon'] ) ? $menu['icon'] : '';
			$label     = ( $menu['label'] ) ? $menu['label'] : 'text';
			$link      = ( $menu['link'] ) ? $menu['link'] : '';
			$menu_item = '';
			if ( $icon )
				$menu_item .= '<i class="' . esc_attr( $icon ) . '"></i>';
			if ( $link ) {
				$menu_item .= esc_html( $label );
				$menu_item = '<a href="' . esc_url( $link ) . '">' . $menu_item . '</a>';
			} else {
				$menu_item .= '<span>' . esc_html( $label ) . '</span>';
			}
			$html_top_left .= '<li class="menu-item">' . $menu_item . '</li>';
		}
		$html_top_left .= '</ul>';
		echo wp_specialchars_decode( $html_top_left );
	}
}

if ( !function_exists( 'bianco_search_form' ) ) {
	function bianco_search_form($options=''){
		$selected            = '';
		if ( !empty( $_GET['product_cat'] )) {
			$selected = $_GET['product_cat'];
		}
		$args = array(
			'show_option_none'  => esc_html__( 'All Categories', 'bianco' ),
			'taxonomy'          => 'product_cat',
			'class'             => 'category-search-option',
			'hide_empty'        => 1,
			'orderby'           => 'name',
			'order'             => 'ASC',
			'tab_index'         => true,
			'hierarchical'      => false,
			'id'                => rand(),
			'name'              => 'product_cat',
			'value_field'       => 'slug',
			'selected'          => $selected,
			'option_none_value' => '0',
		);
		?>
        <div class="block-search">
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>"
                  class="form-search block-search ovic-live-search-form">
                <a href="#" class="close-block-search"><span class="ti-close"></span></a>
                <?php if ( class_exists( 'WooCommerce' ) ): ?>
                    <?php if ( $options == 'simple' ) : ?>
                        <div class="form-content search-box results-search is-woocommerce have-no-categories">
                            <div class="inner">
                                <input autocomplete="off" type="text" class="searchfield txt-livesearch input" name="s"
                                       value="<?php echo esc_attr( get_search_query() ); ?>"
                                       placeholder="<?php echo esc_attr__( 'Search here...', 'bianco' ); ?>">
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="form-content search-box results-search is-woocommerce included-categories">
                            <div class="inner">
                                <input autocomplete="off" type="text" class="searchfield txt-livesearch input" name="s"
                                       value="<?php echo esc_attr( get_search_query() ); ?>"
                                       placeholder="<?php echo esc_attr__( 'Search here...', 'bianco' ); ?>">
                            </div>
                            <div class="category">
                                <input type="hidden" name="post_type" value="product"/>
                                <input type="hidden" name="taxonomy" value="product_cat">
                                <?php wp_dropdown_categories( $args ); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="form-content search-box results-search">
                        <div class="inner">
                            <input autocomplete="off" type="text" class="searchfield txt-livesearch input" name="s"
                                   value="<?php echo esc_attr( get_search_query() ); ?>"
                                   placeholder="<?php echo esc_attr__( 'Search here...', 'bianco' ); ?>">
                        </div>
                        <input type="hidden" name="post_type" value="post"/>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn-submit">
                    <span class="text"><?php echo esc_html__( 'Search', 'bianco' ); ?></span>
                    <span class="bianco-icon icon-magnifier" aria-hidden="true"></span>
                </button>
            </form><!-- block search -->
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_header_vertical' ) ) {
	function bianco_header_vertical( $mobile_active = false ){
		global $post;
		$enable_vertical               	= Bianco_Functions::get_option('ovic_enable_vertical_menu', 0 );
		if ( $enable_vertical ) :
			$vertical_title            	= Bianco_Functions::get_option('ovic_vertical_menu_title', esc_html__( 'All department', 'bianco' ) );
			$block_vertical            	= Bianco_Functions::get_option('ovic_block_vertical_menu' );
			$ovic_vertical_banner 	   	= Bianco_Functions::get_option('ovic_vertical_banner', 0 );
			$ovic_vertical_banner_link 	= Bianco_Functions::get_option('ovic_vertical_banner_link', '#' );
			$bianco_used_header 		= Bianco_Functions::get_option('bianco_used_header', 'market' );
			$vertical_banner_html      	= '';
			if ( $ovic_vertical_banner ) {
				$image = wp_get_attachment_image( $ovic_vertical_banner, 'full', false, array(
					'title'        => get_post_field( 'post_title', $ovic_vertical_banner ),
					'data-caption' => get_post_field( 'post_excerpt', $ovic_vertical_banner ),
					'class'        => 'wp-post-image',
				)
				);
				if ( $ovic_vertical_banner_link ) {
					$link                 = esc_url( $ovic_vertical_banner_link );
					$vertical_banner_html = "<div class='vertical-banner'><a href='{$link}'><figure>{$image}</figure></a></div>";
				} else {
					$vertical_banner_html = "<div class='vertical-banner'><figure>{$image}</figure></div>";
				}
			}
			$block_class = array( 'vertical-wrapper block-nav-category has-vertical-menu' );
			$post_type   = '';
			if ( isset( $post->post_type ) )
				$post_type = $post->post_type;
			if ( is_array( $block_vertical ) && in_array( $post->ID, $block_vertical ) && $post_type == 'page' && $bianco_used_header != 'furniture' )
				$block_class[] = 'always-open';
			?>
            <!-- block category -->
            <div class="<?php echo implode( ' ', $block_class ); ?>">
                <div class="block-title">
                    <span class="before">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <span class="text-title"><?php echo esc_html( $vertical_title ); ?></span>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </div>
                <div class="block-content verticalmenu-content">
					<?php
					wp_nav_menu( array(
							'theme_location'  => 'vertical_menu',
							'depth'           => 4,
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'ovic-nav vertical-menu clone-main-menu',
							'megamenu_layout' => 'vertical',
							'mobile_enable'   => $mobile_active,
						)
					);
					echo wp_specialchars_decode( $vertical_banner_html );
					?>
                </div>
            </div><!-- block category -->
		<?php endif;
	}
}

if ( !function_exists( 'bianco_header_mobile' ) ) {
	function bianco_header_mobile(){ ?>
        <div class="header-mobile-wapper">
            <div class="header-mobile">
                <div class="main-header">
                    <div class="logo">
						<?php Bianco_Functions::get_logo(); ?>
                    </div>
                    <div class="control">
                        <div class="menu-mobile-wapper">
                            <a href="#" class="menu-bar menu-toggle">
                                <span class="fa fa-bars"></span>
                            </a>
                        </div>
                        <div class="mobile-cart-block">
							<?php if ( class_exists( 'WooCommerce' ) ) : ?>
                                <div class="mobile-block block-minicart">
                                    <a class="link-dropdown block-cart-link" href="<?php echo wc_get_cart_url(); ?>">
                                        <span class="bianco-icon icon-handbag">
                                            <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                        </span>
                                    </a>
                                </div>
							<?php endif; ?>
                        </div>
                        <div class="form-search-mobile">
                            <a href="#"><i class="bianco-icon icon-search"></i></a>
							<?php bianco_search_form(); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
		<?php
	}
}

/**
 * linearicons for menu
 */
if ( !function_exists( 'bianco_menu_iconpicker_type' ) ) {
	add_filter( 'ovic_menu_icons_setting', 'bianco_menu_iconpicker_type' );
	function bianco_menu_iconpicker_type( $fonts ){
		$icons = array(
			array( "bianco-icon icon-shoes" => "icon shoes" ),
			array( "bianco-icon icon-man-jacket" => "icon man-jacket" ),
			array( "bianco-icon icon-handbag" => "icon handbag" ),
			array( "bianco-icon icon-cancel" => "icon cancel" ),
			array( "bianco-icon icon-compare" => "icon compare" ),
			array( "bianco-icon icon-time-zone" => "icon time-zone" ),
			array( "bianco-icon icon-heart" => "icon heart" ),
			array( "bianco-icon icon-dress" => "icon dress" ),
			array( "bianco-icon icon-order-car" => "icon order-car" ),
			array( "bianco-icon icon-building" => "icon building" ),
			array( "bianco-icon icon-suporter" => "icon suporter" ),
			array( "bianco-icon icon-home-furniture" => "icon home-furniture" ),
			array( "bianco-icon icon-magnifier" => "icon magnifier" ),
			array( "bianco-icon icon-round-cancel" => "icon round-cancel" ),
			array( "bianco-icon icon-location" => "icon location" ),
			array( "bianco-icon icon-setup" => "icon setup" ),
			array( "bianco-icon icon-vertical-menu" => "icon vertical-menu" ),
			array( "bianco-icon icon-evelope" => "icon evelope" ),
			array( "bianco-icon icon-digital-equipment" => "icon digital-equipment" ),
			array( "bianco-icon icon-agent" => "icon agent" ),
			array( "bianco-icon icon-user" => "icon user" ),
			array( "bianco-icon icon-duck-wood" => "icon duck-wood" ),
			array( "bianco-icon icon-washing-machine" => "icon washing-machine" ),
		);
		$fonts = array_merge( $icons, $fonts );
		return $fonts;
	}
}

/**
 * linearicons for shortcode
 */
if ( !function_exists( 'bianco_iconpicker_type' ) ) {
	add_filter( 'ovic_add_icon_field', 'bianco_iconpicker_type' );
	function bianco_iconpicker_type(){
		$fonts = array(
			array( "bianco-icon icon-shoes" => "icon shoes" ),
			array( "bianco-icon icon-man-jacket" => "icon man-jacket" ),
			array( "bianco-icon icon-handbag" => "icon handbag" ),
			array( "bianco-icon icon-cancel" => "icon cancel" ),
			array( "bianco-icon icon-compare" => "icon compare" ),
			array( "bianco-icon icon-time-zone" => "icon time-zone" ),
			array( "bianco-icon icon-heart" => "icon heart" ),
			array( "bianco-icon icon-dress" => "icon dress" ),
			array( "bianco-icon icon-order-car" => "icon order-car" ),
			array( "bianco-icon icon-building" => "icon building" ),
			array( "bianco-icon icon-suporter" => "icon suporter" ),
			array( "bianco-icon icon-home-furniture" => "icon home-furniture" ),
			array( "bianco-icon icon-magnifier" => "icon magnifier" ),
			array( "bianco-icon icon-round-cancel" => "icon round-cancel" ),
			array( "bianco-icon icon-location" => "icon location" ),
			array( "bianco-icon icon-setup" => "icon setup" ),
			array( "bianco-icon icon-vertical-menu" => "icon vertical-menu" ),
			array( "bianco-icon icon-evelope" => "icon evelope" ),
			array( "bianco-icon icon-digital-equipment" => "icon digital-equipment" ),
			array( "bianco-icon icon-agent" => "icon agent" ),
			array( "bianco-icon icon-user" => "icon user" ),
			array( "bianco-icon icon-duck-wood" => "icon duck-wood" ),
			array( "bianco-icon icon-washing-machine" => "icon washing-machine" ),
		);
		return $fonts;
	}
}

if ( !function_exists( 'bianco_gen_icon_to_picker' ) ) {
	add_action( 'ovic_load_icons_after', 'bianco_gen_icon_to_picker' );
	function bianco_gen_icon_to_picker(){
		$icons = array(
			"bianco-icon icon-shoes",
			"bianco-icon icon-man-jacket",
			"bianco-icon icon-handbag",
			"bianco-icon icon-cancel",
			"bianco-icon icon-compare",
			"bianco-icon icon-time-zone",
			"bianco-icon icon-heart",
			"bianco-icon icon-dress",
			"bianco-icon icon-order-car",
			"bianco-icon icon-building",
			"bianco-icon icon-suporter",
			"bianco-icon icon-home-furniture",
			"bianco-icon icon-magnifier",
			"bianco-icon icon-round-cancel",
			"bianco-icon icon-location",
			"bianco-icon icon-setup",
			"bianco-icon icon-vertical-menu",
			"bianco-icon icon-evelope",
			"bianco-icon icon-digital-equipment",
			"bianco-icon icon-agent",
			"bianco-icon icon-user",
			"bianco-icon icon-duck-wood",
			"bianco-icon icon-washing-machine",
		);
		$html_result = '<h4 class="ovic-icon-title">Bianco Font</h4>';
		foreach ( $icons as $icon ) {
			$html_result .= '<a class="ovic-icon-tooltip" data-ovic-icon="' . $icon . '" title="' . $icon . '"><span class="ovic-icon ovic-selector"><i class="' . $icon . '"></i></span></a>';
		}
		$html_result .= '<p style="margin-bottom: 30px;"></p>';
		echo wp_specialchars_decode( $html_result );
	}
}

/* Hero banner*/
if ( !function_exists( 'bianco_show_hero_section' ) ) {
	function bianco_show_hero_section(){
		$bianco_used_hero_banner = Bianco_Functions::get_option( 'bianco_used_hero_banner', true );
		$hero_content           = apply_filters( 'bianco_hero_content', bianco_get_title() );
		$html_result            = '';
		if ( $bianco_used_hero_banner ) {
			$html_result .= '<div class="wrap-hero-section">';
			$bianco_used_hero_type   = Bianco_Functions::get_option( 'bianco_used_hero_type', 'banner' );
			$bianco_hero_image = Bianco_Functions::get_option( 'bianco_hero_image', '' );
			$bianco_rev_hero    = Bianco_Functions::get_option( 'bianco_rev_hero', '' );
			$ovic_theme_lazy_load    = Bianco_Functions::get_option( 'ovic_theme_lazy_load', false );
			if ( $bianco_used_hero_type == 'banner') {
				$img_default = get_template_directory_uri().'/assets/images/default_herro_banner.jpg';
				$attachment = array( $img_default, 1920, 240 );
				if($bianco_hero_image) $attachment = wp_get_attachment_image_src( $bianco_hero_image, 'full' );
				if ( $ovic_theme_lazy_load ) {
					$html_result .= '<div class="inner-hero-section lazy  --'.$bianco_hero_image.'--" style="max-width:100%; width:' . $attachment[1] . 'px; height:' . $attachment[2] . 'px;" data-src="' . $attachment[0] . '">';
				} else {
					$html_result .= '<div class="inner-hero-section" style="max-width:100%; width:' . $attachment[1] . 'px; height:' . $attachment[2] . 'px; background-image: url(' . $attachment[0] . ')">';
				}
				$html_result .= $hero_content;
			} elseif ( $bianco_used_hero_type == 'rev_slider' && $bianco_rev_hero ) {
				$html_result .= '<div class="inner-hero-section rev-hero">';
				if ( class_exists( 'RevSlider' ) ) {
					ob_start();
					RevSliderOutput::putSlider( $bianco_rev_hero );
					$html_result = ob_get_clean();
				}
			}
			$html_result .= '</div></div>';
		}
		echo wp_specialchars_decode( $html_result );
	}
}

if ( !function_exists( 'bianco_get_title' ) ) {
	function bianco_get_title(){
		if ( !is_front_page() || !is_home() ) {
			if ( is_page() ) {
				$output = get_the_title();
			} elseif ( is_single() ) {
				if ( is_singular( 'product' ) ) {
					$output = esc_html__( 'Detail Product', 'bianco' );
				} elseif ( is_singular( 'post' ) ) {
					$output = esc_html__( 'bianco blog', 'bianco' );
				} else {
					$output = get_the_title();
				}
			} elseif ( class_exists('WooCommerce') && is_shop() ) {
				$output = esc_html__( 'Shop', 'bianco' );
			} elseif ( is_search() ) {
				$output = esc_html__( 'Search', 'bianco' );
			} elseif ( is_post_type_archive( 'portfolio' ) ) {
				$output = esc_html__( 'Portfolio', 'bianco' );
			} else {
				if ( is_home() ) {
					$output = esc_html__( 'bianco blog', 'bianco' );
				} else {
					$output = get_the_archive_title();
				}
			}
			if ( is_search() ) {
				$output_html = '<h2 class="page-title">' . esc_html__( 'Search', 'bianco' ) . '</h2>';
			} elseif ( is_404() ) {
				$output_html = '';
			} else {
				$output_html = '<h2 class="page-title">' . $output . '</h2>';
			}
		} else {
			$output_html = '<h2 class="page-title">' . esc_html__( 'Latest Post', 'bianco' ) . '</h2>';
		}

		return $output_html;
	}
}

if ( !function_exists( 'bianco_locate_template' ) ) {
	function bianco_locate_template( $template_name, $template_path = '', $default_path = '' )
	{
		if ( !$template_path ) {
			$template_path = get_template_directory();
		}
		if ( !$default_path ) {
			$default_path = get_template_directory();
		}
		/*Look within passed path within the theme - this is priority.*/
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);
		/*Get default template/.*/
		if ( !$template ) {
			$template = $default_path . $template_name;
		}

		/*Return what we found.*/
		return apply_filters( 'bianco_locate_template', $template, $template_name, $template_path );
	}
}

if ( !function_exists( 'bianco_get_template' ) ) {
    function bianco_get_template( $template_name, $atts = array(), $template_path = '', $default_path = '' ){
        $located = bianco_locate_template( $template_name, $template_path, $default_path );
        if ( !file_exists( $located ) ) {
            return;
        }
        /*Allow 3rd party plugin filter template file from their plugin.*/
        $located = apply_filters( 'bianco_get_template', $located, $template_name, $atts, $template_path, $default_path );
        do_action( 'bianco_before_template_part', $template_name, $template_path, $located, $atts );
        include $located;
        do_action( 'bianco_after_template_part', $template_name, $template_path, $located, $atts );
    }
}

if ( !function_exists( 'bianco_get_target_link' ) ){
	function bianco_get_target_link($link){
	    $target_result ='';
	    $link = wp_parse_args(
	            $link,
	            array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '')
	    	);
	    if( $link['title'] == '' || $link['url'] == '' || $link['url'] == '#'){
	        return $target_result;
	    }
	    return  "target=\"{$link['target']}\"";
	}
}

/**
 * Call a shortcode function by tag name.
 *
 * @since  1.4.6
 *
 * @param string $tag The shortcode whose function to call.
 * @param array $atts The attributes to pass to the shortcode function. Optional.
 * @param array $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
if ( !function_exists( 'bianco_do_shortcode' ) ) {
	function bianco_do_shortcode( $tag, array $atts = array(), $content = null ){
		global $shortcode_tags;
		if ( !isset( $shortcode_tags[$tag] ) ) {
			return false;
		}
		return call_user_func( $shortcode_tags[$tag], $atts, $content, $tag );
	}
}