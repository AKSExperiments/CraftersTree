<?php
// save data in post meta when click on checkout in order page
function phoen_rewpts_click_on_checkout_action( $order_id ){
	
	if ( ! $order = wc_get_order( $order_id ) ) {
		return;
	}
	
	$gen_val = get_option('phoe_set_point_value');
	
	$reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:'';
	
	$reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:'';
	
	$reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:'';
	
	$reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:'';
	
	$reward_value=$reward_point/$reward_money;
	
	$reedem_value=$reedem_point/$reedem_money;
	
	$reedem_amt=phoen_rewpts_user_reward_amount();
	
	$reedem_point=phoen_rewpts_user_reward_point();
	
	$order_detail=get_post_meta($order_id);
	
	$bill_price = phoen_reward_order_sub_total($order);
	
	//$bill_price=$order_detail['_order_total'][0];
	
	global $woocommerce;
	
	$used_reward_amount = phoen_reward_redeem_point();
	
	$used_reward_point=$used_reward_amount*$reedem_value;
	
	$get_reward_point=($bill_price-$used_reward_point)*$reward_value;
		
	$get_reward_amount = ($bill_price-$used_reward_amount);
	
	$phoe_set_point_value = array(
				 
		'phoen_reward_enable'=>1,
		
		'total_reward_point'=>round($reedem_point,2), //total reward points
		
		'total_reward_amount'=>round($reedem_amt,2),  //total reward amount
		
		'used_reward_point'=>$used_reward_point, // get used reward point if used
		
		'used_reward_amount'=>$used_reward_amount, // get used reward amount if used
		
		'points_per_price'=>$reward_value, //POINTS PER PRICE
		
		'reedem_per_price'=>$reedem_value, //REEDEM PER PRICE
		
		'get_reward_point'=>round($get_reward_point,2), //get reward points from shopping
		
		'get_reward_amount'=>round($get_reward_amount,2), // order amount
		
	);
 	// echo "<pre>";
	// print_r($phoe_set_point_value);
	// echo "</pre>";
	// die(); 
   update_post_meta( $order_id, 'phoe_rewpts_order_status', $phoe_set_point_value );

   session_destroy();
}
?>