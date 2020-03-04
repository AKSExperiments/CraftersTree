<?php if ( ! defined( 'ABSPATH' ) ) exit;
	
if ( ! empty( $_POST ) && check_admin_referer( 'phoen_rewpts_form_action', 'phoen_rewpts_form_action_form_nonce_field' ) ) {

	if(sanitize_text_field( $_POST['rewpts_submit'] ) == 'Save'){
		
		$enable_plugin=sanitize_text_field($_POST['enable_plugin']);
		
		$reward_money=sanitize_text_field($_POST['reward_money']);
		
		$reedem_money=sanitize_text_field($_POST['reedem_money']);
		
		$reward_point=sanitize_text_field($_POST['reward_point']);
		
		$reedem_point=sanitize_text_field($_POST['reedem_point']);
		
		$phoe_set_point_value = array(
		
			'enable_plugin'=>$enable_plugin,
		
			'reward_point'=>$reward_point,
			
			'reward_money'=>$reward_money,
			
			'reedem_point'=>$reedem_point,
			
			'reedem_money'=>$reedem_money
		
		);
		
		update_option('phoe_set_point_value',$phoe_set_point_value);
		
	}
	
}

	$gen_settings = get_option('phoe_set_point_value');
	
	$enable_plugin=isset($gen_settings['enable_plugin'])?$gen_settings['enable_plugin']:'';
			
	$reward_point=isset($gen_settings['reward_point'])?$gen_settings['reward_point']:'';
	
	$reedem_point=isset($gen_settings['reedem_point'])?$gen_settings['reedem_point']:'';
	
	$reward_money=isset($gen_settings['reward_money'])?$gen_settings['reward_money']:'';
	
	$reedem_money=isset($gen_settings['reedem_money'])?$gen_settings['reedem_money']:'';
			
		
 ?>

	<div id="phoeniixx_phoe_book_wrap_profile-page"  class=" phoeniixx_phoe_book_wrap_profile_div">
	
		<form method="post" id="phoeniixx_phoe_book_wrap_profile_form" action="" >
		
			<?php wp_nonce_field( 'phoen_rewpts_form_action', 'phoen_rewpts_form_action_form_nonce_field' ); ?>
			
			<table class="form-table">
				
				<tbody>	
		
					<tr class="phoeniixx_phoe_rewpts_wrap">
				
						<th>
						
							<label><?php _e('Enable Reward','phoen-rewpts'); ?> </label>
							
						</th>
						
						<td>
						
							<input type="checkbox"  name="enable_plugin" id="enable_plugin" value="1" <?php echo(isset($gen_settings['enable_plugin']) && $gen_settings['enable_plugin'] == '1')?'checked':'';?>>
							
						</td>
						<td></td>
						
					</tr>
					<tr class="phoeniixx_phoe_rewpts_wrap">
				
						<th>
						
							<label><?php _e('Enable Product Based Reward Points','phoen-rewpts'); ?> </label>
							
						</th>
						
						<td>
						
							<input type="checkbox"  readonly name="enable_" id="enable_" value="1" <?php echo(isset($gen_settings['enable_plugin']) && $gen_settings['enable_plugin'] == '1')?'checked':'';?>>
							<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
						</td>
						<td></td>
						
					</tr>
					
					<tr class="phoeniixx_phoe_rewpts_wrap">
				
						<th>
						<?php  $curr=get_woocommerce_currency_symbol(); ?>
							
							
							<label><?php _e('Get Points For','phoen-rewpts');?> </label>
							
						</th>
						
						<td>
						
							<input type="number" step="any" min='0' required class="reward_money"  name="reward_money" value="<?php echo $reward_money; ?>"><?php echo  $curr; ?> =
							
							<input type="number" step="any" min='0' required class="reward_point" name="reward_point" value="<?php echo $reward_point; ?>" ><?php _e('Points ','phoen-rewpts');?>	
							
						</td>
						
					</tr>
					<tr class="phoeniixx_phoe_rewpts_wrap">
				
						<th>
						
						<label><?php _e('Redemption Value For ','phoen-rewpts');?> </label>
							
						</th>
						<td><input type="number" required step="any" min='0' class="reedem_point" name="reedem_point" value="<?php echo $reedem_point; ?>" ><?php _e('Points = ','phoen-rewpts');?>
							
						<input type="number" step="any" min='0' name="reedem_money" class="reedem_money" value="<?php echo $reedem_money; ?>" required>
						
						<?php echo $curr; ?>
						
						
							
						</td>
						
					</tr>
		
					
		
				</tbody>
				
			</table>
			<br />
			<input type="submit" value="Save" name="rewpts_submit" id="submit" class="button button-primary">
		</form>
		
		<style>
		.form-table, .form-table td, .form-table td p, .form-table th {
    
			background: white;
			padding-left:20px;
		}
		
		</style>
	</div>