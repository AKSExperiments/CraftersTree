<?php
$image = $atts['image'] ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array( 
	'img' => '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="270" height="210" alt="bianco placeholder">');
$link             	= !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$html_group_texts 	= '';
if ( $link['title'] ) {
    $target = bianco_get_target_link($link);
	$html_group_texts .= '<h3 class="text-1"><a class="banner-link" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ) . '>' . esc_html( $link['title'] ) . '</a></h3>';
}
?>
<div class="inner-content">
    <div class="thumb-banner">
        <a class="wrap-img" href="<?php echo esc_url( $link['url'] ); ?>"><?php echo wp_specialchars_decode( $image['img'] ); ?></a>
    </div>
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>