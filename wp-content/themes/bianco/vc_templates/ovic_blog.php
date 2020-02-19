<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Blog"
 */
if ( !class_exists( 'Shortcode_Ovic_Blog' ) ) {
	class Shortcode_Ovic_Blog extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_blog';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_blog', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css = "";

			return apply_filters( 'Shortcode_Ovic_Blog_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts  = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_blog', $atts ) : $atts;
			$style = $thumb_size_custom = '';
            $title_type = 'title-center';
            $thumb_size = 'default';
			extract( $atts );
			$css_class   = array( 'ovic-blog ovic-blog-list-style1' );
			$css_class[] = $title_type;
			$css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_blog', $atts );
			/* START */
			$class_slide   = array( 'owl-slick blog-list-owl equal-container better-height ovic-slide' );
			$class_slide[] = $atts['owl_navigation_style'];
			$class_slide[] = $atts['owl_rows_space'];
			$owl_settings  = Ovic_VC_Params::generate_slide_attr( $atts['carousel'] );
			$args          = array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'suppress_filter'     => true,
				'orderby'             => $atts['orderby'],
				'order'               => $atts['order'],
			);
			if ( $atts['target'] == 'popularity' ) {
				$args_loop['meta_key'] = 'ovic_post_views_count';
				$args_loop['orderby']  = 'meta_value_num';
			}
			if ( $atts['target'] == 'post' ) {
				$args['post__in']       = explode( ',', $atts['ids'] );
				$args['posts_per_page'] = -1;
			} else {
				$args['posts_per_page'] = $atts['limit'];
				if ( $atts['category'] != '' ) {
					$args['category_name'] = $atts['category'];
				}
			}
			if($thumb_size != 'default'){
			    $thumbnail_width = 370;
                $thumbnail_height = 250;
                if($thumb_size == 'size-01'){
                    $thumbnail_width = 300;
                    $thumbnail_height = 250;
                }elseif(!empty($thumb_size_custom)) {
                    if ( preg_match_all( '/(\d+)x(\d+)/', trim($thumb_size_custom), $sizes ) ) {
                        $thumbnail_width = isset( $sizes[1][0] ) ? $sizes[1][0] : $thumbnail_width;
                        $thumbnail_height = isset( $sizes[2][0] ) ? $sizes[2][0] : $thumbnail_height;
                    }
                }
                add_filter( 'bianco_post_thumbnail_width', function () use($thumbnail_width){ return $thumbnail_width; } );
                add_filter( 'bianco_post_thumbnail_height', function () use($thumbnail_height){ return $thumbnail_height; } );
            }
			$query = new WP_Query( $args );
			if($atts['blog_style']=='style-3'){
                remove_action('bianco_post_content', 'bianco_post_readmore', 35);
                remove_action('bianco_post_content','bianco_post_excerpt',30);
            }
			ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
                <?php if ( $atts['blog_title'] ): ?>
                    <h3 class="ovic-title">
                        <span class="title"><?php echo esc_html( $atts['blog_title'] ); ?></span>
                    </h3>
                <?php endif; ?>
                <?php if ( $query->have_posts() ) : ?>
                    <div class="<?php echo esc_attr( implode( ' ', $class_slide ) ); ?>" <?php echo esc_attr( $owl_settings ); ?>>
                        <?php
                        while ( $query->have_posts() ) :
                            $query->the_post();
                            get_template_part( "templates/blog/blog-style/content-blog", "{$atts['blog_style']}" );
                        endwhile;
                        ?>
                    </div>
                <?php else : ?>
                    <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>
            </div>
			<?php

			$html = ob_get_clean();
            remove_all_filters( 'bianco_post_thumbnail_width' );
            remove_all_filters( 'bianco_post_thumbnail_height' );
            wp_reset_postdata();
            if($atts['blog_style']=='style-3'){
                add_action('bianco_post_content', 'bianco_post_readmore', 35);
                add_action('bianco_post_content','bianco_post_excerpt',30);
            }
			return apply_filters( 'Shortcode_Ovic_Blog', $html, $atts, $content );
		}
	}

	new Shortcode_Ovic_Blog();
}