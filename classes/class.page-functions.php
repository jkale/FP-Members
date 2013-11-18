<?php
	class FP_Page_Functions {
		
		function __construct() {
			add_action ('add_meta_boxes', array( $this, 'fp_members_add_role_picker' ) );
			add_action ('save_post', array( $this, 'fp_members_save_roles_picked' ) );
		}
		
		function fp_members_add_role_picker() {
		    add_meta_box ('fp_members_role_picker', 'Restrict Access', array( &$this, 'fp_members_list_roles' ), 'page', 'side');
		}
	
		function fp_members_list_roles() {
		    global $post, $wp_roles;
			
		    // Use nonce for verification
		    echo '<input type="hidden" name="pf_tactical_picker_noncename" id="ci_tactical_picker_noncename" value="' .
		    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
				$picked = get_post_meta ($post->ID, 'available_roles', true);

				$display_roles = apply_filters( 'nav_menu_roles', $wp_roles->role_names );
				
				echo '<p class="howto">If any roles are ticked only users with those roles may view the page</p>';
				
				foreach($display_roles as $role_name => $readable_name)
				{
					echo '<p><label class="selectit"><input type="checkbox" name="picked_role['.$role_name.']" value="1"';
					
		    		if( is_array( $picked ) && is_int( array_search( $role_name, $picked ) ) ) echo 'checked';
		    			echo '/> '.$readable_name;
		    		echo '</label></p>';
				}
		}
	
		function fp_members_save_roles_picked($post_id) {
		    // a little authentication
			if ( !isset( $_POST['pf_tactical_picker_noncename'] ) )
				return $post_id;
			
		    if ( !wp_verify_nonce( $_POST['pf_tactical_picker_noncename'], plugin_basename(__FILE__) ))
		        return $post_id;
		
			$prev_setting = get_post_meta($post_id, 'available_roles', true);
		
			// return if there's no setting
			if ( !isset( $_POST['picked_role'] ) && $prev_setting == false ) 
				return $post_id;
	
		    // next check for an autosave; if so - don't do anything
		    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		        return $post_id;
			
		    $picked = $_POST['picked_role'];
		
			$sanitised_array = array();
		
			foreach ($picked as $role_name => $value) {
				$sanitised_array[] = $role_name;
			}

		    // add/update record (both are taken care of by update_post_meta)
		    update_post_meta ($post_id, 'available_roles', $sanitised_array);
		}
		
	}
	global $fp_page_functions;
	$fp_page_functions = new FP_Page_Functions();
?>