<?php 
global $woocommerce, $wpdb;

$curr=get_woocommerce_currency_symbol();
$offset = 0;
$posts_per_page = 500;
$args = array(
		'post_type'      => 'shop_order',
		//'fields'         => 'ids',
		'offset'         => $paged,
		'posts_per_page' => $posts_per_page,
		'post_status'    =>array('wc-completed','wc-refunded')//array_keys(wc_get_order_statuses())
		
	 
	);
	
$offset += $posts_per_page;
	
$products_order = get_posts( $args ); 

global $wpdb,$post;

$limit = 50;  

if (isset($_GET["paged"])) { $page  = $_GET["paged"]; } else { $page=1; };  

$start_from = ($page-1) * $per_page;

$user_detail = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->users WHERE 1 $do_search ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $start_from), ARRAY_A);

$data_count=0;

$all_user_list_data = array();

for($a=0;$a<count($user_detail);$a++) {
	
	$total_point_reward=0;
	
	$order_count=0;
	
	$amount_spent=0;
	
	$tpoint_reward_new_val=0;
	
	$total_point_reward_empty=0;

	$id = $user_detail[$a]['ID'];
	
	$check_order_count=phoen_order_count($id); 

		$all_user_list_data [$a]['user_email'] = ($user_detail[$a]['user_email']!='')?$user_detail[$a]['user_email']:$user_detail[$a]['user_login']; 
		
		$all_user_list_data [$a]['ID'] = $user_detail[$a]['ID'];
		
		$gen_val = get_option('phoe_rewpts_value');
		
		$reward_point_value_data = phoen_reward_point_value();

		extract($reward_point_value_data);
			
		$phoen_update_date = get_option('phoen_update_dates');
			
		for($i=0;$i<count($products_order);$i++)  	{
	
			$products_detail=get_post_meta($products_order[$i]->ID); 
			
			$gen_settings=get_post_meta( $products_order[$i]->ID, 'phoe_rewpts_order_status', true );
			
			if(($products_detail['_customer_user'][0]==$id)&&(is_array($gen_settings)))
			{				
				$ptsperprice=isset($gen_settings['points_per_price'])?$gen_settings['points_per_price']:'';
				
				$used_reward_point=0;
				
				$used_reward_point=isset($gen_settings['used_reward_point'])?$gen_settings['used_reward_point']:'0';
				
				$get_reward_point=isset($gen_settings['get_reward_point'])?$gen_settings['get_reward_point']:'';
				
				$order = wc_get_order($products_order[$i]->ID);

				$order_bill = phoen_reward_order_sub_total($order);
				
				$point_reward=0;
				$tpoint_reward=0;
				/* if($products_order[$i]->post_status=="wc-completed")
				{
					$data_count++;
					
					$point_reward= $order_bill*$ptsperprice;
					
					
				} */
				
				if($products_order[$i]->post_status=="wc-completed")
				{
					$total_point_reward+= $get_reward_point-$used_reward_point;
					
				}
				//$order_count++;
				if($products_order[$i]->post_status=="wc-refunded")
				{
					$point_rewardt= ltrim($used_reward_point,'-');
					$point_reward=($order_bill*$reedem_point)+$point_rewardt;
				} 
				
				$tpoint_reward+=$used_reward_point+$point_reward;
			
				//$total_point_reward+=$tpoint_reward;
				
				$amount_spent+=$order_bill;
				
				$order_count++;
				
			}
			
		}	
	
			
	$all_user_list_data [$a]['order_count'] =  $order_count; 
			
	$amount_spent = round($amount_spent) ; 
			
	$all_user_list_data [$a]['amount_spent'] =  $curr.$amount_spent; 

	$all_user_list_data [$a]['total_point_reward'] = round($total_point_reward); 

	$all_user_list_data [$a]['amount_in_wallet'] = $curr.round($total_point_reward/$reedem_value,2);

}

$this->items = $all_user_list_data;