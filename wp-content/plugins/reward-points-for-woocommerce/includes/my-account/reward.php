<?php 

        $current_user = wp_get_current_user();    
			global $woocommerce;			
			$curr=get_woocommerce_currency_symbol();						
			$gen_val = get_option('phoe_set_point_value');	
							
			$reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:'';			
			$reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:'';			
			$reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:'';			
			$reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:'';			
			$reward_value= $reward_point/$reward_money;			
			$reedem_value= $reedem_point/$reedem_money;
			//$phoen_rewpts_user_reward_point= phoen_rewpts_user_reward_point();	
			$total_point_reward= phoen_rewpts_my_account_user_reward_point();	
			// echo "<pre>";  
			// print_r($total_point_reward);
			// echo "</pre>";  
			// die();
			
			//$amt= round($total_point_reward/$reedem_value,2);			
			$admin_point  = get_post_meta(get_current_user_id(),'phoes_customer_points_update_valss',true);
			$gen_val = get_option('phoe_rewpts_range_value');						
			if(is_array($total_point_reward) && !empty($total_point_reward)){?>
<div class="phoen_my_account_dashboard_point_wrap">
   <div class="user_reward_total">
   <?php $row = count($total_point_reward)-1;?>
   <p><span>Total Reward Point</span> : <?=$total_point_reward[$row]['total_reward_point']+$admin_point;?></p>
   <p><span>Reward Point Amount</span>: <?=($total_point_reward[$row]['total_reward_point']+$admin_point)*$reedem_value;?></p>
   </div>
    <table class="phoen_my_account_dashboard_point_table">
        <tr class="phoen_my_account_dashboard_point_tr">
            <th><?php _e( 'Order ID', 'phoen-rewpts' ); ?></th>
            <th><?php _e( 'Order Amount', 'phoen-rewpts' ); ?></th>
            <th><?php _e( 'Reward Point', 'phoen-rewpts' ); ?></th>
            <th><?php _e( 'Reward Amount', 'phoen-rewpts' ); ?></th>
        </tr>
		<?php if($admin_point>0) { ?>
			<tr class="phoen_my_account_dashboard_point_tr">
				<td>-</td>
				<td>Admin Update</td>
				<td><?php echo ($admin_point);?></td>
				<td><?php echo $curr .($admin_point*$reedem_value);?></td>
				
			</tr>
		<?php }?>
		
		
	   <?php 
	   foreach($total_point_reward as $key => $value){ ?>
			<tr class="phoen_my_account_dashboard_point_tr">
				<td><?php echo ($value['order_id']);?></td>
				<td><?php echo $curr .($value['amount_spent']);?></td>
				<td><?php echo ($value['reward_point']);?></td>
				<td><?php echo $curr .($value['reward_amount']);?></td>
				
			</tr>
		<?php

	   }?>
	   
	    
    </table>
</div>
<?php
			} 