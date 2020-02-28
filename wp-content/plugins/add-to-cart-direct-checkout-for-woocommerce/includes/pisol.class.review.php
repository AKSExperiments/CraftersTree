<?php
/**
* version 1.2
* work with bootstrap
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if(!class_exists('pisol_class_review')):
class pisol_class_review{

    function __construct($name, $slug, $buy_now, $price=""){
        $this->name = $name;
        $this->slug = $slug;
        $this->review_url = "https://wordpress.org/support/plugin/$slug/reviews/#new-post";
        $this->buy_now = $buy_now;
        $this->price = $price;
        $this->nonce = 'pi_theme_nonce';
        add_action( 'admin_init', array( $this, 'hide_review_notice' ) );
        add_action( 'admin_notices', array( $this, 'review_notice' ) );
        
    }

    function showNotification(){
        //delete_transient($this->slug.'_show_notification');
        //delete_option($this->slug.'_first_run');

        $this->show_notification = get_transient($this->slug.'_show_notification');

        $this->first_run = get_option($this->slug.'_first_run',"");

        if($this->first_run == ""){
            /* this make sure we run review msg after 1 day (86400 sec) after installation date */
            set_transient( $this->slug.'_show_notification', 'no',86400);
            update_option($this->slug.'_first_run',"complete");
            return false;
        }
        
        
        if($this->show_notification == 'no'){
            return false;
        }

        return true;
    }

    function thisFirstRun(){
        $this->first_run = get_option($this->slug.'_show_notification',"");
        if($this->first_run == ""){
            return true;
        }
        return false;
    }

    function review_notice(){
        if(!$this->showNotification()) return;
        ?>
        <div class="notice notice-success" style="padding:20px; border-top:9px solid #46b450; margin-top:20px; background:#fff; border-left:none; ">
                        <h3 style="font-size:19px;">Thank you for using "<?php echo $this->name; ?>"</h3>
                        <p style="font-size:17px; margin-bottom:10px;">Kindly show us some support by giving a 5 star rating. ⭐⭐⭐⭐⭐</p>
                        <div>
                            <a style="font-size:16px; display:inline-block; padding:10px; border:1px solid #46b450; text-decoration:none; margin-right:15px;" target="_blank" href="<?php echo $this->review_url; ?>"><span>🤩</span> Sure will review now</a>
                            <a style="font-size:16px; display:inline-block; padding:10px; border:1px solid #46b450; text-decoration:none; margin-right:15px;"  data-type="remind" href="<?php echo $this->reviewAfterwords(); ?>"><span>👏</span> Remind letter</a>
                            <a style="font-size:16px; display:inline-block; padding:10px; border:1px solid #46b450; text-decoration:none; margin-right:15px;"  data-type="dismiss" href="<?php echo $this->reviewAfterwords(); ?>"><span>😞</span> Please don't show this again</a>
                        </div>
        </div>
        
        <?php
    }

    public function hide_review_notice() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( ! isset( $_GET[$this->nonce] ) ) {
            return;
        }

        if ( wp_verify_nonce( $_GET[$this->nonce], $this->slug . '_hide_notices' ) ) {
            /* This hide the msg for 70 days */
            set_transient( $this->slug.'_show_notification', 'no',6048000);
        }
    }

    function reviewAfterwords(){
       return esc_url( wp_nonce_url( @add_query_arg(), $this->slug. '_hide_notices', $this->nonce));
    }
}

new pisol_class_review('Direct checkout | Add to cart redirect', 'add-to-cart-direct-checkout-for-woocommerce',PI_DCW_BUY_URL, PI_DCW_PRICE);
endif;


