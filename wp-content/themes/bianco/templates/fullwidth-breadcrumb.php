<?php
/**
 * Template Name: Wide side includes breadcrumb
 *
 * @package WordPress
 * @subpackage Bianco
 * @since Bianco 1.0
 */
get_header();
?>
	<div class="fullwidth-template">
		<?php do_action( 'bianco_show_hero_section' ); ?>
		<div class="bianco-wrap-breadcrumb wrap-breadcrumb">
            <div class="container">
                <?php do_action( 'ovic_breadcrumb',array('show_browse' =>false)); ?>
            </div>
        </div>
		<div class="container">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</div>
	</div>
<?php
get_footer();