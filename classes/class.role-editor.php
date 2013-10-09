<?php
	require_once 'class.roles.php';
	require_once dirname( __FILE__ ).'/../views/helpers/admin/roles/roles.php';
	
	/**
	 * Creates the membership levels interface where you can edit all the 
	 * details on that role.
	 */

	if ( ! class_exists( "Dovetail_Role_Editor" ) ) :
		
		class Dovetail_Role_Editor {
			
			function __construct() {
			
				add_action('init', 'dovetail_membership_level_custom_post', 0);
			
			}
	
	
			/**
			 *	Creates the custom post needed to add new roles
			 */
			function dovetail_role_editor_init() {
				
				add_action('init', 'dovetail_membership_level_custom_post', 0);
				add_action('add_meta_boxes', 'add_roles_meta_box', 10);
			}
		
			function dovetail_membership_level_custom_post() {
				echo "Creating CS type";
			
				// set the singular and plural label 
				$name = array(
					'singular'	=> 'Member Level',
					'plural'	=> 'Member Levels'
				);

				$args = array(
					'labels' => array(
						// set the various label values
						'name'			=> $name['plural'],
						'singular_name'		=> $name['singular'],
						'add_new'		=> 'Add ' . $name['singular'], 'report',
						'add_new_item'		=> 'Add New ' . $name['singular'],
						'edit_item'		=> 'Edit ' . $name['singular'],
						'new_item'		=> 'New ' . $name['singular'],
						'view_item'		=> 'View ' . $name['singular'],
						'search_items'		=> 'Search ' . $name['plural'],
						// the next two values should be lowercase
						'not_found'		=> 'No ' . strtolower($name['plural']) . ' found',
						'not_found_in_trash'	=> 'No ' . strtolower($name['plural']) . ' found in Trash', 
						'parent_item_colon'	=> ''
					),
					'supports' 	=> array('revisions', 'title', 'editor', 'excerpt', 'thumbnail'),
					'public'		=> TRUE,
					'publicly_queryable'	=> TRUE,
					'show_ui'		=> TRUE
				);

				// register the post type along with it's arguments
				register_post_type('member-level', $args);
			
			}// end of dovetail_membership_level_custom_post()
			
			function after_role_creation() {
				$slug = 'member-level';

			    // If this isn't a 'book' post, don't update it.
			    if ( $slug != $_POST['post_type'] ) {
			        return;
			    }
				
				$roles = New Dovetail_Roles();
				
				$roles->create_role(  );
			}
			
			function add_roles_meta_box( ) {
				echo "BUNNY";
				add_meta_box('desi_capabilities', 'Capabilities', 'desi_roles_check', 'member-level', 'side', 'default');
				
			}
			
		} // End of class
	
	endif; // End of class exists check
	
	$dovetail_role_class = new Dovetail_Role_Editor();

?>