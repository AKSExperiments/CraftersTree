<?php
/*
Name: Blog Style 01
Slug: content-blog-style-1
*/

$classes = array('post-item blog-grid grid date-in-front right-info');
?>
<article <?php post_class($classes); ?>>
	<?php
	/**
	* Functions hooked into bianco_post_content action
	*
     * @hooked bianco_post_thumbnail          - 10
     * @hooked bianco_post_title              - 15
     * @hooked bianco_post_sticky             - 20
     * @hooked bianco_post_info               - 25
     * @hooked bianco_post_excerpt            - 30
     * @hooked bianco_post_readmore           - 35
	*/
	do_action( 'bianco_post_content' );
	?>
</article>

