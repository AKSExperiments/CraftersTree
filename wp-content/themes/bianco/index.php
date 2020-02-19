<?php get_header(); ?>
<?php
/* Get Blog Settings */
$bianco_blog_layout = Bianco_Functions::get_option( 'ovic_sidebar_blog_layout', 'left' );
$bianco_blog_used_sidebar = Bianco_Functions::get_option( 'ovic_blog_used_sidebar', 'widget-area' );
$ovic_blog_list_style = Bianco_Functions::get_option( 'ovic_blog_list_style','default');
if ( is_single() ) {
	$bianco_blog_layout = Bianco_Functions::get_option( 'ovic_sidebar_single_layout', 'left' );
    $bianco_blog_used_sidebar = Bianco_Functions::get_option( 'ovic_single_used_sidebar', 'widget-area' );
}
if ( !is_active_sidebar( $bianco_blog_used_sidebar )){
    $bianco_blog_layout = 'full';
}
/*Main container class*/
$bianco_main_container_class   = array();
$bianco_main_container_class[] = 'main-container';

/*main content class*/
$bianco_main_content_class   = array();
$bianco_main_content_class[] = 'main-content';

/*sidebar class*/
$bianco_sidebar_class   = array();
$bianco_sidebar_class[] = 'sidebar';

$use_sidebar = true;
if ( $bianco_blog_layout == 'full' ) {
	$bianco_main_container_class[] = 'no-sidebar';
    $bianco_main_content_class[] = 'col-sm-12';
    $use_sidebar = false;
} else {
	$bianco_main_container_class[] = $bianco_blog_layout . '-sidebar';
    $bianco_main_content_class[] = 'col-lg-9 col-md-8';
    $bianco_sidebar_class[] = 'col-lg-3 col-md-4';
}

?>
<?php do_action( 'bianco_before_content_wrapper' ); ?>
    <?php do_action( 'bianco_show_hero_section' ); ?>
    <div class="<?php echo esc_attr( implode( ' ', $bianco_main_container_class ) ); ?>">
        <div class="bianco-wrap-breadcrumb wrap-breadcrumb">
            <div class="container">
                <?php do_action( 'ovic_breadcrumb',array('show_browse' =>false)); ?>
            </div>
        </div>
        <?php do_action( 'bianco_before_content_inner' ); ?>
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr( implode( ' ', $bianco_main_content_class ) ); ?>">
                    <!-- Main content -->
					<?php
					if ( is_single() ) {
						while ( have_posts() ): the_post();
							get_template_part( 'templates/blog/blog', 'single' );
							/*If comments are open or we have at least one comment, load up the comment template.*/
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						endwhile;
						wp_reset_postdata();
					} else {
						get_template_part( 'templates/blog/blog', $ovic_blog_list_style);
					} ?>
                </div>
				<?php if ( $use_sidebar ): ?>
                    <div class="<?php echo esc_attr( implode( ' ', $bianco_sidebar_class ) ); ?>">
                        <?php get_sidebar(); ?>
                    </div>
				<?php endif; ?>
            </div>
			<?php do_action( 'bianco_after_content_inner' ); ?>
        </div>
    </div>
<?php 
    do_action( 'bianco_after_content_wrapper' );
    get_footer();