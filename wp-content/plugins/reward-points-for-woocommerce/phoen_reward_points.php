<?php 

/*
** Plugin Name: Reward Points For Woocommerce

** Plugin URI: https://www.phoeniixx.com/product/reward-points-for-woocommerce/

** Description: It is a plugin which provides the customers to get the reward points on the basis of the  purchase of the products or the money spent by them.

** Version: 4.1

** Author: phoeniixx

** Text Domain:phoen-rewpts

** Author URI: http://www.phoeniixx.com/

** License: GPLv2 or later

** License URI: http://www.gnu.org/licenses/gpl-2.0.html

** WC requires at least: 2.6.0

** WC tested up to: 3.9.2

**/  

if ( ! defined( 'ABSPATH' ) ) exit;
	
		
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		
		define('PHOEN_REWPTSPLUGURL',plugins_url(  "/", __FILE__));
	
		define('PHOEN_REWPTSPLUGPATH',plugin_dir_path(  __FILE__));
		
		include_once(PHOEN_REWPTSPLUGPATH.'includes/admin/reports/phoen_all_user_wp_list_table.php');	
		
		function phoe_rewpts_menu_booking() {
			
			add_menu_page('Phoeniixx_Reward_pts',__( 'Reward Points', 'phoen-rewpts' ) ,'nosuchcapability','Phoeniixx_Reward_pts',NULL, PHOEN_REWPTSPLUGURL.'assets/images/aa2.png' ,'57.1');
			
			add_submenu_page( 'Phoeniixx_Reward_pts', 'Phoeniixx_reward_settings', 'Settings','manage_options', 'Phoeniixx_reward_settings',  'Phoeniixx_reward_settings_func' );
			
			add_submenu_page( 'Phoeniixx_Reward_pts', 'phoe_set_point_value', 'Customers Report','manage_options', 'phoe_set_point_value',  'phoeniixx_rewpts_check_order_admin' );
	
		}
		//add custome fields on products 
		add_action( 'woocommerce_product_options_general_product_data', 'phoen_reword_woo_add_custom_general_fields' );

		function phoen_reword_woo_add_custom_general_fields() {

		
			  ?>
			  <div class="options_group">
			  
				<p class="form-field">
					<label for="phoen_reword"><?php _e( 'Product Fixed Point:', 'phoen-rewpts' ); ?></label>
					<input type="number" readonly min="0" step="any" name="phoen_product_wide_rewar_points" value="" >
					&nbsp;<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>				
				</p>
				
				<p class="form-field">
					<label for="phoen_reword"><?php _e( 'Product Percentage Points:', 'phoen-rewpts' ); ?></label>
					<input type="number" min="0"  readonly step="any" name="phoen_percentage_wide_rewar_points" value="" >
					&nbsp;<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>				
				</p>
			
			  </div>
			  <?php
			 
				
		}

		add_action('admin_menu', 'phoe_rewpts_menu_booking');
	
		add_action('wp_head','phoen_rewpts_frontend_func');
		
		add_action('admin_head','phoen_rewpts_backend_func');

		function phoen_rewpts_frontend_func(){
				
			
			include_once(PHOEN_REWPTSPLUGPATH.'includes/phoen_rewpts_frontend.php');
			?>
			<style>
			.woocommerce-cart-notice.woocommerce-cart-notice-minimum-amount.woocommerce-info {
				display: flex;
				align-items: center;
			}

			.woocommerce-cart .woocommerce-cart-notice-minimum-amount .phoen_rewpts_pts_link_div.cart_apply_btn {
				margin: 0;
				width: auto;
			}

			.woocommerce-cart-notice form {
				display: flex;
			}

			.woocommerce-account .user_reward_total {
				display: flex;
				justify-content: space-between;
			}

			.woocommerce-account .user_reward_total p {
				background-color: #e7e7e7;
				padding: 5px 15px;
				border-radius: 5px;
				text-transform: uppercase;
				font-weight: 500;
				letter-spacing: 0.5px;
				margin-bottom: 5px;
			}

			.woocommerce-account table.phoen_my_account_dashboard_point_table th{
				background-color: #e7e7e7;
			}

			</style>
<script>
jQuery(document).on('click', '#apply_point_btn', function() {
    jQuery(this).hide();
    jQuery('.cart_apply_btn').css('display', 'block');

})

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>
<?php	
		}
		include_once(PHOEN_REWPTSPLUGPATH.'includes/checkout/checkout_notification.php');
		include_once(PHOEN_REWPTSPLUGPATH.'includes/checkout/checkout_order_processed.php');
		include_once(PHOEN_REWPTSPLUGPATH.'includes/cart/cart_notification.php');
		include_once(PHOEN_REWPTSPLUGPATH.'includes/single-product/single-product-notification.php');
		include_once(PHOEN_REWPTSPLUGPATH.'main_function.php');
		function phoen_rewpts_backend_func(){
				
			wp_enqueue_style( 'phoen_rewpts_backend_func_css', PHOEN_REWPTSPLUGURL. "assets/css/phoen_rewpts_backend.css" );	
			wp_enqueue_script( 'phoen_rewpts_backend_func_js', PHOEN_REWPTSPLUGURL. "assets/js/phoen_rewpts_backend.js" );	
			wp_enqueue_script( 'phoen-cust-pagination-scripts', plugin_dir_url(__FILE__)."assets/js/pagination.js", array( 'jquery' ),true );
			wp_enqueue_style( 'wp-color-picker');
			
			wp_enqueue_script( 'wp-color-picker');
		
			
		}
		function phoeniixx_rewpts_check_order_admin()
		{	
			// reward points per user shown in admin panel
			include_once(PHOEN_REWPTSPLUGPATH.'includes/phoeniixx_rewpts_admin_panel.php');
			
		}
		
		
		//setting Tab
		
		function Phoeniixx_reward_settings_func() 	{ ?>

<div id="profile-page" class="wrap">

    <?php
					if(isset($_GET['tab']))
						
					{
						$tab = sanitize_text_field( $_GET['tab'] );
						
					}
					else
						
					{
						
						$tab="";
						
					}
					
				?>
    <h2> <?php _e('Reward Points For Woocommerce','phoen-rewpts'); ?></h2>

    <?php $tab = (isset($_GET['tab']))?$_GET['tab']:'';?>

    <h2 class="nav-tab-wrapper woo-nav-tab-wrapper">

        <a class="nav-tab <?php if($tab == 'phoen_rewpts_setting' || $tab == ''){ echo esc_html( "nav-tab-active" ); } ?>"
            href="?page=Phoeniixx_reward_settings&amp;tab=phoen_rewpts_setting"><?php _e('Settings','phoen-rewpts'); ?></a>
			<a class="nav-tab <?php if($tab == 'phoen_rewpts_set_points'){ echo esc_html( "nav-tab-active" ); } ?>"
            href="?page=Phoeniixx_reward_settings&amp;tab=phoen_rewpts_set_points"><?php _e('Set Points','phoen-rewpts'); ?></a>
		<a class="nav-tab <?php if($tab == 'phoen_rewpts_roles'){ echo esc_html( "nav-tab-active" ); } ?>"
            href="?page=Phoeniixx_reward_settings&amp;tab=phoen_rewpts_roles"><?php _e('Roles','phoen-rewpts'); ?></a>
        <a class="nav-tab <?php if($tab == 'phoen_rewpts_notification'){ echo esc_html( "nav-tab-active" ); } ?>"
            href="?page=Phoeniixx_reward_settings&amp;tab=phoen_rewpts_notification"><?php _e('Notification','phoen-rewpts'); ?></a>
        <a class="nav-tab <?php if($tab == 'phoen_rewpts_styling'){ echo esc_html( "nav-tab-active" ); } ?>"
            href="?page=Phoeniixx_reward_settings&amp;tab=phoen_rewpts_styling"><?php _e('Styling','phoen-rewpts'); ?></a>
        
        <a class="nav-tab <?php if($tab == 'phoen_rewpts_support'){ echo esc_html( "nav-tab-active" ); } ?>"
            href="?page=Phoeniixx_reward_settings&amp;tab=phoen_rewpts_support"><?php _e('Hire Us','phoen-rewpts'); ?></a>
        <!-- <a class="nav-tab <?php //if($tab == 'phoen_rewpts_how_to_install'){ echo esc_html( "nav-tab-active" ); } ?>"
            href="?page=Phoeniixx_reward_settings&amp;tab=phoen_rewpts_how_to_install"><?php// _e('How to install','phoen-rewpts'); ?></a> -->
        <a class="nav-tab <?php if($tab == 'phoen_rewpts_woo_app'){ echo esc_html( "nav-tab-active" ); } ?>"
            href="?page=Phoeniixx_reward_settings&amp;tab=phoen_rewpts_woo_app"><?php _e('Woocommerce app','phoen-rewpts'); ?></a>

    </h2>

</div>

<?php
			
			if($tab == 'phoen_rewpts_setting'|| $tab == ''){
				
				include_once(PHOEN_REWPTSPLUGPATH.'includes/admin/phoeniixx_reward_pagesetting.php');
				
			}
			else if($tab == 'phoen_rewpts_set_points'){
				
				include_once(PHOEN_REWPTSPLUGPATH.'includes/admin/phoen_rewpts_set_points.php');
				
			}else if($tab == 'phoen_rewpts_roles'){
				
				include_once(PHOEN_REWPTSPLUGPATH.'includes/admin/phoen_rewpts_roles.php');
				
			}
			else if($tab == 'phoen_rewpts_notification'){
				
				include_once(PHOEN_REWPTSPLUGPATH.'includes/admin/phoen_rewpts_notification.php');
				
			}

			else if($tab == 'phoen_rewpts_styling'){
				
				include_once(PHOEN_REWPTSPLUGPATH.'includes/admin/phoeniixx_reward_styling.php');
				
			}
			
			else if($tab == 'phoen_rewpts_support'){
				
				include_once(PHOEN_REWPTSPLUGPATH.'includes/admin/phoeniixx_reward_support.php');
				
			}
			else if($tab == 'phoen_rewpts_how_to_install'){
				
				include_once(PHOEN_REWPTSPLUGPATH.'includes/admin/phoeniixx_reward_how_to_install.php');
				
			}
			else if($tab == 'phoen_rewpts_woo_app'){
				
				include_once(PHOEN_REWPTSPLUGPATH.'includes/admin/phoeniixx_reward_woo_app.php');
				
			}
			
		}
		
		// shows message on cart for apply or remove reward points
		
		function phoen_rewpts_action_woocommerce_before_cal_table() { 
				
			$current_user = wp_get_current_user();
    
			global $woocommerce;
			
			$curr=get_woocommerce_currency_symbol();
			
			$gen_val = get_option('phoe_set_point_value');
					
			$reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:'';
			
			$reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:'';
			
			$reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:'';
			
			$reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:'';
			
			$reward_value=$reward_point/$reward_money;
			
			$reedem_value=$reedem_point/$reedem_money;

			$total_point_reward=phoen_rewpts_user_reward_point();
			
			//echo $admin_point  = get_post_meta(get_current_user_id(),'phoes_customer_points_update_valss',true);

			//$total_point_reward+= (is_number($admin_point))?$admin_point:0;
			
			$amt=round($total_point_reward/$reedem_value,2);
						
			if((round($total_point_reward)!=0)||((int)$total_point_reward>0))
			{
				$phoen_rewpts_notification_data = get_option('phoen_rewpts_notification_settings',true);
				$enable_apply_box_cart_page = isset($phoen_rewpts_notification_data['apply_box_enable_on_cart'])?$phoen_rewpts_notification_data['apply_box_enable_on_cart']:'1';
				$phoen_apply_box_notification_cart_page = isset($phoen_rewpts_notification_data['phoen_apply_box_notification_cart_page'])?$phoen_rewpts_notification_data['phoen_apply_box_notification_cart_page']:'You Will get {points} Points On Completing This Order';
				if($enable_apply_box_cart_page==1){
				
				$gen_settings=get_option('phoen_rewpts_custom_btn_styling');
	
				$apply_btn_title    = (isset($gen_settings['apply_btn_title']))?( $gen_settings['apply_btn_title'] ):'APPLY POINTS';
				$bill_price=phoen_rewards_cart_subtotal();
				$phoen_rewards_point = round($total_point_reward);
				if($bill_price>=$amt){
					$max_price = $phoen_rewards_point;
				}else{
					$max_price = $bill_price;
				}
				
				$phoen_apply_box_notification_cart_page = str_replace("{points}","$phoen_rewards_point",$phoen_apply_box_notification_cart_page);
				$phoen_rewards_point = str_replace("{price}","$curreny_symbol$amt",$phoen_apply_box_notification_cart_page);
				
					if(!in_array('reward amount',$woocommerce->cart->get_applied_coupons())){
					
						
						
							echo "<div  class='woocommerce-cart-notice woocommerce-cart-notice-minimum-amount woocommerce-info'>".$phoen_rewards_point."
							<a href='javascript:void(0);' id='apply_point_btn'>".$apply_btn_title."</a>
							<div class='phoen_rewpts_pts_link_div cart_apply_btn' style='display:none;'>
					
							<form method='post' action=''>
								
								<input type='number' name='phoe_set_point_value' min='0' max='".$max_price."' value='' placeholder='Enter the points' class='phoen_edit_points_input'>
								
								<input type='submit' class='button primary'  value='".$apply_btn_title."' name='apply_points'>
								
							</form>
					
						</div>
							
							
							
							</div>";
						
					}		
				}
			} 
		}
		
		// returns user reward amount
		
		function phoen_rewpts_user_reward_amount()
		{
			
			$total_point_reward=phoen_rewpts_user_reward_point();
			
			$gen_val = get_option('phoe_set_point_value');
					
			$reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:'';
			
			$reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:'';
			
			$reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:'';
			
			$reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:'';
			
			$reward_value=$reward_point/$reward_money;
			
			$reedem_value=$reedem_point/$reedem_money;
		
			$phoe_set_point_value=isset($_POST['phoe_set_point_value'])?$_POST['phoe_set_point_value']:'';
			if($phoe_set_point_value==''){
				return round($total_point_reward/$reedem_value,2);
			}else{
				return round($phoe_set_point_value/$reedem_value,2);
			}
		
			
		}
		function phoen_rewpts_my_account_endpoints() {
			add_rewrite_endpoint( 'reward-point', EP_ROOT | EP_PAGES );
		}
		
		add_action( 'init', 'phoen_rewpts_my_account_endpoints' );
		
		function phoen_rewpts_my_account_query_vars( $vars ) {
			$vars[] = 'reward-point';
		
			return $vars;
		}
		function phoen_rewpts_my_account_menu_items( $items ) {
			
			$items = array(
				'dashboard'         => __( 'Dashboard', 'woocommerce' ),
				'orders'            => __( 'Orders', 'woocommerce' ),
				'downloads'       => __( 'Downloads', 'woocommerce' ),
				'edit-address'    => __( 'Addresses', 'woocommerce' ),
				'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
				'edit-account'      => __( 'Edit Account', 'woocommerce' ),
				'reward-point'      => __( 'Reward Point', 'woocommerce' ),
				'customer-logout'   => __( 'Logout', 'woocommerce' ),
			);
		
			return $items;
		}
		
		add_filter( 'woocommerce_account_menu_items', 'phoen_rewpts_my_account_menu_items' );
		add_filter( 'query_vars', 'phoen_rewpts_my_account_query_vars', 0 );
		
		function phoen_rewpts_flush_rewrite_rules() {
			flush_rewrite_rules();
		}
		
		add_action( 'wp_loaded', 'phoen_rewpts_flush_rewrite_rules' );
		function phoen_rewpts_my_accountendpoint_content() {
			include 'includes/my-account/reward.php'; 
		}
		
		add_action( 'woocommerce_account_reward-point_endpoint', 'phoen_rewpts_my_accountendpoint_content' );
		function phoen_rewpts_my_account_user_reward_point()	{
			
			//$current_user = wp_get_current_user();
			
			global $woocommerce;
			
			$curr=get_woocommerce_currency_symbol();
			
			$argsm    = array('posts_per_page' => -1, 'post_type' => 'shop_order','post_status'=>array_keys(wc_get_order_statuses()));
			
			$products_order = get_posts( $argsm ); 
			
			$user_detail=get_users();
		
			$total_point_reward=array();
			
			$amount_spent=0;
			
			$order_count=0;
			
			$gen_val = get_option('phoe_set_point_value');
			
			$reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:'';
			
			$reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:'';
			
			$reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:'';
			
			$reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:'';
			
			$reward_value=$reward_point/$reward_money;
			
			$reedem_value=$reedem_point/$reedem_money;
			
			$current_user = wp_get_current_user();
			$cur_email = $current_user->user_email;
			
			for($i=0;$i<count($products_order);$i++)  	{	
				
				$products_detail=get_post_meta($products_order[$i]->ID); 
				
				$gen_settings=get_post_meta( $products_order[$i]->ID, 'phoe_rewpts_order_status', true );
				
		     	$order_email_id = $products_detail['_billing_email'][0];
				
				if(($order_email_id==$cur_email) && (is_array($gen_settings)))
				{
				
					$gen_settings=get_post_meta( $products_order[$i]->ID, 'phoe_rewpts_order_status', true );
					
					$get_reward_amount=isset($gen_settings['get_reward_amount'])?$gen_settings['get_reward_amount']:'';
					
					$get_reward_point=isset($gen_settings['get_reward_point'])?$gen_settings['get_reward_point']:'';
					
					$used_reward_point=isset($gen_settings['used_reward_point'])?$gen_settings['used_reward_point']:'';
					
					$order = wc_get_order($products_order[$i]->ID);
		
					$order_bill = phoen_reward_order_sub_total($order);
					
					$point_reward=0;
					
					if($products_order[$i]->post_status=="wc-completed")
					{
						$total_point_reward[$i]['order_id'] = $products_order[$i]->ID;
						$total_point_reward[$i]['amount_spent'] = $order->get_subtotal();
						$total_point_reward[$i]['reward_point'] = $get_reward_point;
						$total_point_reward[$i]['reward_amount'] = $get_reward_amount;
						$total_point_reward[$i]['total_reward_point'] = $total_point_reward[$i-1]['total_reward_point']+$get_reward_point-$used_reward_point;
						$total_point_reward[$i]['total_reward_amt'] = $total_point_reward[$i-1]['total_reward_amt']+$get_reward_amount;
						
					}
					
					$order_count++;
				}
				
			} 
			
			return $total_point_reward;
				
		}
				
		//return user reward points
		function phoen_rewpts_user_reward_point()	{
			
			//$current_user = wp_get_current_user();
			
			global $woocommerce;
			
			$curr=get_woocommerce_currency_symbol();
			
			$argsm    = array('posts_per_page' => -1, 'post_type' => 'shop_order','post_status'=>array_keys(wc_get_order_statuses()));
			
			$products_order = get_posts( $argsm ); 
			
			$user_detail=get_users();
		
			$total_point_reward=0;
			
			$amount_spent=0;
			
			$order_count=0;
			
			$gen_val = get_option('phoe_set_point_value');
			
			$reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:'';
			
			$reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:'';
			
			$reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:'';
			
			$reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:'';
			
			$reward_value=$reward_point/$reward_money;
			
			$reedem_value=$reedem_point/$reedem_money;
			
			$current_user = wp_get_current_user();
			$cur_email = $current_user->user_email;
			
			for($i=0;$i<count($products_order);$i++)  	{	
				
				$products_detail=get_post_meta($products_order[$i]->ID); 
				
				$gen_settings=get_post_meta( $products_order[$i]->ID, 'phoe_rewpts_order_status', true );
				
		     	$order_email_id = $products_detail['_billing_email'][0];
				
				if(($order_email_id==$cur_email) && (is_array($gen_settings)))
				{
				
					$gen_settings=get_post_meta( $products_order[$i]->ID, 'phoe_rewpts_order_status', true );
					
					$ptsperprice=isset($gen_settings['points_per_price'])?$gen_settings['points_per_price']:'';
					
					$get_reward_point=isset($gen_settings['get_reward_point'])?$gen_settings['get_reward_point']:'';
					
					$used_reward_point=isset($gen_settings['used_reward_point'])?$gen_settings['used_reward_point']:'';
					
					$order = wc_get_order($products_order[$i]->ID);
		
					$order_bill = phoen_reward_order_sub_total($order);
					
					$point_reward=0;
					
					if($products_order[$i]->post_status=="wc-completed")
					{
						$total_point_reward+= $get_reward_point-$used_reward_point;
						
					}
					
					$order_count++;
				}
				
			} 
			$admin_point  = get_post_meta(get_current_user_id(),'phoes_customer_points_update_valss',true);
			return $total_point_reward+$admin_point;
				
		}
		
		//add and display reward points to total if click on rmove points
		
		function phoen_rewpts_woo_add_cart_fee() {
				 
			global $woocommerce;
		
			$curr=get_woocommerce_currency_symbol();
			
			$amt=phoen_rewpts_user_reward_amount();
			$coupon_id = 'reward amount';
			if(in_array($coupon_id, $woocommerce->cart->get_applied_coupons())){
				return;
			}
			
			$bill_price=$woocommerce->cart->cart_contents_total;
				
			$u_price=0;
			
			if($amt>=$bill_price) 	{
				
				$u_price=$bill_price; 
			 
			}
			else if($amt<$bill_price){
				
				$u_price=$amt;
				
			} 
		
		
			$coupon_code = 'Reward Amount';
		
			if($u_price != ''){
			   
				$amount = $u_price; // Amount
				$discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product
				if($phoen_coupan_c_data=='')
				{		
					$coupon = array(
						'post_title' => $coupon_code,
						'post_content' => '',
						'post_status' => 'publish',
						'post_author' => 1,
						'post_type'  => 'shop_coupon'
					);
									   
					$new_coupon_id = wp_insert_post( $coupon );
				}				   
				// Add meta
				update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
				update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
				update_post_meta( $new_coupon_id, 'individual_use', 'no' );
				update_post_meta( $new_coupon_id, 'product_ids', '' );
				update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
				update_post_meta( $new_coupon_id, 'usage_limit', '' );
				update_post_meta( $new_coupon_id, 'expiry_date', '' );
				update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
				update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
			   
				// your coupon code here

				if ( $woocommerce->cart->has_discount( $coupon_code ) ) return;
				
					WC()->cart->add_discount( $coupon_code );
					
			}else{
				
				WC()->cart->remove_coupon( $coupon_code );
				
			}
		
		}
		
		// activation hook function
		
		function phoe_rewpts_activation_func() 	{
			
			$phoen_setting_data = get_option('phoe_set_point_value');
			
			if(empty($phoen_setting_data)){
				
				$phoe_set_point_value = array(
		
					'enable_plugin'=>1,
				
					'reward_point'=>1,
					
					'reward_money'=>1,
					
					'reedem_point'=>1,
			
					'reedem_money'=>1				
				);
									
					update_option('phoe_set_point_value',$phoe_set_point_value);
				
			}			
			
			$phoen_rewpts_notification_settings = get_option('phoen_rewpts_notification_settings');
		
			if($phoen_rewpts_notification_settings==''){
				
				$phoen_rewpts_notification_settings=array(
					'enable_plugin_product_page'=>1 ,
					'phoen_rewpts_notification_product_page'=>'You Will get {points} Points On Completing This Order.'  ,
					'enable_plugin_cart_page'=>1 ,
					'phoen_rewpts_notification_cart_page'=>'You Will get {points} Points On Completing This Order.'  ,
					'enable_plugin_checkout_page'=>1 ,
					'phoen_rewpts_notification_checkout_page'=>'You Will get {points} Points On Completing This Order.' ,
					'apply_box_enable_on_cart'=>1 ,
					'phoen_apply_box_notification_cart_page'=>'You can apply {points} Points to get {price} Discount.' ,
					'apply_box_enable_on_checkout'=>1 ,
					'phoen_apply_box_notification_checkout_page'=>'You can apply {points} Points to get {price} Discount.' ,
					
				);
				
				update_option('phoen_rewpts_notification_settings',$phoen_rewpts_notification_settings);
			}	
			
		}
		
		
		
		//remove reward points from total if click on rmove points
		/* function phoeniixx_rewpts_remove_fee_from_cart()
		{
			
			if(isset($_POST['remove_points'])) {	
				
				remove_action( 'woocommerce_after_calculate_totals','phoen_rewpts_woo_add_cart_fee',10,1);    
				
				$_SESSION['action']="remove";
			}
		} */
		
		//add reward points to total if click on rmove points
		function phoeniixx_rewpts_add_fee_from_cart()
		{
			
			if(isset($_POST['apply_points'])){	
			
				//add_action( 'woocommerce_after_calculate_totals', 'phoen_rewpts_woo_add_cart_fee', 10, 1); 
				
				//$_SESSION['action']="apply";
			/*} */
				$phoe_set_point_value=isset($_POST['phoe_set_point_value'])?$_POST['phoe_set_point_value']:'';
			
				if($phoe_set_point_value!='') 	{	
					
					add_action( 'woocommerce_after_calculate_totals', 'phoen_rewpts_woo_add_cart_fee',10, 1);
					phoen_rewpts_user_reward_amount();
					
					
					$_SESSION['action']= "apply";
					$_SESSION['points']= $phoe_set_point_value;
					
					?>

<?php
				}
			}
			
		}
	
		$gen_settings = get_option('phoe_set_point_value');
				
		$enable_plugin=isset($gen_settings['enable_plugin'])?$gen_settings['enable_plugin']:'';
		
		register_activation_hook( __FILE__, 'phoe_rewpts_activation_func');
		
		if($enable_plugin==1)
		{
			session_start();
		
			if(isset($_SESSION['action']) && $_SESSION['action']=="remove")
			{
				// remove reward points from  order or review order page when remove points click is done on cart page
				
				//remove_action( 'woocommerce_cart_calculate_fees','phoen_rewpts_woo_add_cart_fee',10,1);    
				
			}
			
			if(isset($_SESSION['action']) && $_SESSION['action']=="apply")
			{
				// add reward points to  order or review order page when apply points click is done on cart page
				
				//add_action( 'woocommerce_cart_calculate_fees', 'phoen_rewpts_woo_add_cart_fee', 10, 1); 
			}
			
			// add reward to cart page
			
			add_action( 'wp_loaded', 'phoeniixx_rewpts_add_fee_from_cart',30);
			
			//remove rewards from cart
			//add_action( 'wp_loaded', 'phoeniixx_rewpts_remove_fee_from_cart', 2);
			
			// save data in post meta when click on checkout in order page
			add_action( 'woocommerce_checkout_order_processed', 'phoen_rewpts_click_on_checkout_action',  1, 1  );
			
			//show message to add or remove rewards
			add_action( 'woocommerce_before_cart', 'phoen_rewpts_action_woocommerce_before_cal_table', 10, 0);
			
			$phoen_rewpts_notification_data = get_option('phoen_rewpts_notification_settings',true);
	
			$enable_plugin_product_page = isset($phoen_rewpts_notification_data['enable_plugin_product_page'])?$phoen_rewpts_notification_data['enable_plugin_product_page']:'1';
			
			$enable_plugin_cart_page = isset($phoen_rewpts_notification_data['enable_plugin_cart_page'])?$phoen_rewpts_notification_data['enable_plugin_cart_page']:'1';
			
			$enable_plugin_checkout_page = isset($phoen_rewpts_notification_data['enable_plugin_checkout_page'])?$phoen_rewpts_notification_data['enable_plugin_checkout_page']:'1';
			//add_action( 'woocommerce_before_add_to_cart_form', 'phoen_rewpts_single_product_action_get_reward_points', 10, 0);
			if($enable_plugin_product_page==1){
				add_action( 'woocommerce_single_product_summary', 'phoen_rewpts_single_product_action_get_reward_points', 10, 0);
			}

			// shows number of points to get on cart page
			if($enable_plugin_cart_page==1){
				add_action( 'woocommerce_before_cart_table', 'phoen_rewpts_action_get_reward_points', 10, 0);
			}
			
			if($enable_plugin_checkout_page==1){
				add_action( 'woocommerce_before_checkout_form', 'phoen_rewpts_checkout_action_get_reward_points', 10, 0);
			}
			
		}	
		
		add_action('wp_footer','phoe_rewpts_update_checkout_form');
		function phoe_rewpts_update_checkout_form(){
			?>
<script>
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document.body).on('updated_checkout', function() {
    /*Make an AJAX call on updated_checkout event*/
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            action: 'phoe_rewpts_update_notification'
        },
        success: function(result) {

            jQuery(".checkout_reward_notification").html(result);

        }
    });
});
</script><?php
		}
		
		add_action('wp_ajax_phoe_rewpts_update_notification', 'phoe_rewpts_update_notification');
		add_action('wp_ajax_nopriv_phoe_rewpts_update_notification', 'phoe_rewpts_update_notification');

		function phoe_rewpts_update_notification(){
			
			$gen_val = get_option('phoe_set_point_value');
	
			$reward_point=isset($gen_val['reward_point'])?$gen_val['reward_point']:'';
			
			$reedem_point=isset($gen_val['reedem_point'])?$gen_val['reedem_point']:'';
			
			$reward_money=isset($gen_val['reward_money'])?$gen_val['reward_money']:'';
			
			$reedem_money=isset($gen_val['reedem_money'])?$gen_val['reedem_money']:'';
			
			$reward_value=$reward_point/$reward_money;
			
			$reedem_value=$reedem_point/$reedem_money;
			
			$bill_price=phoen_rewards_cart_subtotal();
			$used_reward_amount = phoen_reward_redeem_point();
	
			if(empty($used_reward_amount))
			{
				$used_reward_amount = 0;
				
			}
			
			$phoen_rewpts_notification_data = get_option('phoen_rewpts_notification_settings',true);

			$enable_plugin_cart_page = isset($phoen_rewpts_notification_data['enable_plugin_cart_page'])?$phoen_rewpts_notification_data['enable_plugin_cart_page']:'1';
				
			$phoen_rewpts_notification_cart_page = isset($phoen_rewpts_notification_data['phoen_rewpts_notification_cart_page'])?$phoen_rewpts_notification_data['phoen_rewpts_notification_cart_page']:'You Will get {points} Points On Completing This Order';

			$phoen_rewards_point = round(($bill_price-$used_reward_amount)*$reward_value);
			
			echo str_replace("{points}","$phoen_rewards_point",$phoen_rewpts_notification_cart_page);
			
			die();
			
		}
	}else{
		
		add_action('admin_notices', 'phoen_rewpts_admin_notice');

		function phoen_rewpts_admin_notice() {
			
			global $current_user ;
				
				$user_id = $current_user->ID;
				
				/* Check that the user hasn't already clicked to ignore the message */
			
			if ( ! get_user_meta($user_id, 'phoen_rewpts_ignore_notice') ) {
				
				echo '<div class="error"><p>'; 
				
				printf(__('Woocommerce Reward Points could not detect an active Woocommerce plugin. Make sure you have activated it. | <a href="%1$s">Hide Notice</a>'), '?phoen_rewpts_nag_ignore=0');
				
				echo "</p></div>";
			}
		}

		add_action('admin_init', 'phoen_rewpts_nag_ignore');

		function phoen_rewpts_nag_ignore() {
			
			global $current_user;
				
				$user_id = $current_user->ID;
				
				/* If user clicks to ignore the notice, add that to their user meta */
				
				if ( isset($_GET['phoen_rewpts_nag_ignore']) && '0' == $_GET['phoen_rewpts_nag_ignore'] ) {
					
					add_user_meta($user_id, 'phoen_rewpts_ignore_notice', 'true', true);
				}
		}
		
		
	} ?>
