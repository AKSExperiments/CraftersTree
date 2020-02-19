<?php

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Ovic_Add_Share
{

    public function __construct()
    {
        add_action('wp_footer', array($this, 'ovic_print_scripts'));
        add_action('woocommerce_before_add_to_cart_quantity', array($this, 'ovic_get_social_media_share'),10);
    }

    function ovic_get_social_media_share()
    {
        $used_addthis = apply_filters( 'ovic_get_option', 'ovic_single_product_used_addthis', 0 );
        $html = '';
        if($used_addthis){
            global $post;
            $thum_image           = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
            $url                  = get_permalink( $post->ID );
            ob_start(); ?>
            <div class="ovic-single-product-socials">
                <!-- Facebook -->
                <!-- Your like button code -->
                <div class="fb-like"
                     data-href="<?php echo esc_url( $url ); ?>"
                     data-layout="button_count"
                     data-action="like"
                     data-show-faces="false">
                </div>

                <!-- Twitter -->
                <a class="twitter-share-button"
                   href="<?php echo esc_url( add_query_arg( array( 'text' => urlencode( get_the_title( $post->ID ) ), 'url' => $url ), '//twitter.com/intent/tweet' ) ); ?>"
                   data-size="small">Tweet</a>
                <!-- Pinit -->

                <?php ?>
                <a href="<?php echo esc_url( add_query_arg( array( 'url' => $url, 'media' => $thum_image[ 0 ], 'description' => urlencode( get_the_title( $post->ID ) ) ), '//pinterest.com/pin/create/button/' ) ); ?>"
                   class="pin-it-button" count-layout="hozizontal">Pin It</a>

                <!-- G+ -->
                <div class="g-plus" data-action="share" data-annotation="bubble"
                     data-href="<?php echo esc_url( $url ); ?>"></div>
            </div>
            <?php $html = ob_get_clean();
            echo $html;
        }
    }

    function ovic_print_scripts()
    {
        $used_addthis = apply_filters( 'ovic_get_option', 'ovic_single_product_used_addthis', 0 );
        if( $used_addthis && is_product()){
            $http = 'http';
            if ( is_ssl() ) $http = 'https';

            ?>
            <!-- Facebook scripts -->
            <!-- Load Facebook SDK for JavaScript -->
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>

            <!-- Twitter -->
            <script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>

            <!-- Pinterest -->
            <script type="text/javascript">
                (function () {
                    window.PinIt = window.PinIt || {loaded: false};
                    if ( window.PinIt.loaded ) return;
                    window.PinIt.loaded = true;
                    function async_load() {
                        var s   = document.createElement("script");
                        s.type  = "text/javascript";
                        s.async = true;
                        s.src   = "<?php echo esc_attr( $http ); ?>://assets.pinterest.com/js/pinit.js";
                        var x   = document.getElementsByTagName("script")[ 0 ];
                        x.parentNode.insertBefore(s, x);
                    }

                    if ( window.attachEvent )
                        window.attachEvent("onload", async_load);
                    else
                        window.addEventListener("load", async_load, false);
                })();
            </script>

            <!-- G+ -->
            <script src="https://apis.google.com/js/platform.js" async defer></script>

            <?php
        }
    }
}
new Ovic_Add_Share();