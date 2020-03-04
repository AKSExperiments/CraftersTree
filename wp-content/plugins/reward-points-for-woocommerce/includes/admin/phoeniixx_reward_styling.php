<?php if ( ! defined( 'ABSPATH' ) ) exit; 

	if ( ! empty( $_POST ) && check_admin_referer( 'phoen_rewpts_btncreate_action', 'phoen_rewpts_btncreate_action_field' ) ) {

		if(sanitize_text_field( $_POST['custom_btn'] ) == 'Save'){
			
			$apply_btn_title    = (isset($_POST['apply_btn_title']))?sanitize_text_field( $_POST['apply_btn_title'] ):'APPLY POINTS';
			
			
			
			$btn_settings=array(
				
					'apply_btn_title'		=>		$apply_btn_title
					
					
			);
			
			update_option('phoen_rewpts_custom_btn_styling',$btn_settings);
			
		}
	}

?>
	<div class="cat_mode">
			
		<form method="post" name="phoen_woo_btncreate">
			
			<?php $gen_settings=get_option('phoen_rewpts_custom_btn_styling');
			
					
			wp_nonce_field( 'phoen_rewpts_btncreate_action', 'phoen_rewpts_btncreate_action_field' ); ?>
					
			<table class="form-table" >
				
				
				<tr>
					
					<th>
					
						<?php _e('Apply Button title','phoen-rewpts'); ?>
						
					</th>
					
					<td>
						
						<input type="text" pattern="[a-zA-Z ]*$" title="Only alphabets is allow" class="apply_btn_title" name="apply_btn_title" value="<?php echo(isset($gen_settings['apply_btn_title'])) ?$gen_settings['apply_btn_title']:'APPLY POINTS';?>">
					
					</td>
				
				</tr>
						
			</table>
			<br />
		<input type="submit" class="button button-primary" value="Save" name="custom_btn">
		</form>
		<style>
		.form-table, .form-table td, .form-table td p, .form-table th {
  
			background: white;
		}
		</style>
	</div>