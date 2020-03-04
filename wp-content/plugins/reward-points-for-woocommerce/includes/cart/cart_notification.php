<?php 

// shows number of points to get on cart page
function phoen_rewpts_action_get_reward_points() {
	
	$gen_val = get_option('phoe_set_point_value');
	
	$reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:'';
	
	$reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:'';
	
	$reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:'';
	
	$reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:'';
	
	$reward_value=$reward_point/$reward_money;
	
	$reedem_value=$reedem_point/$reedem_money;
	
	global $woocommerce;
	
	$used_reward_amount = phoen_reward_redeem_point();
	
	if(empty($used_reward_amount))
	{
		$used_reward_amount = 0;
		
	} 
	
	$bill_price=phoen_rewards_cart_subtotal();
	//die();
	
	$phoen_rewpts_notification_data = get_option('phoen_rewpts_notification_settings',true);

	$enable_plugin_cart_page = isset($phoen_rewpts_notification_data['enable_plugin_cart_page'])?$phoen_rewpts_notification_data['enable_plugin_cart_page']:'1';
		
	$phoen_rewpts_notification_cart_page = isset($phoen_rewpts_notification_data['phoen_rewpts_notification_cart_page'])?$phoen_rewpts_notification_data['phoen_rewpts_notification_cart_page']:'You Will get {points} Points On Completing This Order';

		if(round(($bill_price-$used_reward_amount)*$reward_value)!=0){
		
		echo "<div class='woocommerce-cart-notice woocommerce-cart-notice-minimum-amount woocommerce-info'>";
    
			$phoen_rewards_point = round(($bill_price-$used_reward_amount)*$reward_value);
			echo str_replace("{points}","$phoen_rewards_point",$phoen_rewpts_notification_cart_page);
		echo "</div>";

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