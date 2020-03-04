<?php if ( ! defined( 'ABSPATH' ) ) exit; 

	$user_id = isset($_GET['user'])?$_GET['user']:'';
	
	if(isset($_POST['update_points']))
	{
        
		$phoen_update_data = isset($_POST['phoen_update_data'])?$_POST['phoen_update_data']:'';
		$phoen_hidden_user_id=isset($_POST['phoen_hidden_user_id'])?$_POST['phoen_hidden_user_id']:'';
		//print_r($_POST);
		
		$phoen_current_dates_update = new DateTime();
		
		$phoen_current_dates_updates = $phoen_current_dates_update->format('d-m-Y H:i:s');
		
		update_post_meta($phoen_hidden_user_id,'phoeni_update_dates_checkeds',$phoen_current_dates_updates);

		update_post_meta( $phoen_hidden_user_id, 'phoes_customer_points_update_valss'.$phoen_current_dates_updates, $phoen_update_data );
	}
	//echo $get_last_order_id;
	function get_last_order_id(){
		global $wpdb;
		$statuses = array_keys(wc_get_order_statuses());
		$statuses = implode( "','", $statuses );
	
		// Getting last Order ID (max value)
		$results = $wpdb->get_col( "
			SELECT MAX(ID) FROM {$wpdb->prefix}posts
			WHERE post_type LIKE 'shop_order'
			AND post_status IN ('$statuses')
		" );
		return reset($results);
	}
	?>
<div class="wrap">

	<h1 class="wp-heading-inline"><?php _e('MANAGE CUSTOMER POINTS','phoen-rewpts'); ?></h1>

	<a class="page-title-action" href="?page=phoe_set_point_value"><?php _e('Back To Report','phoen-rewpts');?></a>

	<br /><br />
	<table class="wp-list-table widefat fixed striped customers">
				
	<thead>
		
		<tr class="phoen_rewpts_user_reward_point_tr">
			
			<th class=" column-customer_name " scope="col"><span><?php _e('Customer Email Id','phoen-rewpts'); ?></span>
				
			</th>

			<th class=" column-spent" scope="col"><span><?php _e('Reward Points','phoen-rewpts'); ?></span>
				
			</th>
			
			<th class=" column-spent" scope="col"><span><?php _e('Add','phoen-rewpts'); ?></span>
				
			</th>

		</tr>
		
	</thead>	
	
	<tbody>	
			<?php 
			
			global $woocommerce;
			
			$curr=get_woocommerce_currency_symbol();
			
			$products_order = get_posts( array(
				'numberposts' => -1,
				'meta_key'    => '_customer_user',
				'meta_value'  => $user_id,
				'post_type'   => 'shop_order',
				'order' => 'ASC',
				'post_status' => array_keys( wc_get_order_statuses() ),
			) );
			
			$user_data_by_email = get_userdata( $user_id );
			
			$user = get_user_by( 'ID', $user_id);
			
				$total_point_reward=0;
				
				$total_point_reward_empty=0;
				
				$order_count=0;
				
				$amount_spent=0;
				
				$tpoint_reward_new_val=0;
				
				$id=$user_id;
				
				$check_order_count=phoen_order_count($id); 
				
				$phoen_current_dates_updates_val = get_post_meta($user_id,'phoeni_update_dates_checkeds',true);
				$phoen_update_date_val=strtotime($phoen_current_dates_updates_val);	
					?>
					<tr>
					
						<td class="customer_name " ><?php echo $usert_email = isset($user->user_email)?$user->user_email:'' ; ?></td>
					
						<?php 	
						
						$total_point_reward = array();
						
						$admin_update_date = get_post_meta($phoen_hidden_user_id,'phoeni_update_dates_checkeds',true);
						
						for($i=0;$i<count($products_order);$i++) {

							$order_date = $products_order[$i]->post_date;
							$order_date = strtotime($order_date);	
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
						
                           $admin_add_update = get_post_meta($user_id,'phoes_customer_points_update_valss',true);
						?>
				
						<td class=" column-orders" ><?php echo round($total_point_reward['total_reward_point']+$admin_add_update); ?></td>
						
						<td class=" column-spent" >
						
							<form method="post">
							
								<input type="number" min="0" name="phoen_update_data" value="">
								<input type="hidden" name="phoen_hidden_user_id" value="<?php echo $user_id ; ?>">
								
								<input type="submit" name="update_points" value="Update">
									
							</form>		
							
						</td>
					
					</tr>
					
					<?php 	
				
				
				?>
	</tbody>
	
	<tfoot>
					
		<tr class="phoen_rewpts_user_reward_point_tr">
		
			<th class=" column-customer_name " scope="col"><span><?php _e('Customer Email Id','phoen-rewpts'); ?></span></th>

			<th class=" column-spent" scope="col"><span><?php _e('Reward Points','phoen-rewpts'); ?></span></th>
			
			<th class=" column-spent" scope="col"><span><?php _e('Update','phoen-rewpts'); ?></span>	</th>

		</tr>
		
	</tfoot>	
</table>
</div>
<?php	