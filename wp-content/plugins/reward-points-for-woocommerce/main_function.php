<?php 

function phoen_reward_redeem_point(){
	
	//ob_start();
	
	global $woocommerce;
	
	$coupon_id = 'reward amount';
	
	$amount=0;
	
	if(in_array($coupon_id, $woocommerce->cart->get_applied_coupons())){
			
		$amount = WC()->cart->get_coupon_discount_amount( $coupon_id, WC()->cart->display_cart_ex_tax );
		
	}
	//ob_get_clean();
	
	return $amount;
	
}


function phoen_reward_point_value(){

	$gen_val = get_option('phoe_set_point_value');
	
	$reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:0;
	
	$reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:0;
	
	$reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:0;
	
	$reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:0;
	
	if($reward_point !=0 || $reward_money !=0){
		$reward_value=$reward_point/$reward_money;
	}else{
		$reward_value =0;
	}
	if($reedem_point !=0 || $reedem_money !=0){
		$reedem_value=$reedem_point/$reedem_money;
	}else{
		$reedem_value =0;
	}
	
	return $rewards_point_value_data = array('reward_value'=>$reward_value,'reedem_value'=>$reedem_value);
	
	
}

function phoen_reward_order_sub_total($order){
	
	$tax_display = get_option( 'woocommerce_tax_display_cart' );
	
	$subtotal    = 0;
	
	$compound = false;
	
	if ( ! $compound ) {
		
		foreach ( $order->get_items() as $item ) {
			
			$subtotal += $item->get_subtotal();

			if ( 'incl' === $tax_display ) {				
				$subtotal += $item->get_subtotal_tax();			
			}
		}

		//$subtotal = wc_price( $subtotal, array( 'currency' => $order->get_currency() ) );

	} else {
		if ( 'incl' === $tax_display ) {
			return '';
		}

		foreach ( $order->get_items() as $item ) {
			$subtotal += $item->get_subtotal();
		}

		// Add Shipping Costs.
		$subtotal += $order->get_shipping_total();

		// Remove non-compound taxes.
		foreach ( $order->get_taxes() as $tax ) {
			if ( $tax->is_compound() ) {
				continue;
			}
			$subtotal = $subtotal + $tax->get_tax_total() + $tax->get_shipping_tax_total();
		}

		// Remove discounts.
		$subtotal = $subtotal - $order->get_total_discount();
		//$subtotal = wc_price( $subtotal, array( 'currency' => $order->get_currency() ) );
	}
	
	return $subtotal;
}
function phoen_rewards_cart_subtotal(){
	
	$curreny_symbol = get_woocommerce_currency_symbol();
	
	if ( 'incl' === get_option( 'woocommerce_tax_display_cart' )) {
		$cart_subtotal =  WC()->cart->get_subtotal() + WC()->cart->get_subtotal_tax();

	} else {
		
		$cart_subtotal = WC()->cart->get_subtotal();

	}
	
	return round($cart_subtotal);//str_replace("$curreny_symbol","",strip_tags($cart_subtotal));
}

?>