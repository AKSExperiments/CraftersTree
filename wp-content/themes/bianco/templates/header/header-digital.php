<?php
/**
 * Name:  Digital
 **/
$bianco_suport_info = Bianco_Functions::get_option( 'bianco_suport_info', '' );
?>
<header id="header" class="header header-digital">
    <div class="top-header">
        <div class="container">
            <div class="header-top-left">
                <?php do_action('bianco_top_left_menu'); ?>
            </div>
            <div class="header-top-right">
                <?php do_action('bianco_top_right_menu'); ?>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="header-middle-inner">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 wrap-logo">
                        <div class="logo"><?php bianco_get_logo(); ?></div>
                    </div>
                    <div class="col-lg-6 col-md-8 col-sm-8 col-xs-6 wrap-menu">
                        <div class="box-middle">
                            <div class="box-header-nav primary-menu">
                                <?php
                                    if (has_nav_menu('primary')) {
                                        wp_nav_menu(array(
                                            'menu' => 'primary',
                                            'theme_location' => 'primary',
                                            'depth' => 3,
                                            'container' => '',
                                            'container_class' => '',
                                            'container_id' => '',
                                            'menu_class' => 'clone-main-menu bianco-nav main-menu',
                                            'megamenu' => true,
                                            'mobile_enable' => true,
                                            )
                                        );
                                    }
                                ?>
                            </div>
                            <div class="header-control mobile-version">
                                <div class="box-search-mobile">
                                    <a class="btn-submit btn-control"><span class="bianco-icon icon-magnifier"></span></a>
                                    <div class="box-search">
                                        <?php bianco_search_form(); ?>
                                    </div>
                                </div>
                                <?php do_action( 'bianco_header_mini_cart' ); ?>
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
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 wrap-info">
                        <?php if ( function_exists('icl_object_id') ): ?>
                        <div class="head-info bianco-multilanguages">
                            <?php do_action( 'bianco_header_currency') ?>
                        </div>
                        <?php endif; ?>
                        <?php if( $bianco_suport_info): ?>
                        <div class="support-info">
                            <img src="<?php echo get_template_directory_uri()."/assets/images/suport_img.png"; ?>" width="22" height="22" alt="<?php printf(' %s support info',get_bloginfo('name')); ?>">
                            <span class="txt-inf"><?php echo esc_html($bianco_suport_info);?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 ">
                    <div class="header-nav-inner header-responsive main-vertical">
                    <?php bianco_header_vertical(true); ?>
                    </div>
                </div>
                <div class="col-sm-9 col-md-9 col-sm-9">
                    <div class="box-search">
                        <?php bianco_search_form(); ?>
                    </div>
                    <div class="header-control">
                        <div class="box-search-mobile">
                            <a class="btn-submit"><span class="bianco-icon icon-search"></span></a>
                        </div>
                        <?php
                            do_action( 'bianco_display_compare_block' );
                            do_action( 'bianco_display_wishlist_block' );
                            do_action( 'bianco_header_mini_cart' );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>