<?php
/**
 * Ovic Footer Builder setup
 *
 * @author   KHANH
 * @category API
 * @package  Ovic_Footer_Builder
 * @since    1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Ovic Footer Builder setup
 *
 * @Active: add_theme_support( 'ovic-footer-builder' );
 */
if ( !class_exists( 'Ovic_Footer_Builder' ) ) {
	class Ovic_Footer_Builder
	{
		public function __construct()
		{
			if ( is_admin() ) {
				add_action( 'init', array( &$this, 'post_type' ), 999 );
				add_filter( 'ovic_config_customize_sections', array( $this, 'add_theme_options' ) );
				add_filter( 'ovic_config_customize_sections_v2', array( $this, 'add_theme_options' ) );
			} else {
				add_action( 'ovic_footer_content', array( $this, 'ovic_footer_content' ) );
				add_filter( 'ovic_main_custom_css', array( $this, 'ovic_shortcodes_custom_css' ) );
			}
		}

		public static function ovic_get_footer_preview()
		{
			$footer_preview = array();
			$args           = array(
				'post_type'      => 'footer',
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
			);
			$posts          = get_posts( $args );
			foreach ( $posts as $post ) {
				setup_postdata( $post );
				$footer_preview[$post->ID] = array(
					'title'   => $post->post_title,
					'preview' => wp_get_attachment_image_url( get_post_thumbnail_id( $post->ID ), 'full' ),
				);
			}
			wp_reset_postdata();

			return $footer_preview;
		}

		function add_theme_options( $options )
		{
			$options['footer']['fields'] = array(
				'ovic_footer_template' => array(
					'id'      => 'ovic_footer_template',
					'type'    => 'select_preview',
					'title'   => esc_html__( 'Footer Template', 'bianco-toolkit' ),
					'desc'    => esc_html__( 'Select a Footer layout in page', 'bianco-toolkit' ),
					'options' => $this->ovic_get_footer_preview(),
				),
			);

			return apply_filters( 'ovic_footer_builder_option', $options );
		}

		public function get_footer_option()
		{
			$footer_options  = apply_filters( 'ovic_get_option', 'ovic_footer_template', '' );
			$overide_options = apply_filters( 'ovic_overide_footer_template', '' );
			if ( $overide_options != '' )
				$footer_options = $overide_options;

			return $footer_options;
		}

		function ovic_footer_content()
		{
			$footer_options = $this->get_footer_option();
			$footer_content = '';
			$class          = array( 'footer ovic-footer' );
			$args           = array(
				'post_type'      => 'footer',
				'posts_per_page' => 1,
			);
			if ( $footer_options ) {
				$args['p'] = $footer_options;
			}
			$query = new WP_Query( $args );
			if ( $query->have_posts() ):
				while ( $query->have_posts() ): $query->the_post();
					$post_id        = get_post( get_the_ID() );
					$content        = $post_id->post_content;
					$content        = apply_filters( 'the_content', $content );
					$content        = str_replace( ']]>', ']]>', $content );
					$footer_content = '<div class="container">' . wp_specialchars_decode( $content ) . '</div>';
				endwhile;
				wp_reset_postdata();
			endif;
			ob_start(); ?>
            <footer class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
				<?php
				do_action( 'ovic_before_footer_content' );
				echo wp_specialchars_decode( $footer_content );
				do_action( 'ovic_after_footer_content' );
				?>
            </footer>
			<?php
			echo apply_filters( 'ovic_filter_content_footer', ob_get_clean(), $footer_content, $class );
		}

		function ovic_shortcodes_custom_css( $css )
		{
			$post_custom_css = array();
			$footer_options  = $this->get_footer_option();
			if ( $footer_options != '' ) {
				$post_custom_css[] = get_post_meta( $footer_options, '_wpb_post_custom_css', true );
				$post_custom_css[] = get_post_meta( $footer_options, '_wpb_shortcodes_custom_css', true );
				$post_custom_css[] = get_post_meta( $footer_options, '_Ovic_Shortcode_custom_css', true );
				$post_custom_css[] = get_post_meta( $footer_options, '_Ovic_VC_Shortcode_Custom_Css', true );
				if ( count( $post_custom_css ) > 0 ) {
					$css .= implode( ' ', $post_custom_css );
				}
			}

			return $css;
		}

		function post_type()
		{
			/* Footer */
			$args = array(
				'labels'              => array(
					'name'               => __( 'Footers', 'bianco-toolkit' ),
					'singular_name'      => __( 'Footers', 'bianco-toolkit' ),
					'add_new'            => __( 'Add New', 'bianco-toolkit' ),
					'add_new_item'       => __( 'Add new footer', 'bianco-toolkit' ),
					'edit_item'          => __( 'Edit footer', 'bianco-toolkit' ),
					'new_item'           => __( 'New footer', 'bianco-toolkit' ),
					'view_item'          => __( 'View footer', 'bianco-toolkit' ),
					'search_items'       => __( 'Search template footer', 'bianco-toolkit' ),
					'not_found'          => __( 'No template items found', 'bianco-toolkit' ),
					'not_found_in_trash' => __( 'No template items found in trash', 'bianco-toolkit' ),
					'parent_item_colon'  => __( 'Parent template item:', 'bianco-toolkit' ),
					'menu_name'          => __( 'Footer Builder', 'bianco-toolkit' ),
				),
				'hierarchical'        => false,
				'description'         => __( 'To Build Template Footer.', 'bianco-toolkit' ),
				'supports'            => array(
					'title',
					'editor',
					'thumbnail',
					'revisions',
				),
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => 'ovic-dashboard',
				'menu_position'       => 4,
				'show_in_nav_menus'   => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'query_var'           => true,
				'can_export'          => true,
				'rewrite'             => false,
				'capability_type'     => 'page',
			);
			register_post_type( 'footer', $args );
		}
	}

	new Ovic_Footer_Builder();
}