<?php get_header(); ?>
<?php
/*Default  page layout*/
$bianco_page_layout = Bianco_Functions::get_post_meta( get_the_ID(), 'ovic_page_layout', 'left' );
$bianco_page_used_sidebar = Bianco_Functions::get_post_meta( get_the_ID(), 'ovic_page_used_sidebar', 'widget-area' );
if ( !is_active_sidebar($bianco_page_used_sidebar) ){
    $bianco_page_layout = 'full';
}
/*main container class*/
$bianco_main_container_class   = array();
$bianco_main_container_class[] = 'main-container';

/*main content class*/
$bianco_main_content_class   = array();
$bianco_main_content_class[] = 'main-content';

/*sidebar class*/
$bianco_sidebar_class   = array();
$bianco_sidebar_class[] = 'sidebar';

$use_sidebar = true;
if ( $bianco_page_layout == 'full' ) {
	$bianco_main_container_class[] = 'no-sidebar';
	$bianco_main_content_class[] = 'col-sm-12';
	$use_sidebar = false;
} else {
	$bianco_main_container_class[] = $bianco_page_layout . '-sidebar';
	$bianco_main_content_class[] = 'col-lg-9 col-md-8';
	$bianco_sidebar_class[] = 'col-lg-3 col-md-4';
}

/* Data MetaBox */
$data_meta = get_post_meta( get_the_ID(), '_custom_metabox_theme_options', true ); ?>

<?php do_action( 'bianco_before_content_wrapper' ); ?>
    <main class="site-main default-page-layout <?php echo esc_attr( implode( ' ', $bianco_main_container_class ) ); ?>">
        <?php do_action( 'bianco_show_hero_section' ); ?>
		<div class="bianco-wrap-breadcrumb wrap-breadcrumb">
            <div class="container">
                <?php do_action( 'ovic_breadcrumb',array('show_browse' =>false)); ?>
            </div>
        </div>
        <div class="container">
			<?php do_action( 'bianco_before_content_inner' ); ?>
            <div class="row">
                <div class="<?php echo esc_attr( implode( ' ', $bianco_main_content_class ) ); ?>">
					<?php
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							?>
                            <div class="page-main-content">
								<?php
								the_content();
								wp_link_pages( 
									array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'bianco' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
										'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'bianco' ) . ' </span>%',
										'separator'   => '<span class="screen-reader-text">, </span>',
									)
								);
								?>
                            </div>
							<?php
							/*If comments are open or we have at least one comment, load up the comment template.*/
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
							?>
							<?php
						}
					}
					?>
                </div>
				<?php if ( $bianco_page_layout != "full" ): ?>
                    <div class="<?php echo esc_attr( implode( ' ', $bianco_sidebar_class ) ); ?>">
						<?php get_sidebar( 'page' ); ?>
                    </div>
				<?php endif; ?>
            </div>
			<?php do_action( 'bianco_after_content_inner' ); ?>
        </div>
    </main>
<?php 
	do_action( 'bianco_after_content_wrapper' );
	get_footer();