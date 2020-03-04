<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
/*==========================================================================
HOOK TEMPLATE FUNCTIONS
===========================================================================*/

// BLOG GRID
add_action('bianco_post_content', 'bianco_post_thumbnail', 10);
add_action('bianco_post_content', 'bianco_post_title', 15);
add_action('bianco_post_content', 'bianco_post_sticky', 20);
add_action('bianco_post_content', 'bianco_post_info', 25);
add_action('bianco_post_content', 'bianco_post_excerpt', 30);
add_action('bianco_post_content', 'bianco_post_readmore', 35);
add_action('bianco_post_info_content', 'bianco_post_author', 10);
add_action('bianco_post_info_content', 'bianco_tpl_post_comment', 15);
add_action('bianco_post_info_content', 'bianco_tpl_count_like', 20);
add_action('bianco_post_info_content', 'bianco_tpl_share_post', 25);
add_action('bianco_header_currency', 'bianco_header_currency', 10);

// POST SINGLE
add_action('bianco_single_post_content', 'bianco_single_post_title', 10);
add_action('bianco_single_post_content', 'bianco_post_info', 15);
add_action('bianco_single_post_content', 'bianco_single_post_thumbnail', 20);
add_action('bianco_single_post_content', 'bianco_post_single_content', 25);
add_action('bianco_after_blog_content', 'bianco_paging_nav', 10);
add_action('bianco_after_single_blog_content', 'bianco_show_author_bios', 10);
add_action('bianco_after_single_blog_content', 'bianco_post_tags', 15);
add_action('bianco_after_single_blog_content', 'bianco_post_loop_share_button', 20);
add_action('bianco_post_loop_thumbnail', 'bianco_post_thumbnail', 10, 1);
add_action('bianco_post_loop_sticky', 'bianco_post_loop_sticky', 10, 2);
add_action('bianco_post_loop_excerpt', 'bianco_post_loop_excerpt', 10, 2);
add_action('bianco_post_loop_title', 'bianco_post_loop_title', 10, 1);
add_action('bianco_post_loop_readmore', 'bianco_post_loop_readmore', 10, 1);
add_action('bianco_post_loop_author', 'bianco_post_loop_author', 10, 1);
add_action('bianco_post_loop_category', 'bianco_post_loop_category', 10, 2);
add_action('bianco_post_loop_date', 'bianco_post_loop_date', 10, 2);
add_action('bianco_post_loop_tags', 'bianco_post_loop_tags', 10, 2);
add_action('bianco_post_loop_comment', 'bianco_post_loop_comment', 10, 4);
add_action('bianco_post_loop_share_button', 'bianco_post_loop_share_button', 10, 1);
add_filter( 'comment_form_fields', 'bianco_move_comment_field_to_bottom' );

/*==========================================================================
TEMPLATE FUNCTIONS
===========================================================================*/
if (!function_exists('bianco_post_loop_share_button')) {
    function bianco_post_loop_share_button($post_id = 0)
    {
        $enable_share_buttons = Bianco_Functions::get_option('bianco_used_socials_media_in_single',0);
        if(!$enable_share_buttons) return '';
        if (!$post_id)
            $post_id = get_the_ID();
        $share_image_url = wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'full');
        $share_link_url = get_permalink($post_id);
        $share_link_title = get_the_title();
        $share_summary = get_the_excerpt();
        $twitter = 'https://twitter.com/share?url=' . $share_link_url . '&text=' . $share_summary;
        $facebook = 'https://www.facebook.com/sharer.php?u=' . $share_link_url;
        $google = 'https://plus.google.com/share?url=' . $share_link_url . '&title=' . $share_link_title;
        $pinterest = 'http://pinterest.com/pin/create/button/?url=' . $share_link_url . '&description=' . $share_summary . '&media=' . $share_image_url;
        ?>
        <div class="ovic-share-socials">
            <span class="share-button icon-share"><?php echo esc_html__('Share', 'bianco') ?></span>
            <div class="list-social">
                <a class="twitter"
                   href="<?php echo esc_url($twitter); ?>"
                   title="<?php echo esc_attr__('Twitter', 'bianco') ?>"
                   onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                </a>
                <a class="facebook"
                   href="<?php echo esc_url($facebook); ?>"
                   title="<?php echo esc_attr__('Facebook', 'bianco') ?>"
                   onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                </a>
                <a class="googleplus"
                   href="<?php echo esc_url($google); ?>"
                   title="<?php echo esc_attr__('Google+', 'bianco') ?>"
                   onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                </a>
                <a class="pinterest"
                   href="<?php echo esc_url($pinterest); ?>"
                   title="<?php echo esc_attr__('Pinterest', 'bianco') ?>"
                   onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                </a>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('bianco_post_loop_comment')) {
    function bianco_post_loop_comment($tag_name = 'div', $zero = false, $one = false, $more = false)
    {
        ?>
        <<?php echo esc_attr($tag_name) ?> class="comment-count">
        <i class="fa fa-comment"></i>
        <?php comments_number($zero, $one, $more); ?>
        </<?php echo esc_attr($tag_name) ?>>
        <?php
    }
}

if (!function_exists('bianco_post_loop_readmore')) {
    function bianco_post_loop_readmore($text)
    {
        ?>
        <a class="read-more" href="<?php the_permalink(); ?>"><?php echo esc_html($text); ?></a>
        <?php
    }
}

if (!function_exists('bianco_post_loop_category')) {
    function bianco_post_loop_category($tag_name = 'div', $text = '')
    {
        $get_term_cat = get_the_terms(get_the_ID(), 'category');
        if (!is_wp_error($get_term_cat) && !empty($get_term_cat)) : ?>
            <<?php echo esc_attr($tag_name) ?> class="post-category">
            <?php if ($text): ?>
                <span class="text-label"><?php echo esc_html($text); ?></span>
            <?php endif; ?>
            <?php the_category(', '); ?>
            </<?php echo esc_attr($tag_name) ?>>
        <?php endif;
    }
}

if (!function_exists('bianco_post_loop_tags')) {
    function bianco_post_loop_tags($tag_name = 'div', $text = '')
    {
        $get_term_tag = get_the_terms(get_the_ID(), 'post_tag');
        if (!is_wp_error($get_term_tag) && !empty($get_term_tag)) : ?>
            <<?php echo esc_attr($tag_name) ?> class="post-tags">
            <?php if ($text): ?>
                <span class="text-label"><?php echo esc_html($text); ?></span>
            <?php endif; ?>
            <?php the_tags(''); ?>
            </<?php echo esc_attr($tag_name) ?>>
        <?php endif;
    }
}

if (!function_exists('bianco_post_loop_title')) {
    function bianco_post_loop_title($tag_name = 'h2')
    {
        ?>
        <<?php echo esc_attr($tag_name) ?> class="post-title"><a
            href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo esc_attr($tag_name) ?>>
        <?php
    }
}

if (!function_exists('bianco_post_loop_excerpt')) {
    function bianco_post_loop_excerpt($num_words, $text_more)
    {
        ?>
        <div class="post-content">
            <?php echo wp_trim_words(apply_filters('the_excerpt', get_the_excerpt()), $num_words, $text_more); ?>
        </div>
        <?php
    }
}

if (!function_exists('bianco_post_loop_sticky')) {
    function bianco_post_loop_sticky($tag_name = 'div', $text = '')
    {
        if (is_sticky()) : ?>
            <<?php echo esc_attr($tag_name) ?> class="sticky-post">
            <i class="sticky-icon"></i>
            <span class="sticky-text">
            <?php echo esc_html__(' Sticky', 'bianco'); ?>
            </span>
            </<?php echo esc_attr($tag_name) ?>>
        <?php endif;
    }
}

if (!function_exists('bianco_post_loop_author')) {
    function bianco_post_loop_author($tag_name = 'div')
    {
        ?>
        <<?php echo esc_attr($tag_name) ?> class="post-author">
        <?php echo get_avatar(get_the_author_meta('user_email'), 28); ?>
        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>"><?php the_author() ?></a>
        </<?php echo esc_attr($tag_name) ?>>
        <?php
    }
}

if (!function_exists('bianco_post_loop_date')) {
    function bianco_post_loop_date($tag_name = 'div', $d = '')
    {
        ?>
        <<?php echo esc_attr($tag_name) ?> class="date">
        <?php
        $archive_year = get_the_time('Y');
        $archive_month = get_the_time('m');
        $archive_day = get_the_time('d');
        ?>
        <a href="<?php echo get_day_link($archive_year, $archive_month, $archive_day); ?>">
            <?php echo get_the_date($d); ?>
        </a>
        </<?php echo esc_attr($tag_name) ?>>
        <?php
    }
}

if (!function_exists('bianco_callback_comment')) {
    /**
     * bianco comment template
     *
     * @param array $comment the comment array.
     * @param array $args the comment args.
     * @param int $depth the comment depth.
     * @since 1.0.0
     */
    function bianco_callback_comment($comment, $args, $depth)
    {
        if ('div' == $args['style']) {
            $tag = 'div ';
            $add_below = 'comment';
        } else {
            $tag = 'li ';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo esc_attr($tag); ?><?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php echo get_comment_ID(); ?>">
        <div class="comment-body">
            <div class="comment-avatar">
                <?php echo get_avatar($comment, 79); ?>
            </div>
            <div class="comment-info">
                <div class="comment-meta">
                    <div class="comment-name vcard">
                        <span><?php comment_author_link(); ?></span>
                    </div>
                    <?php if ('0' == $comment->comment_approved) : ?>
                        <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'bianco'); ?></em>
                        <br/>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(get_comment_link(get_comment_ID())); ?>"
                       class="comment-date">
                        <time datetime="<?php echo get_comment_date('c'); ?>">
                            <span class="high-light">
                                <?php echo get_comment_date('F j, Y'); ?>
                                <?php echo esc_html__('at ', 'bianco'); ?>
                                <?php echo get_comment_time('G:ia'); ?>
                            </span>
                        </time>
                    </a>
                    <span class="high-light"><?php edit_comment_link(__('Edit', 'bianco'), ' - ', ''); ?></span>
                    <?php do_action('ovic_comment_meta'); ?>
                </div>
                <?php if ('div' != $args['style']): ?>
                <div id="div-comment-<?php echo get_comment_ID(); ?>" class="comment-content">
                    <?php endif; ?>
                    <div class="comment-text">
                        <?php comment_text(); ?>
                    </div>
                    <div class="reply-content">
                        <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                    </div>
                    <?php if ('div' != $args['style']): ?>
                </div>
            <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('bianco_single_post_thumbnail')) {
    function bianco_single_post_thumbnail()
    {
        if (has_post_thumbnail()) : ?>
            <div class="post-thumb">
                <?php the_post_thumbnail('full'); ?>
                <div class="date">
                    <?php 
                        $archive_year = get_the_time('Y');
                        $archive_month = get_the_time('m');
                        $archive_day = get_the_time('d');
                    ?>
                    <a href="<?php echo get_day_link($archive_year, $archive_month, $archive_day); ?>">
                        <span class="day"><?php echo esc_html($archive_day); ?></span>
                        <span class="month"><?php echo get_the_time('M'); ?></span>
                    </a>
                </div>
            </div>
        <?php endif;
    }
}

if (!function_exists('bianco_post_thumbnail')) {
    function bianco_post_thumbnail()
    {
        $_width = apply_filters('bianco_post_thumbnail_width','420');
        $_heigth = apply_filters('bianco_post_thumbnail_height','284');
        if (has_post_thumbnail()) : ?>
            <div class="post-thumb">
                <?php $image_thumb = apply_filters('ovic_resize_image', get_post_thumbnail_id(), $_width, $_heigth, true, true); ?>
                <?php $content = '<a href="' . get_permalink() . '"><figure>' . $image_thumb['img'] . '</figure></a>'; ?>
                <?php echo wp_specialchars_decode($content); ?>
                <div class="date">
                    <?php $archive_year = get_the_time('Y'); ?>
                    <?php $archive_month = get_the_time('m'); ?>
                    <?php $archive_day = get_the_time('d'); ?>
                    <a href="<?php echo get_day_link($archive_year, $archive_month, $archive_day); ?>">
                        <span class="day"><?php echo esc_html($archive_day); ?></span>
                        <span class="month"><?php echo get_the_time('M'); ?></span>
                    </a>
                </div>
            </div>
        <?php endif;
    }
}

if (!function_exists('bianco_paging_nav')) {
    function bianco_paging_nav()
    {
        global $wp_query;
        $max = $wp_query->max_num_pages;
        // Don't print empty markup if there's only one page.
        if ($max >= 2) {
            echo get_the_posts_pagination(array(
                    'screen_reader_text' => '&nbsp;',
                    'before_page_number' => '',
                    'prev_text' => esc_html__('Previous Page', 'bianco'),
                    'next_text' => esc_html__('Next Page', 'bianco'),
                )
            );
        }
    }
}

if (!function_exists('bianco_post_title')) {
    function bianco_post_title()
    {
        ?>
        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php
    }
}

if (!function_exists('bianco_single_post_title')) {
    function bianco_single_post_title()
    {   ?>
        <h2 class="post-title single-post"><?php the_title(); ?></h2>
        <?php
    }
}

if (!function_exists('bianco_post_excerpt')) {
    function bianco_post_excerpt()
    {
        ?>
        <div class="post-content">
            <p><?php echo wp_trim_words(apply_filters('the_excerpt', get_the_excerpt()), 17, '...'); ?></p>
        </div>
        <?php
    }
}

if (!function_exists('bianco_post_single_content')) {
    function bianco_post_single_content()
    {
        ?>
        <div class="post-content">
            <?php
            /* translators: %s: Name of current post */
            the_content(sprintf(
                    esc_html__('Continue reading %s', 'bianco'),
                    the_title('<span class="screen-reader-text">', '</span>', false)
                )
            );
            wp_link_pages(array(
                    'before' => '<div class="post-pagination"><span class="title">' . esc_html__('Pages:', 'bianco') . '</span>',
                    'after' => '</div>',
                    'link_before' => '<span>',
                    'link_after' => '</span>',
                )
            );
            ?>
        </div>
        <?php
    }
}

if (!function_exists('bianco_post_sticky')) {
    function bianco_post_sticky()
    {
        if (is_sticky()) : ?>
            <div class="sticky-post"><i class="fa fa-flag"></i>
                <?php echo esc_html__(' Sticky', 'bianco'); ?>
            </div>
        <?php endif;
    }
}

if (!function_exists('bianco_post_author')) {
    function bianco_post_author()
    {
        ?>
        <div class="post-author">
            <?php echo get_avatar(get_the_author_meta('user_email'), 28); ?>
            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>"><?php the_author() ?></a>
        </div>
        <?php
    }
}

if (!function_exists('bianco_post_tags')) {
    function bianco_post_tags(){
        $tags_list = get_the_tag_list( '', __( ', ', 'bianco' ) );
        $categories_list = get_the_category_list( __( ', ', 'bianco' ) );
        if ( $tags_list ) {
            $tags_list_class = $categories_list ? 'post-tags has-categories': 'post-tags';
            printf( '<div class="%1$s"><span class="title-item">%2$s</span>%3$s</div>', $tags_list_class, __( 'Tags:', 'bianco' ), $tags_list ); // WPCS: XSS OK.
        }
        if ( $categories_list ) {
            printf( '<div class="post-tags"><span class="title-item">%1$s</span>%2$s</div>', __('Category:','bianco'), $categories_list ); // WPCS: XSS OK.
        }
    }
}

if(!function_exists('bianco_tpl_post_comment')){
    function bianco_tpl_post_comment(){ ?>
        <?php $link_comment = get_permalink().'#comments'?>
        <a class="post-comment" href="<?php echo esc_url($link_comment); ?>">
            <span class="icon"><i class="fa fa-comment"></i></span>
            <span class="count"><?php echo esc_html(get_comments_number()); ?></span>
        </a>
        <?php
    }
}

if(!function_exists('bianco_tpl_share_post')){
    function bianco_tpl_share_post(){
        $enable_share_buttons = Bianco_Functions::get_option('bianco_used_socials_media',0);
        if(!$enable_share_buttons) return '';
        ?>
        <div class="post-item-share">
            <a href="#" class="icon"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
            <div class="box-content">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>&display=popup">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="https://twitter.com/home?status=<?php the_permalink(); ?>" >
                    <i class="fa fa-twitter"></i>
                </a>
                <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" >
                    <i class="fa fa-google-plus"></i>
                </a>
                <a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url( get_the_post_thumbnail_url('full')); ?>&amp;description=<?php echo urlencode( get_the_excerpt() ); ?>" >
                    <i class="fa fa-pinterest"></i>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>&amp;summary=<?php echo urlencode( get_the_excerpt() ); ?>&amp;source=<?php echo urlencode( get_bloginfo( 'name' ) ); ?>" >
                    <i class="fa fa-linkedin"></i>
                </a>
            </div>
        </div>
        <?php
    }
}

if(!function_exists('bianco_tpl_count_like')){
    function bianco_tpl_count_like(){
        do_action('ovic_simple_likes_button',get_the_ID());
    }
}

if (!function_exists('bianco_post_info')) {
    function bianco_post_info()
    { ?>
        <div class="post-info">
            <?php
            /**
             * Functions hooked into bianco_post_info_content action
             *
             * @hooked bianco_post_author - 10
             * @hooked bianco_tpl_post_comment - 15
             * @hooked bianco_tpl_count_like - 20
             * @hooked bianco_tpl_share_post - 25
             */
            do_action('bianco_post_info_content');
            ?>
        </div>
        <?php
    }
}

if (!function_exists('bianco_post_readmore')) {
    function bianco_post_readmore()
    {
        ?>
        <div class="group-read-more">
            <a class="read-more" href="<?php the_permalink(); ?>">
                <?php echo esc_html__('Continue Reading', 'bianco'); ?>
            </a>
        </div>
        <?php
    }
}

if (!function_exists('bianco_post_comment')) {
    function bianco_post_comment()
    {
        ?>
        <div class="comment-count">
            <?php comments_number(
                esc_html__('0', 'bianco'),
                esc_html__('1', 'bianco'),
                esc_html__('%', 'bianco')
            );
            ?>
        </div>
        <?php
    }
}

if(!function_exists('bianco_show_author_bios')){
    function bianco_show_author_bios(){ ?>
        <?php $author_desc = get_the_author_meta('description'); ?>
        <?php if($author_desc){ ?>
        <div class="author-info">
            <div class="author-avatar">
                <?php $author_bio_avatar_size = apply_filters( 'bianco_author_bio_avatar_size', 100 ); ?>
                <?php echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size ); ?>
            </div><!-- .author-avatar -->

            <div class="author-description">
                <h3 class="author-title"><?php echo get_the_author(); ?></h3>
                <p class="author-bio"><?php echo esc_html($author_desc); ?></p>
                <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                    <?php printf( esc_html__( 'View all posts by %s', 'bianco' ), get_the_author() ); ?>
                </a>
            </div><!-- .author-description -->
        </div><!-- .author-info -->
        <?php } ?>
        <?php
    }
}

if(!function_exists('bianco_move_comment_field_to_bottom')){
    function bianco_move_comment_field_to_bottom( $fields ) {
        $comment_field = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;
        return $fields;
    }
}

if (!function_exists('bianco_header_currency')) {
    function bianco_header_currency()
    {
        $languages = apply_filters('wpml_active_languages', NULL, 'skip_missing=0');
        $result ='';
        if (!empty($languages)) {
            $result .= do_shortcode('[currency_switcher format="%code%" switcher_style="wcml-dropdown"]');
        }
        echo wp_specialchars_decode($result);
    }
}