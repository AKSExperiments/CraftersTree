<?php
$bianco_used_related_posts = Bianco_Functions::get_option('bianco_used_related_posts',false);
if($bianco_used_related_posts){
	$args = array(
		'post__not_in' => array($post->ID),
		'category__in' => wp_get_post_categories($post->ID),
		'posts_per_page'=> 5,
	);
	$related = new wp_query( $args );
	if($related->have_posts()){
		$bianco_related_title = Bianco_Functions::get_option('bianco_related_title','Post you’d might like');
		$bianco_single_related_ls_items = Bianco_Functions::get_option('bianco_single_related_ls_items',2);
		$bianco_single_related_lg_items = Bianco_Functions::get_option('bianco_single_related_lg_items',2);
		$bianco_single_related_md_items = Bianco_Functions::get_option('bianco_single_related_md_items',2);
		$bianco_single_related_sm_items = Bianco_Functions::get_option('bianco_single_related_ms_items',2);
		$bianco_single_related_xs_items = Bianco_Functions::get_option('bianco_single_related_xs_items',2);
		$bianco_single_related_ts_items = Bianco_Functions::get_option('bianco_single_related_ts_items',1);

		$data_responsive = array(
			array(
				'breakpoint' => 1500,
				'settings' => array("slidesToShow"=> $bianco_single_related_ls_items)
			),
			array(
				'breakpoint' => 1200,
				'settings' => array("slidesToShow"=> $bianco_single_related_lg_items)
			),
			array(
				'breakpoint' => 992,
				'settings' => array("slidesToShow"=> $bianco_single_related_md_items)
			),
			array(
				'breakpoint' => 768,
				'settings' => array("slidesToShow"=> $bianco_single_related_sm_items)
			),
			array(
				'breakpoint' => 480,
				'settings' => array("slidesToShow"=> $bianco_single_related_xs_items)
			),
			array(
				'breakpoint' => 380,
				'settings' => array("slidesToShow"=> $bianco_single_related_ts_items)
			)
		);
		$classes = array('post-item blog-grid grid date-in-front');
		$classes[] = 'decrease-info';

		?>
		<div class="wrap-related-box">
			<h3 class="title-box"><span><?php echo esc_html($bianco_related_title); ?></span></h3>
			<div class="owl-slick" 
				data-slick='{"arrows":false,"slidesMargin":30,"dots":false,"infinite":true,"slidesToShow":<?php echo esc_js($bianco_single_related_ls_items); ?>,"speed":300}'
				data-responsive="<?php echo esc_js(json_encode($data_responsive)); ?>">
				<?php while ($related->have_posts()) : ?>
				<?php $related->the_post();  ?>
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
					do_action( 'bianco_post_content' ); 
					?>
	            </article>
				<?php endwhile; ?>
			</div>
		</div>
		<?php
        wp_reset_postdata();
	}
	$next_link = get_next_post_link();
	$previous_link = get_previous_post_link();
	?>
    <?php if($next_link || $previous_link):  ?>
	<div class="direction-post clearfix">
        <?php if($previous_link): ?>
		<div class="dir-item prev-item">
			<span><?php esc_html_e('older','bianco');?></span>
			<?php previous_post_link('%link'); ?>
			<a class="mav-link" href="<?php echo esc_url($previous_link); ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
		</div>
        <?php endif;  ?>
        <?php if($next_link): ?>
		<div class="dir-item next-item">
			<span><?php esc_html_e('newer','bianco');?></span>
			<?php next_post_link('%link'); ?>
			<a class="mav-link" href="<?php echo esc_url($next_link); ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
		</div>
        <?php endif;  ?>
	</div>
    <?php endif;  ?>
	<?php
}