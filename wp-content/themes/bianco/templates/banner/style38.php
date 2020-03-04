<?php
$image              = !empty( $atts['image']) ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array();
$link               = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$target             = bianco_get_target_link($link);
$html_group_texts   = '';

if ( !empty( $atts['text_1'] ) )
    $html_group_texts = '<a class="cate-link" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ) . '  ><b>' . esc_html( $atts['text_1'] ) . '</b></a>';
?>
<div class="inner-content">
    <?php if($image['url']): ?>
        <div class="thumb-banner">
            <a class="wrap-img" href="<?php echo esc_url( $link['url'] ); ?>"><?php echo wp_specialchars_decode($image['img']); ?></a>
        </div>
    <?php endif; ?>
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>
