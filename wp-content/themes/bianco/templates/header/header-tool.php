<?php
/**
 * Name:  Tool
 **/
$own_info = '';
$phone_number = Bianco_Functions::get_option( 'bianco_phone_number', '');
$working_time = Bianco_Functions::get_option( 'bianco_working_time', '');

$own_info .= ($phone_number) ? "<b class='own-phone-number'>{$phone_number}</b>":'';
$own_info .= ($working_time) ? "<span class='own-working-time'>{$working_time}</span>":'';

?>
<header id="header" class="header header-tool">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 item-top-left">
                    <div class="wcml-dropdown product wcml_currency_switcher">
                        <ul>
                            <li class="wcml-cs-active-currency">
                                <a class="wcml-cs-item-toggle" href="javascript:void(0)">USD</a>
                                <ul class="wcml-cs-submenu">
                                    <li><a rel="EUR" href="javascript:void(0)" >EUR</a></li>
                                    <li><a rel="EUR" href="javascript:void(0)" >YEN</a></li>
                                    <li><a rel="EUR" href="javascript:void(0)" >NDT</a></li>
                                    <li><a rel="EUR" href="javascript:void(0)" >DONG</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 item-top-right">
                    <?php do_action( 'bianco_top_right_menu' ); ?>
                    <div class="box-search">
                        <a href="javascript:void(0)"><span class="bianco-icon icon-magnifier" aria-hidden="true"></span></a>
                        <?php bianco_search_form('simple'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="row">
                <div class="header-middle-inner header-responsive">
                    <div class="logo  col-lg-2 col-md-4 col-sm-6 col-xs-6">
                        <?php bianco_get_logo(); ?>
                    </div>
                    <div class="box-header-nav col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                    <div class="header-control col-lg-4 col-md-8 col-sm-6 col-xs-6">
                    <?php if($own_info): ?>
                        <div class="own-info"><?php echo wp_specialchars_decode($own_info); ?></div>
                    <?php endif; ?>
                        <?php  do_action('bianco_header_mini_cart'); ?>
                        <div class="box-search-mobile">
                            <a class="btn-control" href="javascript:void(0)">
                                <span class="bianco-icon icon-magnifier"></span>
                            </a>
                        </div>
                        <div class="box-search">
                            <?php bianco_search_form('simple'); ?>
                        </div>
                        <div class="block-menu-bar">
                            <a class="menu-bar menu-toggle" href="#"><span></span><span></span><span></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>