<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Bianco
 * @since 1.0
 * @version 1.0
 */

$enable_back_to_top = Bianco_Functions::get_option( 'enable_back_to_top', 0 );
if ( $enable_back_to_top == 1 ): ?>
    <a href="#" class="backtotop"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a>
<?php endif;
    do_action( 'ovic_footer_content' );
    do_action( 'bianco_footer' );
    wp_footer();
?>
</body>
</html>