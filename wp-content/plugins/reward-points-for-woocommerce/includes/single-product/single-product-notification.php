<?php 

// shows number of points to get on cart page
function phoen_rewpts_single_product_action_get_reward_points() {
   
    global $woocommerce,$product ,$post;

    $gen_val = get_option('phoe_set_point_value');
    
    $phoen_rewpts_notification_data = get_option('phoen_rewpts_notification_settings',true);

    $enable_plugin_product_page = isset($phoen_rewpts_notification_data['enable_plugin_product_page'])?$phoen_rewpts_notification_data['enable_plugin_product_page']:'1';
        
    $phoen_rewpts_notification_product_page = isset($phoen_rewpts_notification_data['phoen_rewpts_notification_product_page'])?$phoen_rewpts_notification_data['phoen_rewpts_notification_product_page']:'You Will get {points} Points On Completing This Order';
	
	$reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:'';
	
	$reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:'';
	
	$reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:'';
	
	$reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:'';
	
	$reward_value=$reward_point/$reward_money;
	
	$reedem_value=$reedem_point/$reedem_money;
	
	$used_reward_amount = phoen_reward_redeem_point();
	
	if(empty($used_reward_amount))
	{
		$used_reward_amount = 0;
		
    }
    if($product->is_type('variable'))
    {

        echo '<p class="woocommerce-cart-notice woocommerce-cart-notice-minimum-amount woocommerce-info pricess phoen_rewpts_reward_message_on_cart">  </p>';
			
			?>
			<input type="hidden" value="<?php echo get_woocommerce_currency_symbol(); ?>" class="phoen_symbole">

			<script>
			jQuery(document).ready(function() {

				setTimeout(function() {
					if (!jQuery('.woocommerce-variation-add-to-cart .single_add_to_cart_button').hasClass(
							'disabled')) {
                        variation_notification();
                        
					}else{
                        jQuery('.phoen_rewpts_reward_message_on_cart').hide();
                    }
				}, 500)

			});

    jQuery(document).on("found_variation", ".variations_form", variation_notification);

    function variation_notification() {
        jQuery('.phoen_rewpts_reward_message_on_cart').show();
        var alt = jQuery(".phoen_symbole").val();

        var decimal_point_reward_ = '<?php echo wc_get_price_decimal_separator();?>';

        var thousand_seprator_point_reward_ = '<?php echo wc_get_price_thousand_separator();?>';

        var product_price = '0';

        if (jQuery('.woocommerce-variation-add-to-cart .single_add_to_cart_button').hasClass('disabled')) {

            var price = '0';
        } else {

            if (jQuery(".woocommerce-variation-price .price ins").length == 1) {
                var price = jQuery(".woocommerce-variation-price .price").find("ins .amount").text();

            } else {

                var price = jQuery(".woocommerce-variation-price .price").find(".amount").text();
            }
            if (price == '') {
                var price = jQuery(".entry-summary .price .woocommerce-Price-amount").text();
            }
        }

        if (thousand_seprator_point_reward_ != ',') {
            product_price = price.replace(/[.,]/g, function(m) {
                return m === ',' ? '.' : '';
            });
        } else {
            var product_price = price.replace(',', '');
        }
        //console.log(price);
        var product_price = product_price.replace(alt, '');

        var product_price = product_price.split(alt);

        var product_price = product_price[0];

        var reward_value = '<?php echo $reward_value ?>';

        var product_purchase_points_vasl = '<?php echo $product_purchase_points_vasl ?>';

        var enable_point_notification_on_product = '<?php echo $enable_plugin_product_page ?>';

        var enable_point_notification_message = '<?php echo $phoen_rewpts_notification_product_page ?>';

        var product_price_total = Math.round(product_price);

        var total_price = (product_price * reward_value);

        var total_price = Math.round(total_price);

        if (product_purchase_points_vasl == '') {

            if (enable_point_notification_on_product == '1') {
                var phoen_reward_notification_message = enable_point_notification_message.replace("{points}",
                    total_price);
                jQuery('p.pricess').html(phoen_reward_notification_message);

            }



        } else {

            if (product_purchase_points_vasl != '' && product_purchase_points_vasl != 0) {

                if (enable_point_notification_on_product == '1') {
                    var phoen_reward_notification_message = enable_point_notification_message.replace("{points}",
                        product_purchase_points_vasl);
                    jQuery('p.pricess').html(phoen_reward_notification_message);

                }

            }
        }

    }
</script>

<?php
        
    }else{
        
            $phoen_product_price = wc_get_price_to_display($product,$args=array());
    
            if(round(($phoen_product_price)*$reward_value)!=0){
            ?>
                <div class='woocommerce-cart-notice woocommerce-cart-notice-minimum-amount woocommerce-info'>
                <?php 
                    $phoen_rewards_point = round(($phoen_product_price)*$reward_value);
                    echo str_replace("{points}","$phoen_rewards_point",$phoen_rewpts_notification_product_page);?>
                </div>
            <?php 
            }   
    }
	?>


<style>
.phoen_rewpts_pts_link_div.cart_apply_btn input[type="submit"]:active,
.phoen_rewpts_pts_link_div.cart_apply_btn input[type="submit"]:focus {
    font-size: 100%;
    margin: 0;
    line-height: 1;
    cursor: pointer;
    position: relative;
    text-decoration: none;
    overflow: visible;
    padding: .618em 1em !important;
    font-weight: 700;
    border-radius: 3px;
    left: auto;
    color: #515151;
    background-color: #ebe9eb;
    border: 0 !important;
    display: inline-block;
    background-image: none !important;
    box-shadow: none;
    text-shadow: none;
}

.woocommerce-cart .phoen_rewpts_pts_link_div.cart_apply_btn {
    width: 64%;
    margin: 15px auto auto;
}

.woocommerce-cart .phoen_rewpts_pts_link_div.cart_apply_btn input.phoen_edit_points_input {
    width: 188px;
}
</style>
<?php
}
?>