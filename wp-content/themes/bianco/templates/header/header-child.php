<?php
/**
 * Name:  Child
 **/
$ovic_header_messgae = Bianco_Functions::get_option( 'ovic_header_messgae', '' );
$bianco_suport_info = Bianco_Functions::get_option( 'bianco_suport_info', '' );
$user_all_social = Bianco_Functions::get_option( 'user_all_social', array() );
?>
<header id="header" class="header header-child light-style">
    <div class="top-header">
        <div class="container">
            <div class="item-top-left">
                <?php do_action( 'bianco_top_left_menu' ); ?>
            </div>
            <div class="item-top-right">                
                <?php do_action( 'bianco_top_right_menu' ); ?>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="header-middle-inner">
                <div class="row">
                    <div class="col-lg-4 col-md-0 col-sm-0">
                        <div class="wrap-midle-left">
                            <?php do_action( 'bianco_header_currency') ?>
                            <?php if($bianco_suport_info): ?>
                            <div class="support-info">
                                <img src="<?php echo get_template_directory_uri()."/assets/images/suport_img.png"; ?>" width="22" height="22" alt="<?php printf(' %s support info',get_bloginfo('name')); ?>">
                                <span class="txt-inf"><?php echo esc_html($bianco_suport_info);?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                        <div class="logo"><?php bianco_get_logo(); ?></div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                        <div class="header-control">
                            <div class="box-search">
                                <a href="javascript:void(0)"><span class="bianco-icon icon-magnifier" aria-hidden="true"></span></a>
                                <?php bianco_search_form('simple'); ?>
                            </div>
                            <div class="box-search-mobile">
                                <a class="btn-control" href="javascript:void(0)">
                                    <span class="bianco-icon icon-search"></span>
                                    <span class="bianco-icon icon-magnifier"></span>
                                </a>
                            </div>
                            <?php
                            do_action( 'bianco_display_compare_block' );
                            do_action( 'bianco_display_wishlist_block' );
                            do_action( 'bianco_header_mini_cart' );
                            ?>
                            <div class="block-menu-bar">
                                <a class="menu-bar menu-toggle" href="#">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8">
                <?php if ( has_nav_menu( 'primary' ) ): ?>
                    <div class="wrap-main-menu">
                        <?php
                        wp_nav_menu(
                            array(
                                'menu'            => 'primary',
                                'theme_location'  => 'primary',
                                'depth'           => 3,
                                'container'       => '',
                                'container_class' => '',
                                'container_id'    => '',
                                'menu_class'      => 'clone-main-menu bianco-nav main-menu',
                                'mobile_enable'   => true,
                            )
                        );
                        ?>
                    </div>
                <?php endif; ?>
                </div>
                <?php if(!empty($user_all_social)): ?>
                <div class="col-lg-2 col-md-2 col-sm-4">
                    <ul class="social-lists">
                    <?php foreach ($user_all_social as $social): ?>
                        <li class="social-item">
                            <a href="<?php echo esc_url($social['link_social']); ?>" title="<?php echo esc_attr($social['title_social']); ?>" class="link-social">
                                <i class="<?php echo esc_attr($social['icon_social']); ?>"></i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>