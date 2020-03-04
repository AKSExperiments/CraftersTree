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
				<tr class="phoen-user-user-login-wrap">
					
					<th>
					
						Remove Button title						
					</th>
					
					<td>
						
						<input readonly type="text" class="remove_btn_title" name="remove_btn_title" value="REMOVE POINTS">
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
				
				</tr>
				
				<tr class="phoen-user-user-login-wrap">
					
					<th>
					
						Coupon Name						
					</th>
					
					<td>
						
						<input type="text" readonly class="apply_reward_amount_title" name="apply_reward_amount_title" value="Reward Amount">
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
				
				</tr>
				
				<tr class="phoen-user-user-login-wrap">
					
					<th>
					
						Reward Points Notification Text Position on Cart Page						
					</th>
					
					<td>
					
						<select readonly name="phoen_select_text">
						
							<option value="below_cart" selected="">Below</option>
							<option value="above_cart">Above</option>
							
						</select>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
				
				</tr>
								
				<tr class="phoen-user-user-login-wrap">
					
					<th>
					
						Reward Points Notification Text Position on Product Page						
					</th>
					
					<td>
					
						<select readonly name="phoen_select_text_product_page">
						
							<option value="below_add_cart" selected="">Below Add To Cart</option>
							<option value="above_add_cart">Above Add To Cart</option>
							
						</select>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
				
				</tr>
				
				
				
				<tr class="phoen-user-user-login-wrap">

				<th> 
				
					Padding					
				</th>
					
					<td>
					
						<input readonly class="btn_num" placeholder="TOP" style="max-width:60px;font-size:12px;" min="0" name="apply_topmargin" type="number" value="8">
							
						<input readonly class="btn_num" placeholder="RIGHT" style="max-width:65px;font-size:12px;" min="0" name="apply_rightmargin" type="number" value="10">

						<input readonly class="btn_num" placeholder="BOTTOM" style="max-width:65px;font-size:12px;" min="0" name="apply_bottommargin" type="number" value="8">
							
						<input readonly class="btn_num" placeholder="LEFT" style="max-width:65px;font-size:12px;" min="0" name="apply_leftmargin" type="number" value="10"><span class="pixel-11">px</span>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>

				</tr>
				
				<tr class="phoen-user-user-login-wrap">
					
					<th>
					
						Button Background Color						
					</th>
					
					<td>
						
						<div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input readonly class="btn_color_picker btn_bg_col wp-color-picker" type="text" name="apply_btn_bg_col" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span><div class="wp-picker-holder"><div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;"><div class="iris-picker-inner"><div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a><div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div><div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div></div><div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));"><div class="iris-slider-offset ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all"><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="bottom: 0%;"></span></div></div></div><div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div></div></div></div>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
				
				</tr>
				
				
				
				<tr class="phoen-user-user-login-wrap">
					<th>
					
						Button Background Hover color						
					</th>
					
					<td>
					
						<div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input readonly class="btn_color_picker btn_hov_col wp-color-picker" type="text" name="apply_btn_hov_col" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span><div class="wp-picker-holder"><div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;"><div class="iris-picker-inner"><div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a><div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div><div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div></div><div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));"><div class="iris-slider-offset ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all"><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="bottom: 0%;"></span></div></div></div><div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div></div></div></div>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
					
				</tr>
				
				
				<tr class="phoen-user-user-login-wrap">
					<th>
					
						Button Text color						
					</th>
					
					<td>
						
						<div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(0, 0, 0);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input readonly class="btn_color_picker btn_txt_col wp-color-picker" type="text" name="apply_btn_txt_col" value="#000000"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span><div class="wp-picker-holder"><div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;"><div class="iris-picker-inner"><div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a><div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div><div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div></div><div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));"><div class="iris-slider-offset ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all"><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="bottom: 0%;"></span></div></div></div><div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div></div></div></div>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
					
				</tr>
				
				<tr class="phoen-user-user-login-wrap">
					<th>
					
						Button Text Hover color						
					</th>
					
					<td>
						
						<div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input readonly class="btn_color_picker btn_txt_col wp-color-picker" type="text" name="apply_btn_txt_hov_col" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span><div class="wp-picker-holder"><div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;"><div class="iris-picker-inner"><div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a><div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div><div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div></div><div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));"><div class="iris-slider-offset ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all"><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="bottom: 0%;"></span></div></div></div><div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div></div></div></div>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
					
				
				</tr><tr class="phoen-user-user-login-wrap">
				
					<th>
					
						Border Style						
					</th>
					
					<td>
					
												
						<select readonly name="apply_btn_border_style" class="btn_border_style">
							
							<option value="none" selected="">None</option>
							
							<option value="solid">Solid</option>
							
							<option value="dashed">Dashed</option>
							
							<option value="dotted">Dotted</option>
							
							<option value="double">Double</option>

						</select>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
					
				</tr>
				
				<tr class="btn_bor phoen-user-user-login-wrap">
					<th>
					
						Button Border Width						
					</th>
					
					<td>
					
						<input readonly class="btn_num" min="0" type="number" name="apply_btn_border" style="max-width:105px;" value="0">px					
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
					
				</tr>
								
				<tr class="btn_bor phoen-user-user-login-wrap">
					<th>
					
						Button border color						
					</th>
					
					<td>
						<div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input readonly class="btn_color_picker btn_bor_col wp-color-picker" type="text" name="apply_btn_bor_col" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span><div class="wp-picker-holder"><div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;"><div class="iris-picker-inner"><div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a><div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div><div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div></div><div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));"><div class="iris-slider-offset ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all"><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="bottom: 0%;"></span></div></div></div><div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div></div></div></div>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
					
				</tr>
				
				<tr class="phoen-user-user-login-wrap">
				
					<th>
					
						Button Radius						
					</th>
					
					<td>
					
						<input readonly class="btn_num" min="0" type="number" style="max-width:105px;" name="apply_btn_rad" value="0">px					
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
					
				</tr>
				
				<tr class="phoen-user-user-login-wrap">
				
					<th>
					
						Button Box Background Color						
					</th>
					
					<td>
					
						<div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(255, 255, 255);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input readonly class="btn_color_picker wp-color-picker" type="text" style="max-width:105px;" name="div_bg_col" value="#fff"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span><div class="wp-picker-holder"><div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;"><div class="iris-picker-inner"><div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 0px;"><span class="iris-square-handle ui-slider-handle"></span></a><div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div><div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div></div><div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(255, 0, 0), rgb(255, 255, 255));"><div class="iris-slider-offset ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all"><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="bottom: 0%;"></span></div></div></div><div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div></div></div></div>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
					
				</tr>
				
				
				
				
				<tr class="phoen-user-user-login-wrap">
				
					<th>
					
						Button Box Border Style						
					</th>
					
					<td>
					
												
						<select readonly name="div_border_style" class="div_border_style">
							
							<option value="none">None</option>
							
							<option value="solid" selected="">Solid</option>
							
							<option value="dashed">Dashed</option>
							
							<option value="dotted">Dotted</option>
							
							<option value="double">Double</option>

						</select>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
					
				</tr>
				
				<tr class="btn_bor phoen-user-user-login-wrap">
					<th>
					
						Button Box Border Width						
					</th>
					
					<td>
					
						<input readonly class="btn_num" min="0" type="number" name="div_border" style="max-width:105px;" value="1">px
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>					
					</td>
					
				</tr>
								
				<tr class="btn_bor phoen-user-user-login-wrap">
					<th>
					
						Button Box border color						
					</th>
					
					<td>
						<div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false" style="background-color: rgb(204, 204, 204);"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input readonly class="btn_color_picker btn_bor_col wp-color-picker" type="text" name="div_bor_col" value="#ccc"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span><div class="wp-picker-holder"><div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;"><div class="iris-picker-inner"><div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 36.425px;"><span class="iris-square-handle ui-slider-handle"></span></a><div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div><div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div></div><div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(204, 0, 0), rgb(204, 204, 204));"><div class="iris-slider-offset ui-slider ui-slider-vertical ui-widget ui-widget-content ui-corner-all"><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="bottom: 0%;"></span></div></div></div><div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div></div></div></div>
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>
					</td>
					
				</tr>
				
				<tr class="phoen-user-user-login-wrap">
				
					<th>
					
						Button Box Radius						
					</th>
					
					<td>
					
						<input readonly class="btn_num" min="0" type="number" style="max-width:105px;" name="div_rad" value="0">px	
						<a target="_blank" href="https://www.phoeniixx.com/product/reward-points-for-woocommerce/?utm_source=Wordpress&utm_medium=cpc&utm_campaign=Free%20Reward%20Point&utm_term=Free%20Reward%20Point&utm_content=Free%20Reward%20Point">Go To Premium</a>				
					</td>
					
				</tr>
						
			</table>
			<br />
		<input type="submit" class="button button-primary" value="Save" name="custom_btn">
		</form>
		<style>
		.form-table, .form-table td, .form-table td p, .form-table th {
  
			background: white;
			padding-left:20px;
		}
		</style>
	</div>