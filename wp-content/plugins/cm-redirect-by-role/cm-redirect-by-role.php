<?php
/*
Plugin Name: Restrict Content by Role
Plugin URI:
Description: Restricts content by redirecting users based on their role
Version: 1.1
Author: Rahul Biswas
Author URI: http://test.com
License: GPLv2 or later
*/

/*
Cases for:
    1. functions - snake_case
    2. Constants - CAPITALISED_SNAKE_CASE
    3. scoped variables - camelCase
*/

if ( !defined('CT_LTD') ) {
    define ( 'CT_LTD', 'ct_ltd' );
}
if ( !defined('CT_LTD_ARR') ) {
    define ( 'CT_LTD_ARR', [
        'editor',
        'administrator',
        'author',
        CT_LTD,
    ]);
}
if ( !defined('POST_TYPES') ) {
    define ( 'POST_TYPES', [
        "post",
        "page",
        "media",
        "product",
    ]);
}
if( !defined('META_KEY') ) {
    define ( 'META_KEY', 'restrictedURL' );
}
 

if( !function_exists('cm_createrole') ) {
   function cm_createrole(){    
        add_role( CT_LTD, 'CT Limited', array( 'read' => true, 'level_0' => true ) );    
   }
   register_activation_hook( __FILE__, 'cm_createrole' );
}

if( !function_exists('cm_removerole') ) {
    function cm_removerole(){ 
        remove_role( 'CT_LTD' );
    }
    register_deactivation_hook( __FILE__, 'cm_removerole' );
}

////////////////////////////////////////////////////////////////////////////////

if( !function_exists('custom_meta_box_markup') ) {
    function custom_meta_box_markup(){
?> 
    <div class="checkbox">
        <label>
            <input type="checkbox" name="myCheckbox"            
            <?php 
                if ( get_post_meta( get_the_ID(), 'restrictedURL', true ) ){
                    echo "checked";
                }            
            ?>            
            >Make it forbidden for the mortals
        </label>
    </div>

<?php }} ?>

<?php

if( !function_exists('add_custom_meta_box') ) {
    function add_custom_meta_box(){
        add_meta_box("demo-meta-box", "Restrict Content", "custom_meta_box_markup", POST_TYPES, "side", "high", null);
    }  
    add_action("add_meta_boxes", "add_custom_meta_box"); 
}


function save_metabox_data( $post_id ) {
    
    if(isset($_POST["myCheckbox"])) {        
        $postId = get_the_ID();
        update_post_meta( $post_id = $postId, $key = META_KEY, $value = 'true' );        
    }else{
        $postId = get_the_ID();
        delete_post_meta($post_id = $postId, "restrictedURL");
    }
     
}
add_action( 'edit_post', 'save_metabox_data' );

//////////////////////////////////////////////////////////////////////////////////

/**
 * @uses wp_get_current_user()          Returns a WP_User object for the current user
 */
if( !function_exists('restrict_by_meta') ) {

    function restrict_by_meta($query) {
        $user = wp_get_current_user();     
        if( !array_intersect(CT_LTD_ARR, $user->roles ) ) {
            if ( ! is_admin() && $query->is_main_query() ) {
                $query-> set('meta_query', array(
                    'relation' => 'OR',
                    array(
                        'key'     => META_KEY,
                        'value'   => 'true',
                        'compare' => '!=',
                    ),
                    array(
                        'key'     => META_KEY,
                        'compare' => 'NOT EXISTS'
                    ),
                ));
            }
        }
    }

    add_action('pre_get_posts', 'restrict_by_meta');
}


?>