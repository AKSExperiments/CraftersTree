<?php do_action( 'bianco_before_single_blog_content' ); ?>
<article <?php post_class( 'post-item post-single' ); ?>>
	<?php
		/**
		 * Functions hooked into bianco_single_post_content action
		 *
		 * @hooked bianco_single_post_thumbnail   - 10
		 * @hooked bianco_post_info               - 15
		 * @hooked bianco_post_thumbnail          - 20
		 * @hooked bianco_post_single_content     - 25
		 * @hooked bianco_show_author_bios        - 30
		 */
		
		do_action( 'bianco_single_post_content' ); 
	?>
</article>
<div class="post-meta clearfix ">
	<?php 
		/**
		 * Functions hooked into bianco_single_post_content action
		 *
		 * @hooked bianco_show_author_bios        - 10
		 * @hooked bianco_post_tags               - 15
		 * @hooked bianco_post_loop_share_button  - 20
		 */
		do_action( 'bianco_after_single_blog_content' );
	?>
</div>
<?php
get_template_part( 'templates/blog/blog', 'related' );