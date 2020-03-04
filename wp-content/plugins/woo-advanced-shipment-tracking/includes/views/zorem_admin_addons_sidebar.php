<?php
/**
 * html code for admin sidebar
 */
?>
<div class="zorem_admin_sidebar">
	<div class="zorem_admin_sidebar_inner">
		<?php $wc_ast_api_key = get_option('wc_ast_api_key'); ?>		
		<div class="zorem-sidebar__section">                    	
			<h3 class="top-border">Your opinion matters to us!</h3>
			<p>If you enjoy using The Advanced Shipment Tracking plugin, please take a minute and <a href="https://wordpress.org/support/plugin/woo-advanced-shipment-tracking/reviews/#new-post" target="_blank">share your review</a>		
			</p>        
		</div>    	
			
		<div class="zorem-sidebar__section">
			<h3 class="top-border">More plugins by zorem</h3>
			<?php
				$response = wp_remote_get('https://www.zorem.com/wp-json/pluginlist/v1' );
				if ( is_array( $response ) ) {
				$plugin_list = json_decode($response['body']);		
			?>	
			<ul>
				<?php foreach($plugin_list as $plugin){ 
					if( 'Advanced Shipment Tracking for WooCommerce' != $plugin->title && 'Tracking Per Item Add-on' != $plugin->title) { 
				?>
					<li><img class="plugin_thumbnail" src="<?php echo $plugin->image_url; ?>"><a class="plugin_url" href="<?php echo $plugin->url; ?>" target="_blank"><?php echo $plugin->title; ?></a></li>
				<?php }
				}?>
			</ul>  
			<?php } ?>	
		</div>
	</div>
</div>