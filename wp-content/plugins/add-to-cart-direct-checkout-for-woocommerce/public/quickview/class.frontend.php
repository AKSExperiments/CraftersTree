<?php

if (!defined( 'ABSPATH')) exit;
 
class pisol_quick_view_frontend{
	
	public $pisol_plugin_dir_url;
    public $pisol_options;
    public $pisol_style;

	function __construct($pisol_plugin_dir_url){

		$this->pisol_plugin_dir_url = $pisol_plugin_dir_url;

		$this->pi_dcw_quick_view_text = get_option('pi_dcw_quick_view_text', 'Quick View');
		$this->pi_dcw_quick_view_modal_bg_color = get_option('pi_dcw_quick_view_modal_bg_color', '#ffffff');

		$this->pi_dcw_quick_view_modal_padding = get_option('pi_dcw_quick_view_modal_padding', 10);

		$this->pi_dcw_quick_view_modal_text_color = get_option('pi_dcw_quick_view_modal_text_color', '#000000');

		$this->pi_dcw_quick_view_modal_close_bg_color = get_option('pi_dcw_quick_view_modal_close_bg_color', '#000000');
		$this->pi_dcw_quick_view_modal_close_color = get_option('pi_dcw_quick_view_modal_close_color', '#ffffff');

		

  		$this->pi_dcw_quick_view_bg_color = get_option('pi_dcw_quick_view_bg_color', '#ee6443');
  		$this->pi_dcw_quick_view_text_color = get_option('pi_dcw_quick_view_text_color', '#ffffff');

        add_action( 'wp_enqueue_scripts', array($this,'pisol_load_assets'));
		add_action( 'woocommerce_after_shop_loop_item', array($this,'pisol_add_button') );
		add_action( 'wp_footer', array($this, 'pisol_remodel_model'));
		add_action( 'wp_ajax_pisol_get_product', array($this,'pisol_get_product') );
        add_action( 'wp_ajax_nopriv_pisol_get_product', array($this,'pisol_get_product') );

        add_action('pisol_show_product_sale_flash','woocommerce_show_product_sale_flash');
        add_action('pisol_show_product_images', array($this,'pisol_woocommerce_show_product_images'));

        add_action( 'pisol_product_data', 'woocommerce_template_single_title');
        add_action( 'pisol_product_data', 'woocommerce_template_single_rating' );
        add_action( 'pisol_product_data', 'woocommerce_template_single_price');
        add_action( 'pisol_product_data', 'woocommerce_template_single_excerpt');
        add_action( 'pisol_product_data', 'woocommerce_template_single_add_to_cart');
        add_action( 'pisol_product_data', 'woocommerce_template_single_meta' );
 
	}
    



    public function pisol_woocommerce_show_product_images(){

		global $post, $product, $woocommerce;

		?>
		<div class="images">
		<?php 

        if ( has_post_thumbnail() ) {
			$attachment_count = count( $product->get_gallery_image_ids() );
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $props['url'], $props['caption'], $image ), $post->ID );
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
		}


		$attachment_ids = $product->get_gallery_image_ids();
		if ( $attachment_ids ) :
			$loop 		= 0;
			$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
			?>
			<div class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php
				foreach ( $attachment_ids as $attachment_id ) {
					$classes = array( 'thumbnail' );
					if ( $loop === 0 || $loop % $columns === 0 )
						$classes[] = 'first';
					if ( ( $loop + 1 ) % $columns === 0 )
						$classes[] = 'last';
					$image_link = wp_get_attachment_url( $attachment_id );
					if ( ! $image_link )
						continue;
					$image_title 	= esc_attr( get_the_title( $attachment_id ) );
					$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
					$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
						'title'	=> $image_title,
						'alt'	=> $image_title
						) );
					$image_class = esc_attr( implode( ' ', $classes ) );
					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" >%s</a>', $image_link, $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );
					$loop++;
				}
			?>
				
			</div>
		<?php endif; ?>
		</div>
		<?php
    }




	public function pisol_load_assets(){
        
        
		wp_enqueue_style  ( 'pisol_magnific',    $this->pisol_plugin_dir_url.'css/magnific-popup.css');
		wp_enqueue_style( 'pi_dtd_quickview_animate',$this->pisol_plugin_dir_url.'css/animate.min.css');
		wp_enqueue_script( 'pisol_magnific_script', $this->pisol_plugin_dir_url.'js/jquery.magnific-popup.min.js',array('jquery'),'1.0', true);
		
		wp_enqueue_style  ( 'pisol_remodal_default_css',    $this->pisol_plugin_dir_url.'css/quickview.css');
		wp_enqueue_script( 'pisol_quick_view', $this->pisol_plugin_dir_url.'js/quickview.js',array('jquery','pisol_magnific_script'),'1.0', true);

		$frontend_data = array(

		'pisol_nonce'          => wp_create_nonce('pisol_nonce'),
		'ajaxurl'             => admin_url( 'admin-ajax.php' ),
		'pisol_plugin_dir_url' => $this->pisol_plugin_dir_url
 

		);

		wp_localize_script( 'pisol_quick_view', 'pisol_frontend_obj', $frontend_data );
		
		wp_register_script( 'pisol_remodal_js',$this->pisol_plugin_dir_url.'js/remodal.js',array('jquery'),'1.0', true);
		wp_enqueue_script('pisol_remodal_js');

		global $woocommerce;
 
		$suffix      = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$lightbox_en = get_option( 'pi_dcw_quick_view_light_box',0 ) == 1 ? true : false;
		 
		if ( $lightbox_en ) {
		    wp_enqueue_script( 'prettyPhoto', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), '3.1.6', true );
		    wp_enqueue_style( 'woocommerce_prettyPhoto_css', $woocommerce->plugin_url() . '/assets/css/prettyPhoto.css' );
		}
		wp_enqueue_script( 'wc-add-to-cart-variation' );
		wp_enqueue_script('thickbox');

 
	    $custom_css = '
	    
	    .pisol-quick-view-box{
			background-color:'.$this->pi_dcw_quick_view_modal_bg_color.';
			padding:'.$this->pi_dcw_quick_view_modal_padding.'px;
	    }
	    
        .woocommerce a.quick_view{
			background-color: '.$this->pi_dcw_quick_view_bg_color.' ;
			color:'.$this->pi_dcw_quick_view_text_color.';
		}

		.pisol-quick-view-box .summary h1, .pisol-quick-view-box .summary p{
			color:'.$this->pi_dcw_quick_view_modal_text_color.';
		}
		.mfp-close-btn-in .mfp-close{
			background-color:'.$this->pi_dcw_quick_view_modal_close_bg_color.';
			color:'.$this->pi_dcw_quick_view_modal_close_color.';
		}
		';
        wp_add_inline_style( 'pisol_remodal_default_css', $custom_css );


         
	}


	public function pisol_remodel_model(){
 
		echo '<div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalDesc">
		  <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
		    <div id = "pisol_contend"></div>
		</div>';

		 
	}


	public function pisol_add_button(){

		global $post;
        echo '<a data-product-id="'.$post->ID.'"class="quick_view button pisol_quick_view_button" >
        <span>'.$this->pi_dcw_quick_view_text.'</span></a>';
	}


	public function pisol_get_product(){

		global $woocommerce;

		$suffix      = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$lightbox_en = get_option( 'woocommerce_enable_lightbox' ) == 'yes' ? true : false;

		
		global $post;
		$product_id = $_GET['product_id'];
		if(intval($product_id)){

			 wp( 'p=' . $product_id . '&post_type=product' );
 	         ob_start();
 	

			 while ( have_posts() ) : the_post(); ?>
			 <div class="pisol-quick-view-box animated fadeInDown">
	 	    <script>
		 	    var url = <?php echo "'"."$this->pisol_plugin_dir_url/js/prettyPhoto.init.js'"; ?>;
		 	    jQuery.getScript(url);
		 	    var wc_add_to_cart_variation_params = {"ajax_url":"\/wp-admin\/admin-ajax.php"};     
	            jQuery.getScript("<?php echo $woocommerce->plugin_url(); ?>/assets/js/frontend/add-to-cart-variation.min.js");
			 </script>
 	        <div class="product">  

					 <div id="product-<?php the_ID(); ?>" <?php post_class('product quick-view-container'); ?> >
					 			<div class="quick-view-product-image">  
 	                        	<?php do_action('pisol_show_product_sale_flash'); ?> 

 	                           <?php do_action( 'pisol_show_product_images' );  ?>
								</div>
	 	                        <div class="summary entry-summary scrollable">
	 	                                <div class="summary-content">   
	                                       <?php

	                                        do_action( 'pisol_product_data' );

	                                        ?>
	 	                                </div>
	 	                        </div>
 
 	                </div> 
 	        </div>
 	       
 	        <?php endwhile;

            	$post                  = get_post($product_id);
            	$next_post             = get_next_post();
			    $prev_post             = get_previous_post();
			    $next_post_id          = ($next_post != null)?$next_post->ID:'';
			    $prev_post_id          = ($prev_post != null)?$prev_post->ID:'';
			    $next_post_title       = ($next_post != null)?$next_post->post_title:'';
 		     	$prev_post_title       = ($prev_post != null)?$prev_post->post_title:'';
			 	$next_thumbnail        = ($next_post != null)?get_the_post_thumbnail( $next_post->ID,
			 		                  'shop_thumbnail',''):'';
 		     	$prev_thumbnail        = ($prev_post != null)?get_the_post_thumbnail( $prev_post->ID,
 		     		                   'shop_thumbnail',''):'';

 	        ?> 
			
			<?php 
			/* disabling the next and previous button */
			if(false): 
			?>
 	        <div class ="pisol_prev_data" data-pisol-prev-id = "<?php echo $prev_post_id; ?>">
 	        <?php echo $prev_post_title; ?>
 	            <?php echo $prev_thumbnail; ?> 
 	        </div> 
 	        <div class ="pisol_next_data" data-pisol-next-id = "<?php echo $next_post_id; ?>">
 	        <?php echo $next_post_title; ?>
 	             <?php echo $next_thumbnail; ?> 
			 </div> 
			<?php endif; ?>
		</div>
 	        <?php
 	                  
 	        echo  ob_get_clean();
 	
 	        exit();
            
			
	    }
	}
	
}

$pi_dcw_enable_quick_view_button = get_option('pi_dcw_enable_quick_view_button',0);

if($pi_dcw_enable_quick_view_button == 1){
	new pisol_quick_view_frontend(plugin_dir_url( __FILE__ ));
}
?>