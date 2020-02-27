<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC_Advanced_Shipment_Tracking_Settings {		
	
	/**
	 * Initialize the main plugin function
	*/
    public function __construct() {								
		
		global $wpdb;
		if( is_multisite() ){			
			if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			}
			if ( is_plugin_active_for_network( 'woo-advanced-shipment-tracking/woocommerce-advanced-shipment-tracking.php' ) ) {
				$main_blog_prefix = $wpdb->get_blog_prefix(BLOG_ID_CURRENT_SITE);			
				$this->table = $main_blog_prefix."woo_shippment_provider";	
			} else{
				$this->table = $wpdb->prefix."woo_shippment_provider";
			}
		} else{
			$this->table = $wpdb->prefix."woo_shippment_provider";	
		}
			
	}
	
	/**
	 * Instance of this class.
	 *
	 * @var object Class Instance
	 */
	private static $instance;
	
	/**
	 * Get the class instance
	 *
	 * @return WC_Advanced_Shipment_Tracking_Settings
	*/
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	
	/*
	* init from parent mail class
	*/
	public function init(){
		
		//rename order status +  rename bulk action + rename filter
		add_filter( 'wc_order_statuses', array( $this, 'wc_renaming_order_status') );
		add_filter( 'woocommerce_register_shop_order_post_statuses', array( $this, 'filter_woocommerce_register_shop_order_post_statuses'), 10, 1 );
		add_filter( 'bulk_actions-edit-shop_order', array( $this, 'modify_bulk_actions'), 50, 1 );
		
		add_action( 'woocommerce_update_options_email_customer_delivered_order', array( $this, 'save_delivered_email' ) ,100, 1); 
		add_action( 'woocommerce_update_options_email_customer_partial_shipped_order', array( $this, 'save_partial_shipped_email' ) ,100, 1); 
		add_action( 'wp_ajax_sync_providers', array( $this, 'sync_providers_fun') );
		
		//new order status
		$newstatus = get_option( "wc_ast_status_delivered", 0);
		if( $newstatus == true ){
			//register order status 
			add_action( 'init', array( $this, 'register_order_status') );
			//add status after completed
			add_filter( 'wc_order_statuses', array( $this, 'add_delivered_to_order_statuses') );
			//Custom Statuses in admin reports
			add_filter( 'woocommerce_reports_order_statuses', array( $this, 'include_custom_order_status_to_reports'), 20, 1 );
			// for automate woo to check order is paid
			add_filter( 'woocommerce_order_is_paid_statuses', array( $this, 'delivered_woocommerce_order_is_paid_statuses' ) );
			//add bulk action
			add_filter( 'bulk_actions-edit-shop_order', array( $this, 'add_bulk_actions'), 50, 1 );
		}
		
		//new order status
		$updated_tracking_status = get_option( "wc_ast_status_updated_tracking", 0);
		if( $updated_tracking_status == true ){			
			//register order status 
			add_action( 'init', array( $this, 'register_updated_tracking_order_status') );
			//add status after completed
			add_filter( 'wc_order_statuses', array( $this, 'add_updated_tracking_to_order_statuses') );
			//Custom Statuses in admin reports
			add_filter( 'woocommerce_reports_order_statuses', array( $this, 'include_updated_tracking_order_status_to_reports'), 20, 1 );
			// for automate woo to check order is paid
			add_filter( 'woocommerce_order_is_paid_statuses', array( $this, 'updated_tracking_woocommerce_order_is_paid_statuses' ) );
			//add bulk action
			add_filter( 'bulk_actions-edit-shop_order', array( $this, 'add_bulk_actions_updated_tracking'), 50, 1 );
		}
		
		//new order status
		$partial_shipped_status = get_option( "wc_ast_status_partial_shipped", 0);
		if( $partial_shipped_status == true ){			
			//register order status 
			add_action( 'init', array( $this, 'register_partial_shipped_order_status') );
			//add status after completed
			add_filter( 'wc_order_statuses', array( $this, 'add_partial_shipped_to_order_statuses') );
			//Custom Statuses in admin reports
			add_filter( 'woocommerce_reports_order_statuses', array( $this, 'include_partial_shipped_order_status_to_reports'), 20, 1 );
			// for automate woo to check order is paid
			add_filter( 'woocommerce_order_is_paid_statuses', array( $this, 'partial_shipped_woocommerce_order_is_paid_statuses' ) );
			//add bulk action
			add_filter( 'bulk_actions-edit-shop_order', array( $this, 'add_bulk_actions_partial_shipped'), 50, 1 );
		}
		
		//filter in shipped orders
		add_filter( 'is_order_shipped', array( $this, "check_tracking_exist" ),10,2);
		add_filter( 'is_order_shipped', array( $this, "check_order_status" ),5,2);	
		
		// Hook for add admin body class in settings page
		add_filter( 'admin_body_class', array( $this, 'ahipment_tracking_admin_body_class' ) );
		
		// Ajax hook for open inline tracking form
		add_action( 'wp_ajax_ast_open_inline_tracking_form', array( $this, 'ast_open_inline_tracking_form_fun' ) );
		
		$wc_ast_status_delivered = get_option('wc_ast_status_delivered');		
		if($wc_ast_status_delivered == 1){
			add_action( 'woocommerce_order_actions', array( $this, 'add_order_meta_box_actions' ) );
			add_action( 'woocommerce_order_action_resend_delivered_order_notification', array( $this, 'process_order_meta_box_actions' ) );
		}
		
		$api_enabled = get_option( "wc_ast_api_enabled", 0);
		if( $api_enabled == true ){
			add_action( 'wp_dashboard_setup', array( $this, 'ast_add_dashboard_widgets') );	
		}
	}

	/** 
	 * Register new status : Delivered
	**/
	function register_order_status() {
		register_post_status( 'wc-delivered', array(
			'label'                     => __( 'Delivered', 'woo-advanced-shipment-tracking' ),
			'public'                    => true,
			'show_in_admin_status_list' => true,
			'show_in_admin_all_list'    => true,
			'exclude_from_search'       => false,
			'label_count'               => _n_noop( 'Delivered <span class="count">(%s)</span>', 'Delivered <span class="count">(%s)</span>', 'woo-advanced-shipment-tracking' )
		) );		
	}
	
	/** 
	 * Register new status : Updated Tracking
	**/
	function register_updated_tracking_order_status() {
		register_post_status( 'wc-updated-tracking', array(
			'label'                     => __( 'Updated Tracking', 'woo-advanced-shipment-tracking' ),
			'public'                    => true,
			'show_in_admin_status_list' => true,
			'show_in_admin_all_list'    => true,
			'exclude_from_search'       => false,
			'label_count'               => _n_noop( 'Updated Tracking <span class="count">(%s)</span>', 'Updated Tracking <span class="count">(%s)</span>', 'woo-advanced-shipment-tracking' )
		) );		
	}
	
	/** 
	 * Register new status : Partially Shipped
	**/
	function register_partial_shipped_order_status() {
		register_post_status( 'wc-partial-shipped', array(
			'label'                     => __( 'Partially Shipped', 'woo-advanced-shipment-tracking' ),
			'public'                    => true,
			'show_in_admin_status_list' => true,
			'show_in_admin_all_list'    => true,
			'exclude_from_search'       => false,
			'label_count'               => _n_noop( 'Partially Shipped <span class="count">(%s)</span>', 'Partially Shipped <span class="count">(%s)</span>', 'woo-advanced-shipment-tracking' )
		) );		
	}
	
	/*
	* add status after completed
	*/
	function add_delivered_to_order_statuses( $order_statuses ) {
		$new_order_statuses = array();
		foreach ( $order_statuses as $key => $status ) {
			$new_order_statuses[ $key ] = $status;
			if ( 'wc-completed' === $key ) {
				$new_order_statuses['wc-delivered'] = __( 'Delivered', 'woo-advanced-shipment-tracking' );				
			}
		}
		
		return $new_order_statuses;
	}
	
	/*
	* add status after completed
	*/
	function add_updated_tracking_to_order_statuses( $order_statuses ) {
		$new_order_statuses = array();
		foreach ( $order_statuses as $key => $status ) {
			$new_order_statuses[ $key ] = $status;
			if ( 'wc-completed' === $key ) {
				$new_order_statuses['wc-updated-tracking'] = __( 'Updated Tracking', 'woo-advanced-shipment-tracking' );				
			}
		}		
		return $new_order_statuses;
	}
	
	/*
	* add status after completed
	*/
	function add_partial_shipped_to_order_statuses( $order_statuses ) {
		$new_order_statuses = array();
		foreach ( $order_statuses as $key => $status ) {
			$new_order_statuses[ $key ] = $status;
			if ( 'wc-completed' === $key ) {
				$new_order_statuses['wc-partial-shipped'] = __( 'Partially Shipped', 'woo-advanced-shipment-tracking' );				
			}
		}		
		return $new_order_statuses;
	}
	
	/*
	* Adding the custom order status to the default woocommerce order statuses
	*/
	function include_custom_order_status_to_reports( $statuses ){
		if($statuses)$statuses[] = 'delivered';		
		return $statuses;
	}
	
	/*
	* Adding the updated-tracking order status to the default woocommerce order statuses
	*/
	function include_updated_tracking_order_status_to_reports( $statuses ){
		if($statuses)$statuses[] = 'updated-tracking';		
		return $statuses;
	}

	/*
	* Adding the partial-shipped order status to the default woocommerce order statuses
	*/
	function include_partial_shipped_order_status_to_reports( $statuses ){
		if($statuses)$statuses[] = 'partial-shipped';		
		return $statuses;
	}		
	
	/*
	* mark status as a paid.
	*/
	function delivered_woocommerce_order_is_paid_statuses( $statuses ) { 
		$statuses[] = 'delivered';		
		return $statuses; 
	}
	
	/*
	* mark status as a paid.
	*/
	function updated_tracking_woocommerce_order_is_paid_statuses( $statuses ) { 
		$statuses[] = 'updated-tracking';		
		return $statuses; 
	}

	/*
	* mark status as a paid.
	*/
	function partial_shipped_woocommerce_order_is_paid_statuses( $statuses ) { 
		$statuses[] = 'partial-shipped';		
		return $statuses; 
	}		
	
	/*
	* add bulk action
	* Change order status to delivered
	*/
	function add_bulk_actions( $bulk_actions ){
		$bulk_actions['mark_delivered'] = __( 'Change status to delivered', 'woo-advanced-shipment-tracking' );	
		return $bulk_actions;		
	}
	
	/*
	* add bulk action
	* Change order status to Updated Tracking
	*/
	function add_bulk_actions_updated_tracking( $bulk_actions ){
		$bulk_actions['mark_updated-tracking'] = __( 'Change status to Updated Tracking', 'woo-advanced-shipment-tracking' );
		return $bulk_actions;		
	}

	/*
	* add bulk action
	* Change order status to Partially Shipped
	*/
	function add_bulk_actions_partial_shipped( $bulk_actions ){
		$bulk_actions['mark_partial-shipped'] = __( 'Change status to Partially Shipped', 'woo-advanced-shipment-tracking' );
		return $bulk_actions;		
	}	
	
	/*
	* Rename WooCommerce Order Status
	*/
	function wc_renaming_order_status( $order_statuses ) {
		
		$enable = get_option( "wc_ast_status_shipped", 0);
		if( $enable == false )return $order_statuses;
		
		foreach ( $order_statuses as $key => $status ) {
			$new_order_statuses[ $key ] = $status;
			if ( 'wc-completed' === $key ) {
				$order_statuses['wc-completed'] = esc_html__( 'Shipped','woo-advanced-shipment-tracking' );
			}
		}		
		return $order_statuses;
	}
	
	/*
	* define the woocommerce_register_shop_order_post_statuses callback 
	* rename filter 
	* rename from completed to shipped
	*/
	function filter_woocommerce_register_shop_order_post_statuses( $array ) {
		
		$enable = get_option( "wc_ast_status_shipped", 0);
		if( $enable == false )return $array;
		
		if( isset( $array[ 'wc-completed' ] ) ){
			$array[ 'wc-completed' ]['label_count'] = _n_noop( 'Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>', 'woo-advanced-shipment-tracking' );
		}
		return $array; 
	}
	
	/*
	* rename bulk action
	*/
	function modify_bulk_actions($bulk_actions) {
		
		$enable = get_option( "wc_ast_status_shipped", 0);
		if( $enable == false )return $bulk_actions;
		
		if( isset( $bulk_actions['mark_completed'] ) ){
			$bulk_actions['mark_completed'] = __( 'Change status to shipped', 'woo-advanced-shipment-tracking' );
		}
		return $bulk_actions;
	}
	
	/*
	* tracking number filter
	* if number not found. return false
	* if number found. return true
	*/
	function check_tracking_exist( $value, $order ){
		
		if($value == true){
				
			$tracking_items = $order->get_meta( '_wc_shipment_tracking_items', true );
			if( $tracking_items ){
				return true;
			} else {
				return false;
			}
		}
		return $value;
	}		
	
	/*
	* If order status is "Updated Tracking" or "Completed" than retrn true else return false
	*/
	function check_order_status($value, $order){
		$order_status  = $order->get_status(); 
		
		$all_order_status = wc_get_order_statuses();
		
		$default_order_status = array(
			'wc-pending' => 'Pending payment',
			'wc-processing' => 'Processing',
			'wc-on-hold' => 'On hold',
			'wc-completed' => 'Completed',
			'wc-delivered' => 'Delivered',
			'wc-cancelled' => 'Cancelled',
			'wc-refunded' => 'Refunded',
			'wc-failed' => 'Failed'			
		);
		
		foreach($default_order_status as $key=>$value){
			unset($all_order_status[$key]);
		}
		
		$custom_order_status = $all_order_status;
		
		foreach($custom_order_status as $key=>$value){
			unset($custom_order_status[$key]);			
			$key = str_replace("wc-", "", $key);		
			$custom_order_status[] = $key;
		}
		
		if($order_status == 'updated-tracking' || $order_status == 'completed' || in_array($order_status, $custom_order_status)){
			return true;
		} else {
			return false;
		}
		return $value;				
	}
	
	/*
	* Add class in admin settings page
	*/
	public function ahipment_tracking_admin_body_class($classes){
		$page = (isset($_REQUEST["page"])?$_REQUEST["page"]:"");
		if( $page == 'woocommerce-advanced-shipment-tracking') {
			$classes .= 'shipment_tracking_admin_settings';
		}
        return $classes;
	}
	
	public function ast_open_inline_tracking_form_fun(){
		$order_id =  wc_clean($_POST['order_id']);		
		global $wpdb;
		$WC_Countries = new WC_Countries();
		$countries = $WC_Countries->get_countries();
		
		$woo_shippment_table_name = $wpdb->prefix . 'woo_shippment_provider';
		
		if( is_multisite() ){									
			if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			}
			if ( is_plugin_active_for_network( 'woo-advanced-shipment-tracking/woocommerce-advanced-shipment-tracking.php' ) ) {
				$main_blog_prefix = $wpdb->get_blog_prefix(BLOG_ID_CURRENT_SITE);			
				$woo_shippment_table_name = $main_blog_prefix."woo_shippment_provider";	
			} else{
				$woo_shippment_table_name = $wpdb->prefix."woo_shippment_provider";
			}
		} else{
			$woo_shippment_table_name = $wpdb->prefix."woo_shippment_provider";	
		}
		$shippment_countries = $wpdb->get_results( "SELECT shipping_country FROM $woo_shippment_table_name WHERE display_in_order = 1 GROUP BY shipping_country" );
		
		$shippment_providers = $wpdb->get_results( "SELECT * FROM $woo_shippment_table_name" );
		
		$default_provider = get_option("wc_ast_default_provider" );
		$wc_ast_default_mark_shipped = 	get_option("wc_ast_default_mark_shipped" );
		
		$wc_ast_status_shipped = get_option('wc_ast_status_shipped');
		if($wc_ast_status_shipped == 1){
			$change_order_status_label = __( 'Mark as Shipped?', 'woo-advanced-shipment-tracking' );
			$shipped_label = __( 'Shipped', 'woo-advanced-shipment-tracking' );		
		} else{
			$change_order_status_label = __( 'Mark as Completed?', 'woo-advanced-shipment-tracking' );
			$shipped_label = __( 'Completed', 'woo-advanced-shipment-tracking' );		
		}
		
		$wc_ast_status_partial_shipped = get_option('wc_ast_status_partial_shipped');
		ob_start();
		?>
		<div id="" class="trackingpopup_wrapper add_tracking_popup" style="display:none;">
			<div class="trackingpopup_row">
				<h3 class="popup_title"><?php _e( 'Add Tracking Number', 'woo-advanced-shipment-tracking'); ?></h2>
				<form id="add_tracking_number_form" method="POST" class="add_tracking_number_form">					
					<p class="form-field">
						<label for="tracking_number"><?php _e( 'Provider:', 'woo-advanced-shipment-tracking'); ?></label>
						<select class="chosen_select" id="tracking_provider" name="tracking_provider" style="width: 100%;max-width:100%;">
							<option value=""><?php _e( 'Provider:', 'woo-advanced-shipment-tracking' ); ?></option>
							<?php 
								foreach($shippment_countries as $s_c){
									if($s_c->shipping_country != 'Global'){
										$country_name = esc_attr( $WC_Countries->countries[$s_c->shipping_country] );
									} else{
										$country_name = 'Global';
									}
									echo '<optgroup label="' . $country_name . '">';
										$country = $s_c->shipping_country;				
										$shippment_providers_by_country = $wpdb->get_results( "SELECT * FROM $woo_shippment_table_name WHERE shipping_country = '$country' AND display_in_order = 1" );
										foreach ( $shippment_providers_by_country as $providers ) {											
											$selected = ( $default_provider == esc_attr( $providers->ts_slug )  ) ? 'selected' : '';
											echo '<option value="' . esc_attr( $providers->ts_slug ) . '" '.$selected. '>' . esc_html( $providers->provider_name ) . '</option>';
										}
									echo '</optgroup>';	
								 } ?>
						</select>
					</p>
					<p class="form-field tracking_number_field ">
						<label for="tracking_number"><?php _e( 'Tracking number:', 'woo-advanced-shipment-tracking'); ?></label>
						<input type="text" class="short" style="" name="tracking_number" id="tracking_number" value="" placeholder=""> 
					</p>
					<p class="form-field date_shipped_field">
						<label for="date_shipped"><?php _e( 'Date shipped:', 'woo-advanced-shipment-tracking'); ?></label>
						<input type="text" class="date-picker-field" style="" name="date_shipped" id="date_shipped" value="<?php echo date_i18n( __( 'Y-m-d', 'woo-advanced-shipment-tracking' ), current_time( 'timestamp' ) ); ?>" placeholder="<?php echo date_i18n( __( 'Y-m-d', 'woo-advanced-shipment-tracking' ), time() ); ?>">						
					</p>								
					<?php
					
					do_action("ast_tracking_form_between_form", $order_id);
					
					if($wc_ast_status_partial_shipped){ ?>
						<fieldset class="form-field change_order_to_shipped_field">
							<span><?php _e( 'Mark order as:', 'woo-advanced-shipment-tracking'); ?></span>
							<ul class="wc-radios">
								<li><label><input name="change_order_to_shipped" value="change_order_to_shipped" type="checkbox" class="select short mark_shipped_checkbox" <?php if($wc_ast_default_mark_shipped == 1){ echo 'checked'; }?>><?php _e( $shipped_label, 'woo-advanced-shipment-tracking'); ?></label></li>
								<li><label><input name="change_order_to_shipped" value="change_order_to_partial_shipped" type="checkbox" class="select short mark_shipped_checkbox"><?php _e( 'Partial Shipped', 'woo-advanced-shipment-tracking'); ?></label></li>
							</ul>
						</fieldset>		
					<?php } else{ ?>
						<p class="form-field change_order_to_shipped_field ">
							<label for="change_order_to_shipped"><?php echo $change_order_status_label; ?></label>
							<input type="checkbox" class="checkbox" style="" name="change_order_to_shipped" id="change_order_to_shipped" value="yes" <?php if($wc_ast_default_mark_shipped == 1){ echo 'checked'; }?>> 
						</p>
					<?php }	?>
					<p class="" style="text-align:left;">		
						<input type="hidden" name="action" value="add_inline_tracking_number">
						<input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
						<input type="submit" name="Submit" value="Save Tracking" class="button-primary btn_green">        
					</p>			
				</form>
			</div>
			<div class="popupclose"></div>
		</div>
		<?php
		$html = ob_get_clean();
		echo $html;exit;	
	}
	
	/*
	* define the item in the meta box by adding an item to the $actions array
	*/	
	function add_order_meta_box_actions( $actions ) {					
		$actions['resend_delivered_order_notification'] = __( 'Resend delivered order notification', 'woo-advanced-shipment-tracking' );
		return $actions;		
	}		
	
	/*
	* function call when resend delivered order email notification trigger
	*/	
	function process_order_meta_box_actions($order){
		require_once( 'email-manager.php' );
		$old_status = 'in_transit';
		$new_status = 'delivered';
		$order_id  = $order->get_id(); 	
		//wc_advanced_shipment_tracking_email_class()->delivered_shippment_status_email_trigger($order_id, $order, $old_status, $new_status);		
		WC()->mailer()->emails['WC_Email_Customer_Delivered_Order']->trigger( $order_id, $order );
	}
	
	/**
	* Add a new dashboard widget.
	*/
	public function ast_add_dashboard_widgets() {
		wp_add_dashboard_widget( 'trackship_dashboard_widget', 'Tracking Analytics <small>(last 30 days)</small>', array( $this, 'dashboard_widget_function') );
	}
	
	/**
	* Output the contents of the dashboard widget
	*/
	public function dashboard_widget_function( $post, $callback_args ) {
		
		wp_enqueue_script( 'amcharts');	
		wp_enqueue_script( 'amcharts-light-theme');	
		
		// Get orders completed.
		$args = array(
			//'status' => 'wc-completed',
			'limit'	 => -1,	
			'date_created' => '>' . ( time() - 2592000 ),
		);		
		$orders = wc_get_orders( $args );
		$shipment_trackers = 0;
		$shipment_status = array();
		$shipment_status_merge = array();
		$tracking_item_merge = array();
		foreach($orders as $order){
			$order_id = $order->get_id();
			
			$ast = new WC_Advanced_Shipment_Tracking_Actions;
			$tracking_items = $ast->get_tracking_items( $order_id, true );
			
			if($tracking_items){
				$shipment_status = get_post_meta( $order_id, "shipment_status", true);
				
				if(is_array($shipment_status)){
					$shipment_status_merge = array_merge($shipment_status_merge, $shipment_status);				
				}
				//echo '<pre>';print_r($shipment_status_merge);echo '</pre>';
				foreach ( $tracking_items as $key => $tracking_item ) { 				
					if( isset($shipment_status[$key]) ){							
						$tracking_item_merge[] = $tracking_item;						
						$shipment_trackers++;		
					}
				}								
			}			
		}
									
		$shipment_status_arr = array();

		foreach ((array)$shipment_status_merge as $key => $item) {
			$shipment_status_arr[$item['status']][$key] = $item;
		}
		
		$tracking_provider_arr = array();

		foreach ($tracking_item_merge as $key => $item) {
			$tracking_provider_arr[$item['formatted_tracking_provider']][$key] = $item;
		}
		
		$tracking_issue_array = array();
		foreach($shipment_status_arr as $status => $val){
			if($status == 'carrier_unsupported' || $status == 'INVALID_TRACKING_NUM' || $status == 'unknown' || $status == 'wrong_shipping_provider'){
				$tracking_issue_array[$status] = $val; 
			}
		}
		
		ksort($shipment_status_arr, SORT_NUMERIC);
		ksort($tracking_provider_arr, SORT_NUMERIC);
		
		
			
		?>
		<script type="text/javascript">
			 AmCharts.makeChart("ast_dashboard_status_chart",
				{
					"type": "serial",
					"categoryField": "shipment_status",
					"startDuration": 1,
					"handDrawScatter": 4,
					"theme": "light",
					"categoryAxis": {
						"autoRotateAngle": 0,
						"autoRotateCount": 0,
						"autoWrap": true,
						"gridPosition": "start",
						"minHorizontalGap": 10,
						"offset": 1
					},
					"trendLines": [],
					"graphs": [
						{
							"balloonText": " [[shipment_status]] : [[value]]",
							"bulletBorderThickness": 7,
							"colorField": "color",
							"fillAlphas": 1,
							"id": "AmGraph-1",
							"lineColorField": "color",
							"title": "graph 1",
							"type": "column",
							"valueField": "count"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": ""
						}
					],
					"allLabels": [],
					"balloon": {},
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": ""
						}
					],
					"dataProvider": [
						<?php								
						foreach($shipment_status_arr as $status => $array){ ?>
							{
								"shipment_status": "<?php echo apply_filters("trackship_status_filter",$status); ?>",
								"count": <?php echo count($array); ?>,
								"color": "#BBE285",								
							},
						<?php
						} ?>
					]					
				}
			);
		</script>
		<script type="text/javascript">
			 AmCharts.makeChart("ast_dashboard_providers_chart",
				{
					"type": "serial",
					"categoryField": "shipment_provider",
					"startDuration": 1,
					"handDrawScatter": 4,
					"theme": "light",
					"categoryAxis": {
						"autoRotateAngle": 0,
						"autoRotateCount": 0,
						"autoWrap": true,
						"gridPosition": "start",
						"minHorizontalGap": 10,
						"offset": 1
					},
					"trendLines": [],
					"graphs": [
						{
							"balloonText": " [[shipment_provider]] : [[value]]",
							"bulletBorderThickness": 7,
							"colorField": "color",
							"fillAlphas": 1,
							"id": "AmGraph-1",
							"lineColorField": "color",
							"title": "graph 1",
							"type": "column",
							"valueField": "count"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": ""
						}
					],
					"allLabels": [],
					"balloon": {},
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": ""
						}
					],
					"dataProvider": [
						<?php								
						foreach($tracking_provider_arr as $provider => $array){ ?>
							{
								"shipment_provider": "<?php echo $provider; ?>",
								"count": <?php echo count($array); ?>,
								"color": "#BBE285",	
							},
						<?php
						} ?>
					]					
				}
			);
		</script>		
		<div class="ast-dashborad-widget">			
			
			<input id="tab_s_providers" type="radio" name="tabs" class="widget_tab_input" checked>
			<label for="tab_s_providers" class="widget_tab_label first_label"><?php _e('Shipment Providers', 'woo-advanced-shipment-tracking'); ?></label>
			
			<input id="tab_s_status" type="radio" name="tabs" class="widget_tab_input">
			<label for="tab_s_status" class="widget_tab_label"><?php _e('Shipment Status', 'woo-advanced-shipment-tracking'); ?></label>
			
			<input id="tab_t_issues" type="radio" name="tabs" class="widget_tab_input">
			<label for="tab_t_issues" class="widget_tab_label"><?php _e('Tracking issues', 'woo-advanced-shipment-tracking'); ?></label>
			
			<section id="content_s_providers" class="widget_tab_section">
				<?php if($tracking_provider_arr){ ?>
					<div id="ast_dashboard_providers_chart" class="" style="width: 100%;height: 300px;"></div>
				<?php } else{ ?>
					<p style="padding: 8px 12px;"><?php _e('data not available.', 'woo-advanced-shipment-tracking'); ?></p>
				<?php } ?>
			</section>	
			
			<section id="content_s_status" class="widget_tab_section">	
				<?php if($shipment_status_arr){ ?>
					<div id="ast_dashboard_status_chart" class="" style="width: 100%;height: 300px;"></div>				
				<?php } else{ ?>
					<p style="padding: 8px 12px;"><?php _e('data not available.', 'woo-advanced-shipment-tracking'); ?></p>
				<?php } ?>
			</section>

			<section id="content_t_issues" class="widget_tab_section">	
				<?php if($tracking_issue_array){ ?>					
					<table class="table widefat fixed striped" style="border: 0;border-bottom: 1px solid #e5e5e5;">
						<tbody>
							<?php foreach($tracking_issue_array as $status => $array){ ?>
								<tr>
									<td><a href="<?php echo get_site_url(); ?>/wp-admin/edit.php?s&post_status=all&post_type=shop_order&_shop_order_shipment_status=<?php echo $status; ?>"><?php echo apply_filters("trackship_status_filter",$status); ?></a></td>
									<td><?php echo count($array); ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } else{ ?>
					<p style="padding: 8px 12px;"><?php _e('data not available.', 'woo-advanced-shipment-tracking'); ?></p>
				<?php } ?>
			</section>			
			
		</div>
		<div class="widget_footer">	
			<a class="" href="https://my.trackship.info/analytics/" target="blank"><?php _e( 'View more on TrackShip','woo-advanced-shipment-tracking' ); ?></a>
		</div>
	<?php }
	
	/**
	* Update Delivered order email enable/disable in customizer
	*/
	public function save_delivered_email($data){		
		$woocommerce_customer_delivered_order_enabled = (isset($_POST["woocommerce_customer_delivered_order_enabled"])?$_REQUEST["woocommerce_customer_delivered_order_enabled"]:"");
		update_option( 'customizer_delivered_order_settings_enabled',$woocommerce_customer_delivered_order_enabled);
	}
	
	/**
	* Update Partially Shipped order email enable/disable in customizer
	*/
	public function save_partial_shipped_email($data){
		$woocommerce_customer_partial_shipped_order_enabled = (isset($_POST["woocommerce_customer_partial_shipped_order_enabled"])?$_REQUEST["woocommerce_customer_partial_shipped_order_enabled"]:"");
		update_option( 'customizer_partial_shipped_order_settings_enabled',$woocommerce_customer_partial_shipped_order_enabled);
	}
	
	/**
	* Synch provider function 
	*/
	public function sync_providers_fun(){
		global $wpdb;		
		
		$url = 'https://trackship.info/wp-json/WCAST/v1/Provider';		
		$resp = wp_remote_get( $url );
		
		if ( is_array( $resp ) && ! is_wp_error( $resp ) ) {
			$providers = json_decode($resp['body'],true);
			
			$default_shippment_providers = $wpdb->get_results( "SELECT * FROM $this->table WHERE shipping_default = 1" );
			
			foreach ( $default_shippment_providers as $key => $val ){
				$shippment_providers[ $val->provider_name ] = $val;						
			}
	
			foreach ( $providers as $key => $val ){
				$providers_name[ $val['provider_name'] ] = $val;						
			}		
				
			$added = 0;
			$updated = 0;
			$deleted = 0;
			$added_html = '';
			$updated_html = '';
			$deleted_html = '';
			
			foreach($providers as $provider){
				
				$provider_name = $provider['shipping_provider'];
				$provider_url = $provider['provider_url'];
				$shipping_country = $provider['shipping_country'];
				$ts_slug = $provider['shipping_provider_slug'];
				
				if(isset($shippment_providers[$provider_name])){				
					$db_provider_url = $shippment_providers[$provider_name]->provider_url;
					$db_shipping_country = $shippment_providers[$provider_name]->shipping_country;
					$db_ts_slug = $shippment_providers[$provider_name]->ts_slug;
					if(($db_provider_url != $provider_url) || ($db_shipping_country != $shipping_country) || ($db_ts_slug != $ts_slug)){
						$data_array = array(
							'ts_slug' => $ts_slug,
							'provider_url' => $provider_url,
							'shipping_country' => $shipping_country,						
						);
						$where_array = array(
							'provider_name' => $provider_name,			
						);					
						$wpdb->update( $this->table, $data_array, $where_array);
						$updated_data[$updated] = array('provider_name' => $provider_name);
						$updated++;
					}
				} else{
					$img_url = $provider['img_url'];					
					$img_slug = sanitize_title($provider_name);
					$img = wc_advanced_shipment_tracking()->get_plugin_path().'/assets/shipment-provider-img/'.$img_slug.'.png';
					
					$ch = curl_init(); 
	
					curl_setopt($ch, CURLOPT_HEADER, 0); 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($ch, CURLOPT_URL, $img_url); 
				
					$data = curl_exec($ch); 
					curl_close($ch); 
					
					file_put_contents($img, $data); 			
								
									
					$data_array = array(
						'shipping_country' => sanitize_text_field($shipping_country),
						'provider_name' => sanitize_text_field($provider_name),
						'ts_slug' => $ts_slug,
						'provider_url' => sanitize_text_field($provider_url),			
						'display_in_order' => 0,
						'shipping_default' => 1,
					);
					$result = $wpdb->insert( $this->table, $data_array );
					$added_data[$added] = array('provider_name' => $provider_name);
					$added++;
				}		
			}		
			foreach($default_shippment_providers as $db_provider){
				if(!isset($providers_name[$db_provider->provider_name])){			
					$where = array(
						'provider_name' => $db_provider->provider_name,
						'shipping_default' => 1
					);
					$wpdb->delete( $this->table, $where );
					$deleted_data[$deleted] = array('provider_name' => $db_provider->provider_name);
					$deleted++;		
				}
			}
			if($added > 0){
				ob_start();
				$added_html = $this->added_html($added_data);
				$added_html = ob_get_clean();	
			}
			if($updated > 0){
				ob_start();
				$updated_html = $this->updated_html($updated_data);
				$updated_html = ob_get_clean();	
			}
			if($deleted > 0){
				ob_start();
				$deleted_html = $this->deleted_html($deleted_data);
				$deleted_html = ob_get_clean();	
			}
			
			$status = 'active';
			$default_shippment_providers = $wpdb->get_results( "SELECT * FROM $this->table WHERE display_in_order = 1" );	
			ob_start();
			$admin = new WC_Advanced_Shipment_Tracking_Admin;
			$html = $admin->get_provider_html($default_shippment_providers,$status);
			$html = ob_get_clean();	
			echo json_encode( array('added' => $added,'added_html' =>$added_html,'updated' => $updated,'updated_html' =>$updated_html,'deleted' => $deleted,'deleted_html' =>$deleted_html,'html' => $html) );exit;
		} else{
			echo json_encode( array('sync_error' => 1, 'message' => __( 'There are some issue with sync, Please Retry.', 'woo-advanced-shipment-tracking')) );exit;
		}	
	}
	
	/**
	* Output html of added provider from sync providers
	*/
	public function added_html($added_data){ ?>
		<ul class="updated_details" id="added_providers">
			<?php 
			foreach ( $added_data as $added ){ ?>
				<li><?php echo $added['provider_name']; ?></li>	
			<?php }
			?>
		</ul>
		<a class="view_synch_details" id="view_added_details" href="javaScript:void(0);" style="display: block;"><?php _e( 'view details', 'woo-advanced-shipment-tracking'); ?></a>
		<a class="view_synch_details" id="hide_added_details" href="javaScript:void(0);" style="display: none;"><?php _e( 'hide details', 'woo-advanced-shipment-tracking'); ?></a>
	<?php }

	/**
	* Output html of updated provider from sync providers
	*/
	public function updated_html($updated_data){ ?>
		<ul class="updated_details" id="updated_providers">
			<?php 
			foreach ( $updated_data as $updated ){ ?>
				<li><?php echo $updated['provider_name']; ?></li>	
			<?php }
			?>
		</ul>
		<a class="view_synch_details" id="view_updated_details" href="javaScript:void(0);" style="display: block;"><?php _e( 'view details', 'woo-advanced-shipment-tracking'); ?></a>
		<a class="view_synch_details" id="hide_updated_details" href="javaScript:void(0);" style="display: none;"><?php _e( 'hide details', 'woo-advanced-shipment-tracking'); ?></a>
	<?php }
	
	/**
	* Output html of deleted provider from sync providers
	*/
	public function deleted_html($deleted_data){ ?>
		<ul class="updated_details" id="deleted_providers">
			<?php 
			foreach ( $deleted_data as $deleted ){ ?>
				<li><?php echo $deleted['provider_name']; ?></li>	
			<?php }
			?>
		</ul>
		<a class="view_synch_details" id="view_deleted_details" href="javaScript:void(0);" style="display: block;"><?php _e( 'view details', 'woo-advanced-shipment-tracking'); ?></a>
		<a class="view_synch_details" id="hide_deleted_details" href="javaScript:void(0);" style="display: none;"><?php _e( 'hide details', 'woo-advanced-shipment-tracking'); ?></a>
	<?php }
}