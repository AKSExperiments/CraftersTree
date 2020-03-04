<?php if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! empty( $_POST ) && check_admin_referer( 'phoen_rewpts_notification_form_action', 'phoen_rewpts_notification_form_action_form_nonce_field' ) ) {

	if(sanitize_text_field( $_POST['rewpts_noti_submit'] ) == 'Save'){
		
		$enable_plugin_cart_page    = (isset($_POST['enable_plugin_cart_page']))?sanitize_text_field( $_POST['enable_plugin_cart_page'] ):'0';
			
		$phoen_rewpts_notification_cart_page    = isset($_POST['phoen_rewpts_notification_cart_page'])?$_POST['phoen_rewpts_notification_cart_page'] :'You Will get {points} Points On Completing This Order';
		
		$enable_plugin_checkout_page    = (isset($_POST['enable_plugin_checkout_page']))?sanitize_text_field( $_POST['enable_plugin_checkout_page'] ):'0';
		
		$phoen_rewpts_notification_checkout_page    = isset($_POST['phoen_rewpts_notification_checkout_page'])?$_POST['phoen_rewpts_notification_checkout_page'] :'You Will get {points} Points On Completing This Order';
		
		$apply_box_enable_on_cart    = (isset($_POST['apply_box_enable_on_cart']))?sanitize_text_field( $_POST['apply_box_enable_on_cart'] ):'0';

		$phoen_apply_box_notification_cart_page    = isset($_POST['phoen_apply_box_notification_cart_page'])?$_POST['phoen_apply_box_notification_cart_page'] :'You can apply {points} Points to get {price} Discount.';

		//$apply_box_enable_on_checkout    = (isset($_POST['apply_box_enable_on_checkout']))?sanitize_text_field( $_POST['apply_box_enable_on_checkout'] ):'0';
		
		//$phoen_apply_box_notification_checkout_page    = isset($_POST['phoen_apply_box_notification_checkout_page'])?$_POST['phoen_apply_box_notification_checkout_page'] :'You can apply {points} Points to get {price} Discount.';
			
		$btn_settings=array(
				
			'enable_plugin_cart_page'=>$enable_plugin_cart_page ,
			'phoen_rewpts_notification_cart_page'=>$phoen_rewpts_notification_cart_page ,
			'enable_plugin_checkout_page'=>$enable_plugin_checkout_page ,
			'phoen_rewpts_notification_checkout_page'=>$phoen_rewpts_notification_checkout_page ,
			'apply_box_enable_on_cart'=>$apply_box_enable_on_cart ,
			'phoen_apply_box_notification_cart_page'=>$phoen_apply_box_notification_cart_page ,
			//'apply_box_enable_on_checkout'=>$apply_box_enable_on_checkout ,
			//'phoen_apply_box_notification_checkout_page'=>$phoen_apply_box_notification_checkout_page ,
				
		
		);
			
		update_option('phoen_rewpts_notification_settings',$btn_settings);
		
	}
	
}

	$phoen_rewpts_notification_data = get_option('phoen_rewpts_notification_settings',true);
	
	$enable_plugin_cart_page = isset($phoen_rewpts_notification_data['enable_plugin_cart_page'])?$phoen_rewpts_notification_data['enable_plugin_cart_page']:'1';
	
	$phoen_rewpts_notification_cart_page = isset($phoen_rewpts_notification_data['phoen_rewpts_notification_cart_page'])?$phoen_rewpts_notification_data['phoen_rewpts_notification_cart_page']:'You Will get {points} Points On Completing This Order';
	
	$enable_plugin_checkout_page = isset($phoen_rewpts_notification_data['enable_plugin_checkout_page'])?$phoen_rewpts_notification_data['enable_plugin_checkout_page']:'1';
	
	$phoen_rewpts_notification_checkout_page = isset($phoen_rewpts_notification_data['phoen_rewpts_notification_checkout_page'])?$phoen_rewpts_notification_data['phoen_rewpts_notification_checkout_page']:'You Will get {points} Points On Completing This Order';
	
	$phoen_rewpts_notification_cart_apply_box = isset($phoen_rewpts_notification_data['apply_box_enable_on_cart'])?$phoen_rewpts_notification_data['apply_box_enable_on_cart']:'1';
	
	$phoen_apply_box_notification_cart_page = isset($phoen_rewpts_notification_data['phoen_apply_box_notification_cart_page'])?$phoen_rewpts_notification_data['phoen_apply_box_notification_cart_page']:'You can apply {points} Points to get {price} Discount.';
	
	//$phoen_rewpts_notification_checkout_apply_box = isset($phoen_rewpts_notification_data['apply_box_enable_on_checkout'])?$phoen_rewpts_notification_data['apply_box_enable_on_checkout']:'1';
		
	//$phoen_apply_box_notification_checkout_page = isset($phoen_rewpts_notification_data['phoen_apply_box_notification_checkout_page'])?$phoen_rewpts_notification_data['phoen_apply_box_notification_checkout_page']:'You can apply {points} Points to get {price} Discount.';
		
 ?>

	<div id="phoeniixx_phoe_book_wrap_profile-page"  class=" phoeniixx_phoe_book_wrap_profile_div">
	
		<form method="post" id="phoeniixx_phoe_book_wrap_profile_form" action="" >
		
			<?php wp_nonce_field( 'phoen_rewpts_notification_form_action', 'phoen_rewpts_notification_form_action_form_nonce_field' ); ?>
			
			<table class="form-table">
				
				<tbody>	
		
					<tr class="phoeniixx_phoe_rewpts_wrap phoen-user-user-login-wrap">
				
				<th>
				
					<label><?php _e('Enable Points Notification on Cart Page','phoen-rewpts'); ?> </label>
					
				</th>
				
				<td>
				
					<input type="checkbox"  name="enable_plugin_cart_page" id="enable_plugin_cart_page" value="1" <?php checked( $enable_plugin_cart_page, 1 ); ?> >
					
				</td>
				
			</tr>
			<tr class="phoeniixx_phoe_rewpts_wrap phoen-user-user-login-wrap">
				
				<th>
				
					<label><?php _e('Notification Message on Cart Page','phoen-rewpts'); ?> </label>
					
				</th>
				
				<td>
					<textarea rows="4" cols="30" name="phoen_rewpts_notification_cart_page"><?php echo esc_html($phoen_rewpts_notification_cart_page);?></textarea>
				<br />{points} number of points earned;
				</td>
				
			</tr>
			<tr class="phoeniixx_phoe_rewpts_wrap phoen-user-user-login-wrap">
				
				<th>
				
					<label><?php _e('Enable Points Notification on Checkout Page','phoen-rewpts'); ?> </label>
					
				</th>
				
				<td>
				
					<input type="checkbox"  name="enable_plugin_checkout_page" id="enable_plugin_checkout_page" value="1" <?php checked( $enable_plugin_checkout_page, 1 ); ?>>
					
				</td>
				
			</tr>
			<tr class="phoeniixx_phoe_rewpts_wrap phoen-user-user-login-wrap">
				
				<th>
				
					<label><?php _e('Notification Message on Checkout Page','phoen-rewpts'); ?> </label>
					
				</th>
				
				<td>
					<textarea rows="4" cols="30" name="phoen_rewpts_notification_checkout_page"><?php echo esc_html($phoen_rewpts_notification_checkout_page);?></textarea>
				<br />{points} number of points earned;
				</td>
				
			</tr>
			<tr class="phoen-user-user-login-wrap">
				
					<th>
					
						<label><?php _e('Enable Apply Point On Cart Page','phoen-rewpts'); ?> </label>
						
					</th>
					
					<td>
					
						<input type="checkbox"  name="apply_box_enable_on_cart" id="apply_box_enable_on_cart" value="1" <?php checked( $phoen_rewpts_notification_cart_apply_box, 1 ); ?>>
						
					</td>
					
			</tr>	
			<tr class="phoeniixx_phoe_rewpts_wrap phoen-user-user-login-wrap">
				
				<th>
				
					<label><?php _e('Apply Box Notification Message on Cart Page','phoen-rewpts'); ?> </label>
					
				</th>
				
				<td>
					<textarea rows="4" cols="30" name="phoen_apply_box_notification_cart_page"><?php echo esc_html($phoen_apply_box_notification_cart_page);?></textarea>
					<br />{points} number of points earned;<br />
					{price} amount of point;
				</td>
				
			</tr>

			
			
			
				</tbody>
				
			</table>
			<br />
			<input type="submit" value="Save" name="rewpts_noti_submit" id="submit" class="button button-primary">
		</form>
		
		<style>
		.form-table, .form-table td, .form-table td p, .form-table th {
    
			background: white;
			padding-left:20px;
		}
		
		</style>
	</div>