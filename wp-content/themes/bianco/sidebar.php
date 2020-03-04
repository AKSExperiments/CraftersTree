<?php
$bianco_blog_used_sidebar = Bianco_Functions::get_option( 'ovic_blog_used_sidebar', 'widget-area' );
if( is_single()){
    $bianco_blog_used_sidebar = Bianco_Functions::get_option( 'ovic_single_used_sidebar', 'widget-area' );
}
if ( is_active_sidebar( $bianco_blog_used_sidebar ) ) : ?>
    <div class="sidebar-head">
        <span class="text"><?php esc_html_e('Sidebar','bianco');?></span>
        <a href="#" class="close-block-sidebar"><span class="ti-close"></span></a>
    </div>
    <div id="widget-area" class="widget-area blog-sidebar">
        <?php dynamic_sidebar( $bianco_blog_used_sidebar ); ?>
    </div><!-- .widget-area -->
<?php endif;