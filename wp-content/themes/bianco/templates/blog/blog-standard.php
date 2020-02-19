<?php
$classes[] = 'post-item ';
$classes[] = apply_filters( 'bianco_blog_content_class', '' );
if ( have_posts() ) : ?>
	<?php do_action( 'bianco_before_blog_content' ); ?>
    <div class="blog-standard content-post">
		<?php while ( have_posts() ) : the_post(); $is_thumbnail = (int)has_post_thumbnail(); ?>
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