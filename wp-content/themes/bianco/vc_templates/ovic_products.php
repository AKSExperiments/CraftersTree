<?php
if ( !defined( 'ABSPATH' ) ) {
    die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Products"
 * @version 1.0.0
 */
if ( !class_exists( 'Shortcode_Ovic_Products' ) ) {
    class Shortcode_Ovic_Products extends Ovic_VC_Shortcode
    {
        /**
         * Shortcode name.
         *
         * @var  string
         */
        public $shortcode = 'ovic_products';

        static public function add_css_generate( $atts )
        {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_products', $atts ) : $atts;
            $productsliststyle = 'owl';
            $title_bg ='#323232';
            extract( $atts );
            $css = '';
            if ( $productsliststyle != 'grid' && $productsliststyle != 'wgt' ) {
                $css = "
                .{$atts['ovic_vc_custom_id']} .ovic-title:not(.sub-title) .text::after,
                .{$atts['ovic_vc_custom_id']} .ovic-title .title::after{
                    background-color: {$atts['title_underline_color']}
                    }
                .{$atts['ovic_vc_custom_id']} .ovic-title:not(.sub-title) .text::before,
                .{$atts['ovic_vc_custom_id']} .ovic-title .title::before{
                    border-right-color: {$atts['title_underline_color']};
                    border-bottom-color: {$atts['title_underline_color']};
                }";
            }elseif ($productsliststyle == 'wgt'){
                $css = "
                    .{$atts['ovic_vc_custom_id']} .ovic-title .title{
                        background-color: {$title_bg}
                    }
                }";
            }
            return apply_filters( 'Ovic_Shortcode_Products_css', $css, $atts );
        }

        public function output_html( $atts, $content = null )
        {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_products', $atts ) : $atts;
            $productsliststyle = 'owl';
            $product_style     = 'style-1';
            $owl_navigation_style = 'nav-default';
            $lbl_prev_nav = 'Previous';
            $lbl_next_nav = 'Next';
            $nav_custom = '';
            $owl_rows_space = 'rows-space-0';
            $bg_image_html = $bg_image = '';
            extract( $atts );
            $css_class   = array( 'ovic-products ovic-products-shortcode' );
            $css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_products', $atts );
            /* Product Size */
            if ( $atts['product_image_size'] ) {
                if ( $atts['product_image_size'] == 'custom' ) {
                    $thumb_width  = $atts['product_custom_thumb_width'];
                    $thumb_height = $atts['product_custom_thumb_height'];
                } else {
                    list( $width, $height ) = explode( "x", $atts['product_image_size'] );
                    $thumb_width  = $width;
                    $thumb_height = $height;
                }
                if ( $thumb_width > 0 ) {
                    add_filter( 'ovic_shop_product_thumb_width', function () use ( $thumb_width ) { return $thumb_width; } );
                }
                if ( $thumb_height > 0 ) {
                    add_filter( 'ovic_shop_product_thumb_height', function () use ( $thumb_height ) { return $thumb_height; } );
                }
            }
            $products           = apply_filters( 'ovic_getProducts', $atts );
            $product_item_class = array( 'product-item', $atts['target'] );
            $product_list_class = array( 'response-products' );

            if($product_style == 'style-8'){
                /**
                 * clone content of product style 5 to style 8
                 */
                $product_style  = 'style-5';
                $css_class[]    = 'clone_five_to_eight';
            }
            if($product_style == 'style-12'){
                /**
                 * clone content of product style 2 to style 12
                 */
                $product_style          = 'style-2';
                $product_item_class[]   = 'clone-two-2-twelve';
            }
            $owl_settings       = '';
            $add_more_items     = '';
            switch ($productsliststyle){
                case 'grid':
                    if(!empty($grid_distance)){
                        $css_class[] = $grid_distance;
                    }
                    $product_item_class[] = $product_style;
                    $product_list_class[] = 'product-list-grid row auto-clear equal-container better-height ';
                    $product_item_class[] = Ovic_VC_Params::generate_grid_attr( $atts['bootstrap'] );
                    break;
                case 'owl':
                    $css_class[]          = $atts['owl_layout'];
                    $css_class[]          = 'nav-type-'.$atts['owl_navigation_style'];
                    $product_item_class[] = $product_style;
                    $product_list_class[] = $atts['owl_navigation_style'];
                    $product_list_class[] = 'product-list-owl owl-slick ovic-products equal-container better-height ovic-slide';
                    $product_item_class[] = $atts['owl_rows_space'];
                    if($owl_navigation_style == 'nav-bottom-label'){
                        $nav_custom='{';
                        if($lbl_next_nav){
                            $nav_custom .=  '"next":"'.$lbl_next_nav.'",';
                        }
                        if($lbl_prev_nav){
                            $nav_custom .=  '"pre":"'.$lbl_prev_nav.'"';
                        }
                        $nav_custom .='}';
                    }
                    $owl_settings         = Ovic_VC_Params::generate_slide_attr( $atts['carousel'] );
                    $link                 = !empty( $atts['btn_link'] ) ? vc_build_link( $atts['btn_link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
                    $target               = '';
                    if ( $link['target'] )
                        $target = 'target="' . $link["target"] . '"';
                    if ( $link['title'] ) {
                        $add_more_items = '<div class="add-more-item"><a class="banner-link" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ) . '>' . esc_html( $link['title'] ) . '</a></div>';
                    }
                    break;
                case 'combined':
                    $ar_responsive        = array(
                        array( 'breakpoint' => 1500, 'settings' => array( 'slidesToShow' => 1, 'slidesMargin' => 0  ) ),
                        array( 'breakpoint' => 1200, 'settings' => array( 'slidesToShow' => 1, 'slidesMargin' => 0  ) ),
                        array( 'breakpoint' => 992,  'settings' => array( 'slidesToShow' => 1, 'slidesMargin' => 0  ) ),
                        array( 'breakpoint' => 767,  'settings' => array( 'slidesToShow' => 2, 'slidesMargin' => 10 ) ),
                        array( 'breakpoint' => 650,  'settings' => array( 'slidesToShow' => 1, 'slidesMargin' => 0  ) ),
                        array( 'breakpoint' => 480,  'settings' => array( 'slidesToShow' => 1, 'slidesMargin' => 0  ) ),
                    );
                    $arr_slick            = array(
                        'arrows'       => 'true',
                        'dots'         => 'false',
                        'infinite'     => 'false',
                        'speed'        => '300',
                        'slidesToShow' => '1',
                        'rows'         => '1',
                        'responsive'   => $ar_responsive,
                    );
                    $data_slick           = wp_json_encode( $arr_slick );
                    $owl_settings         = " data-slick='{$data_slick}' ";
                    $product_list_class[] = 'product-owl owl-slick equal-container nav-style1';
                    $product_style        = 'style-3';
                    $title                = $atts['title'];
                    $atts['title']        = '';
                    remove_action( 'bianco_show_product_group_flash', 'bianco_woocommerce_group_flash', 10 );
                    add_filter( 'ovic_shop_product_thumb_width', function(){ return 140; } );
                    add_filter( 'ovic_shop_product_thumb_height', function(){ return 140; } );
                    add_filter( 'bianco_sale_product_title_template', function() use ( $title ) { return $title; });
                    break;
                case 'wgt':
                    $owl_settings         = '';
                    $product_style        = 'style-wgt';
                    break;
                case 'onbanner':
                    $css_class[]          = 'nav-type-'.$owl_navigation_style;
                    $product_item_class[] = $product_style;
                    $product_list_class[] = $owl_navigation_style;
                    $product_list_class[] = 'product-list-owl owl-slick ovic-products equal-container better-height ovic-slide';
                    $product_item_class[] = $owl_rows_space;
                    if($owl_navigation_style == 'nav-bottom-label'){
                        $nav_custom='{';
                        if($lbl_next_nav){
                            $nav_custom .=  '"next":"'.$lbl_next_nav.'",';
                        }
                        if($lbl_prev_nav){
                            $nav_custom .=  '"pre":"'.$lbl_prev_nav.'"';
                        }
                        $nav_custom .='}';
                    }
                    $owl_settings         = Ovic_VC_Params::generate_slide_attr( $atts['carousel'] );
                    if($bg_image){
                        $_img_temp = apply_filters( 'ovic_resize_image', $bg_image, false, false, true, true );
                        $_stylese = "height:{$_img_temp['height']}px; background: url({$_img_temp['url']})";
                        $bg_image_html = '<div class="bg_underground" style="'.esc_attr($_stylese).'">';
                        $bg_image_html .= '</div>';
                    }
                    $css_class[] = 'bianco-product-right-overflow';
                    break;
            }
            $css_class[] = "product-layout-{$product_style}";

            ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
                <?php if ( $atts['owl_sub_title'] ): ?>
                    <span class="sub-title"><span class="text"><?php echo esc_html( $atts['owl_sub_title'] ); ?></span></span>
                <?php endif; ?>
                <?php if ( $atts['title'] ): ?>
                    <h3 class="ovic-title"><span class="title"><?php echo esc_html( $atts['title'] ); ?></span></h3>
                <?php endif; ?>
                <?php echo wp_specialchars_decode($bg_image_html); ?>
                <?php if ( $products->have_posts() ) : ?>
                    <div class="<?php echo esc_attr( implode( ' ', $product_list_class ) ); ?>"
                        <?php echo esc_attr( $owl_settings ); ?> <?php if($productsliststyle == 'owl') : ?> data-custom_nav="<?php echo esc_js($nav_custom); ?>" <?php endif;?> >
                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                            <?php $product_item_class = apply_filters( 'ovic_class_item_shortcode_product', $product_item_class, $atts ); ?>
                            <div <?php wc_product_class( $product_item_class ); ?>>
                                <?php wc_get_template_part( "product-styles/content-product-{$product_style}" );?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p>
                        <strong><?php esc_html_e( 'No Product', 'bianco' ); ?></strong>
                    </p>
                <?php endif; ?>
                <?php
                echo wp_specialchars_decode( $add_more_items );
                if ( $atts['enable_loadmore'] == 'yes' ) :
                    $param_id = "bianco_shortcode_product_{$atts['ovic_vc_custom_id']}";
                    $param_data = json_encode( $atts );
                    $max_page = isset( $products->max_num_pages ) ? $products->max_num_pages : 1;
                    ?>
                    <div class="button-products">
                        <script type='text/javascript'>
                            /* <![CDATA[ */
                            <?php echo "var $param_id = $param_data"; ?>
                            /* ]]> */
                        </script>
                        <a href="#" class="button load_more-products"
                           data-id="<?php echo esc_attr( $atts['ovic_vc_custom_id'] ); ?>"
                           data-max_page="<?php echo esc_attr( $max_page ); ?>"
                           data-next_page="2">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <?php echo __( 'LOAD MORE PRODUCTS', 'bianco' ); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            remove_all_filters( 'ovic_shop_product_thumb_width' );
            remove_all_filters( 'ovic_shop_product_thumb_height' );
            if ( $atts['productsliststyle'] == 'combined' ) {
                add_action( 'bianco_show_product_group_flash', 'bianco_woocommerce_group_flash', 10 );
                remove_all_filters( 'bianco_sale_product_title_template' );
            }
            wp_reset_postdata();
            $html = ob_get_clean();
            return apply_filters( 'Ovic_Shortcode_Products', $html, $atts, $content );
        }
    }
    new Shortcode_Ovic_Products();
}