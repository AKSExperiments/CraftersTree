<?php
$sidebar_name   = Bianco_Functions::get_option( 'ovic_shop_used_sidebar', 'shop-widget-area' );
if ( !is_active_sidebar( $sidebar_name ) ) {
	$sidebar_name = 'sidebar-store';
}
?>
<div id="dokan-secondary" class="dokan-clearfix dokan-w3 dokan-store-sidebar widget-area" role="complementary">
    <div class="sidebar-head">
        <span class="text"><?php esc_html_e('Sidebar','bianco');?></span>
        <a href="#" class="close-block-sidebar"><span class="ti-close"></span></a>
    </div>
	<div class="dokan-widget-area widget-collapse">
		<?php dynamic_sidebar( $sidebar_name ); ?>
	</div>
</div>