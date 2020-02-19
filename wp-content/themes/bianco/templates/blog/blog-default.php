<?php
if ( have_posts() ) : ?>
	<?php
	do_action( 'bianco_before_blog_content' );
	?>
    <div class="blog-grid blog-style-default content-post auto-clear">
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class( 'post-item' ); ?>>
                <?php if ( !post_password_required() && !is_attachment() && has_post_thumbnail() ) { ?>
                    <div class="post-thumbnail">
                        <a class="" href="<?php the_permalink(); ?>" aria-hidden="true">
                            <?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
                        </a>
                    </div>
                <?php } ?>
                <?php
                $edit_post = '';
                $edit_url = get_edit_post_link();
                if ($edit_url){
                    $edit_post = '<a class="edit-url" href="'.$edit_url.'"><i class="fa fa-pencil"></i></a>';
                }
                $title = get_the_title();
                if ( is_sticky()) :
                    the_title( sprintf( '<h2 class="entry-title is_sticky"><a href="%s" rel="bookmark"><i class="fa fa-paperclip" aria-hidden="true"></i>', esc_url( get_permalink() ) ), '</a>'.$edit_post.'</h2>' );
                else:
                    if (!$title): ?>
                        <h2 class="entry-title">
                            <a href="<?php echo esc_url( get_permalink() );?>" rel="bookmark"><?php echo esc_html__('No title', 'bianco') ?></a>
                            <?php wp_specialchars_decode($edit_post) ?>
                        </h2>
                    <?php else:
                        the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>'.$edit_post.'</h2>' );
                    endif;
                endif; ?>
                <div class="entry-content">
                    <div class="meta">
                        <?php
                        $time_string = sprintf( '<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
                            esc_attr( get_the_date( 'c' ) ),
                            get_the_date()
                        );
                        printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
                            _x( 'Posted on: ', 'Used before publish date.', 'bianco' ),
                            esc_url( get_permalink() ),
                            $time_string
                        );

                        printf( '<span class="sp"></span><span class="byline"><span class="screen-reader-text">%1$s </span> <a class="url fn n" href="%2$s">%3$s</a></span>',
                            _x( 'By: ', 'Used before post author name.', 'bianco' ),
                            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                            get_the_author()
                        );
                        if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                            echo wp_specialchars_decode('<span class="sp"></span><span class="comments-link">');
                            comments_popup_link();
                            echo wp_specialchars_decode('</span>');
                        }
                        ?>
                    </div>
                    <?php if ( has_excerpt() || is_search() ) : ?>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                    <?php endif; ?>
                </div>
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