<?php
/*
Plugin Name: Redirect Users by Role
Plugin URI:
Description: Redirects users based on their role
Version: 1.0
Author: Rahul Biswas
Author URI: http://test.com
License: GPLv2 or later
*/
 

if( !function_exists('cm_createRole') ) {
   function cm_createRole(){    
        add_role( 'custom_user1', 'Custom User 1', array( 'read' => true, 'level_0' => true ) );    
   }
   register_activation_hook( __FILE__, 'cm_createRole' );
}

if( !function_exists('cm_removeRole') ) {
    function cm_removeRole(){ 
        remove_role( 'custom_user1' );
    }
    register_deactivation_hook( __FILE__, 'cm_removeRole' );
}

////////////////////////////////////////////////////////////////////////////////

if( !function_exists('custom_meta_box_markup') ) {
    function custom_meta_box_markup(){
?> 
    <div class="checkbox">
        <label>
            <input type="checkbox" name="myCheckbox"            
            <?php 
                if ( get_post_meta( get_the_ID(), 'restricTEdURL', true ) ){
                    echo "checked";
                }            
            ?>            
            >Add URL
        </label>
    </div>

<?php }} ?>

<?php

if( !function_exists('add_custom_meta_box') ) {
    function add_custom_meta_box(){
        add_meta_box("demo-meta-box", "My Meta Box", "custom_meta_box_markup", "post", "side", "high", null);
    }  
    add_action("add_meta_boxes", "add_custom_meta_box"); 
}


function save_metabox_data( $post_id ) {
    
    if(isset($_POST["myCheckbox"])) {        
        $postId = get_the_ID();
        update_post_meta( $post_id = $postId, $key = 'restricTEdURL', $value = 'true' );        
    }else{
        $postId = get_the_ID();
        delete_post_meta($post_id = $postId, "restricTEdURL");
    }
     
}
add_action( 'edit_post', 'save_metabox_data' );

//////////////////////////////////////////////////////////////////////////////////

/**
 * @uses wp_get_current_user()          Returns a WP_User object for the current user
 */
if( !function_exists('restric_Users') ) {
    function restric_Users($user_id){

        // if(get_post_meta( get_the_ID(), 'restricTEdURL', true )){
        //    echo "test";
        // }

        // $user = wp_get_current_user();
        // $allowed_roles = array('editor', 'administrator', 'author');        
        // if( !array_intersect($allowed_roles, $user->roles ) ) {
        //     echo "This user has no role";
        // }
    }  
    add_action("init", "restric_Users"); 
}


?>