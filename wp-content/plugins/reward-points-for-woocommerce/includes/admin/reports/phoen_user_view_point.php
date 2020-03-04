<?php if ( ! defined( 'ABSPATH' ) ) exit; 
	
global $woocommerce;

$cur_id = $_GET['user'];
			
$products_order = get_posts( array(
		'numberposts' => -1,
		'meta_key'    => '_customer_user',
		'meta_value'  => $cur_id,
		'post_type'   => 'shop_order',
		'order' => 'DESC',
		'post_status' => array_keys( wc_get_order_statuses() ),
	) );
	
	$user_order_count = count($products_order);
	
	$phoen_expire_date_data = '';
	
	$gen_val = get_option('phoe_set_point_value',true);
    
    $reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:'';			
    $reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:'';			
    $reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:'';			
    $reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:'';			
    $reward_value= $reward_point/$reward_money;			
    $reedem_value= $reedem_point/$reedem_money;
	$reward_point_value_data = phoen_reward_point_value();
	
    extract($reward_point_value_data);
    for($i=0;$i<count($products_order);$i++) {

        $products_detail=get_post_meta($products_order[$i]->ID); 
        
        $gen_settings=get_post_meta( $products_order[$i]->ID, 'phoe_rewpts_order_status', true );
            
            $get_reward_amount=isset($gen_settings['get_reward_amount'])?$gen_settings['get_reward_amount']:'';
            
            $get_reward_point=isset($gen_settings['get_reward_point'])?$gen_settings['get_reward_point']:'';
            
            $used_reward_point=isset($gen_settings['used_reward_point'])?$gen_settings['used_reward_point']:'';
            
            $order = wc_get_order($products_order[$i]->ID);

            $order_bill = phoen_reward_order_sub_total($order);
            
            $point_reward=0;
            
            if($products_order[$i]->post_status=="wc-completed")
            { 
                $total_point_reward['total_reward_point'] += $get_reward_point-$used_reward_point;
                $total_point_reward['total_reward_amt'] += $get_reward_amount;
            }
        }
        $admin_point  = get_post_meta($cur_id,'phoes_customer_points_update_valss',true);
	?>
<div class="wrap">

	<h1 class="wp-heading-inline"><?php _e('VIEW CUSTOMER POINTS','phoen-rewpts'); ?></h1>

	<a class="page-title-action" href="?page=phoe_set_point_value"><?php _e('Back To Report','phoen-rewpts');?></a>
	<div><p><span>Total Reward Point: <?= $total_point_reward['total_reward_point']+$admin_point;?></span></p>
	<p><span>Total Reward Amount: <?= ($total_point_reward['total_reward_point']+$admin_point)*$reedem_value;?></span></p></div>
	<br /><br />
	
	<table class="wp-list-table widefat fixed striped customers">
	
		<thead>	
	
	
			<tr class="phoen_rewpts_user_reward_point_tr">
				
				<th class=" column-customer_name " scope="col"><span><?php _e('Order','phoen-rewpts'); ?></span></th>
				<th class=" column-spent" scope="col"><span><?php _e('Amount Spent','phoen-rewpts'); ?></span></th>
				<th class=" column-spent" scope="col"><span><?php _e('Reward Point','phoen-rewpts'); ?></span></th>
				<th class=" column-spent" scope="col"><span><?php _e('Reward Amount','phoen-rewpts'); ?></span></th>
				
			</tr>
			
		</thead>
		
			<tbody>	
				<?php
               
                if($admin_point>0){ ?>
                    <tr>
                            <td>-</td>
                            <td>Admin Update </td>
                            <td><?php echo $admin_point;?></td>
                            <td><?php echo $admin_point*$reedem_value;?></td>
                            
                        </tr>

               <?php  }
			for($i=0;$i<count($products_order);$i++) {

                $products_detail=get_post_meta($products_order[$i]->ID); 
                
                $gen_settings=get_post_meta( $products_order[$i]->ID, 'phoe_rewpts_order_status', true );
					
					$get_reward_amount=isset($gen_settings['get_reward_amount'])?$gen_settings['get_reward_amount']:'';
					
					$get_reward_point=isset($gen_settings['get_reward_point'])?$gen_settings['get_reward_point']:'';
					
					$used_reward_point=isset($gen_settings['used_reward_point'])?$gen_settings['used_reward_point']:'';
					
					$order = wc_get_order($products_order[$i]->ID);
		
					$order_bill = phoen_reward_order_sub_total($order);
					
					$point_reward=0;
					
					if($products_order[$i]->post_status=="wc-completed")
					{ 
                        $total_point_reward['total_reward_point'] += $get_reward_point;
						$total_point_reward['total_reward_amt'] += $get_reward_amount;
                        ?>
                        <tr>
                            <td><?php echo $products_order[$i]->ID?></td>
                            <td><?php echo $order->get_subtotal(); ?> </td>
                            <td><?php echo $get_reward_point;?></td>
                            <td><?php echo $get_reward_amount;?></td>
                            
                        </tr>
						<?php
					}
				
                }
			
			?>
		
			</tbody>
			
			<tfoot>
					
				<tr class="phoen_rewpts_user_reward_point_tr">
				
                    <th class=" column-customer_name " scope="col"><span><?php _e('Order','phoen-rewpts'); ?></span></th>
                    <th class=" column-spent" scope="col"><span><?php _e('Amount Spent','phoen-rewpts'); ?></span></th>
                    <th class=" column-spent" scope="col"><span><?php _e('Reward Point','phoen-rewpts'); ?></span></th>
                    <th class=" column-spent" scope="col"><span><?php _e('Reward Amount','phoen-rewpts'); ?></span></th>

				</tr>
		
			</tfoot>	
		
	</table>
	</div>