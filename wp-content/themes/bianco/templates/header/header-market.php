<?php
/**
 * Name:  Market
 **/
?>
<header id="header" class="header header-market">
    <div class="top-header">
        <div class="container">
            <div class="item-top-left">
				<?php do_action( 'bianco_top_left_menu' ); ?>
            </div>
            <div class="item-top-right">               
                <?php echo do_shortcode( '[woocs]' ); ?>                  
				<?php do_action( 'bianco_top_right_menu' ); ?>                
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="header-middle-inner">
                <div class="row">
                    <div class="col-lg-3 col-md-2 col-xs-6 wrap-logo">
                        <div class="logo"><?php bianco_get_logo(); ?></div>
                    </div>
                    <div class="col-lg-9 col-md-10 col-xs-6">
                        <div class="box-search">
							<?php bianco_search_form(); ?>
                        </div>
                        <div class="header-control">
                            <div class="box-search-mobile">
                                <a class="btn-control" href="javascript:void(0)"><span class="bianco-icon icon-magnifier"></span></a>
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
                <div class="con-lg-3 col-md-3 col-sm-3">
                    <div class="wrap-vertical-menu">
						<?php do_action( 'bianco_header_vertical', true ); ?>
                    </div>
                </div>
                <div class="con-lg-9 col-md-9 col-sm-9">
					<?php if ( has_nav_menu( 'primary' ) ): ?>
                        <div class="wrap-main-menu">
							<?php
							wp_nav_menu( array(
									'menu'            => 'primary',
									'theme_location'  => 'primary',
									'depth'           => 4,
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
                    <ul class="language-selector">
						<?php do_action( 'bianco_header_language' ) ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>