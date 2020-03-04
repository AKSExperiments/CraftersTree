<?php 
// shows number of points to get on cart page
		function phoen_rewpts_checkout_action_get_reward_points() {
			
			$gen_val = get_option('phoe_rewpts_value');
			
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
			$phoen_rewpts_notification_data = get_option('phoen_rewpts_notification_settings',true);
			
			$enable_apply_box_checkout_page = isset($phoen_rewpts_notification_data['apply_box_enable_on_checkout'])?$phoen_rewpts_notification_data['apply_box_enable_on_checkout']:'1';
		
			$phoen_apply_box_notification_checkout_page = isset($phoen_rewpts_notification_data['phoen_apply_box_notification_checkout_page'])?$phoen_rewpts_notification_data['phoen_apply_box_notification_checkout_page']:'You can apply {points} Points to get {price} Discount.';
		
			$bill_price=phoen_rewards_cart_subtotal();
			
			$total_point_reward=phoen_rewpts_user_reward_point();
			
			$amt=round($total_point_reward/$reedem_value,2);
			
			$enable_plugin_checkout_page = isset($phoen_rewpts_notification_data['enable_plugin_checkout_page'])?$phoen_rewpts_notification_data['enable_plugin_checkout_page']:'1';
	
			$phoen_rewpts_notification_checkout_page = isset($phoen_rewpts_notification_data['phoen_rewpts_notification_checkout_page'])?$phoen_rewpts_notification_data['phoen_rewpts_notification_checkout_page']:'You Will get {points} Points On Completing This Order';

			$bill_price = (int)$bill_price-$used_reward_amount;
			
				if(round($bill_price*$reward_value)!=0){
					?><div  class='woocommerce-cart-notice woocommerce-cart-notice-minimum-amount woocommerce-info checkout_reward_notification'>
					<?php 
					$phoen_rewards_point = round($bill_price*$reward_value);
					echo str_replace("{points}","$phoen_rewards_point",$phoen_rewpts_notification_checkout_page);?></div>
				<?php 
				}
			
		}