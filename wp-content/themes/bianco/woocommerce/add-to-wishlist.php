<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */
if ( !defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
global $product;
?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr( $product_id ) ?>">
	<?php if ( !( $disable_wishlist && !is_user_logged_in() ) ): ?>
        <div class="yith-wcwl-add-button <?php if ( $exists && !$available_multi_wishlist ) {
			echo esc_attr( 'hide' );
		} else {
			echo esc_attr( 'show' );
		} ?>"
             style="<?php if ( $exists && !$available_multi_wishlist ) {
				 echo 'display:none';
			 } else {
				 echo 'display:block';
			 } ?>">

			<?php yith_wcwl_get_template( 'add-to-wishlist-' . $template_part . '.php', $atts ); ?>

        </div>

        <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
            <span class="feedback"><?php echo esc_html( $product_added_text ) ?></span>
            <a href="<?php echo esc_url( $wishlist_url ) ?>" rel="nofollow">
				<?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text ) ?>
            </a>
        </div>

        <div class="yith-wcwl-wishlistexistsbrowse <?php if ( $exists && !$available_multi_wishlist ) {
			echo esc_attr( 'show' );
		} else {
			echo esc_attr( 'hide' );
		} ?>"
             style="<?php if ( $exists && !$available_multi_wishlist ) {
				 echo 'display:block';
			 } else {
				 echo 'display:none';
			 } ?>">
            <span class="feedback"><?php echo esc_html( $already_in_wishslist_text ) ?></span>
            <a href="<?php echo esc_url( $wishlist_url ) ?>" rel="nofollow">
				<?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text ) ?>
            </a>
        </div>

        <div style="clear:both"></div>
        <div class="yith-wcwl-wishlistaddresponse"></div>
	<?php else: ?>
        <a href="<?php echo esc_url( add_query_arg( array( 'wishlist_notice' => 'true', 'add_to_wishlist' => $product_id ), get_permalink( wc_get_page_id( 'myaccount' ) ) ) ) ?>"
           rel="nofollow" class="<?php echo str_replace( 'add_to_wishlist', '', $link_classes ) ?>">
			<?php echo esc_html( $icon ) ?>
			<?php echo esc_html( $label ) ?>
        </a>
	<?php endif; ?>
</div>