<?php
/*Custom columns*/
$classes[] = 'post-item grid date-in-front';
$classes[] = 'col-bg-' . Bianco_Functions::get_option( 'ovic_blog_bg_items', 3 );
$classes[] = 'col-lg-' . Bianco_Functions::get_option( 'ovic_blog_lg_items', 4 );
$classes[] = 'col-md-' . Bianco_Functions::get_option( 'ovic_blog_md_items', 4 );
$classes[] = 'col-sm-' . Bianco_Functions::get_option( 'ovic_blog_sm_items', 12 );
$classes[] = 'col-xs-' . Bianco_Functions::get_option( 'ovic_blog_xs_items', 12 );
$classes[] = 'col-ts-' . Bianco_Functions::get_option( 'ovic_blog_ts_items', 12 );
$classes[] = apply_filters( 'bianco_blog_content_class', '' );
if ( have_posts() ) : ?>
	<?php do_action( 'bianco_before_blog_content' ); ?>
    <div class="row blog-grid content-post auto-clear">
		<?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class( $classes ); ?>>
				<?php
				/**
				 * Functions hooked into bianco_post_content action
				 *
				 * @hooked bianco_post_thumbnail          - 10
				 * @hooked bianco_post_title              - 15
				 * @hooked bianco_post_info               - 20
				 * @hooked bianco_post_excerpt            - 25
				 * @hooked bianco_post_readmore           - 30
				 */
				do_action( 'bianco_post_content' ); ?>
            </article>
		<?php endwhile;
		wp_reset_postdata(); ?>
    </div>
	<?php
	/**
	 * Functions hooked into bianco_after_blog_content action
	 *
	 * @hooked bianco_paging_nav               - 10
	 */
	do_action( 'bianco_after_blog_content' ); ?>
<?php else :
	get_template_part( 'content', 'none' );
endif;