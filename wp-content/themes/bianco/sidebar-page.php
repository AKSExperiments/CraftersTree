<?php
$bianco_page_used_sidebar = Bianco_Functions::get_post_meta( get_the_ID(), 'ovic_page_used_sidebar', 'widget-area' );
if ( is_active_sidebar( $bianco_page_used_sidebar ) ) : ?>
    <div id="widget-area" class="widget-area">
		<?php dynamic_sidebar( $bianco_page_used_sidebar ); ?>
    </div><!-- .widget-area -->
<?php endif;
