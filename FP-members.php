<?php
	/**
	 *	Factory Pattern Members
	 *
	 *
	 *	Plugin Name: Factory Pattern Members
	 *	Plugin URI: http://factorypattern.co.uk/plugins/fp-members
	 *	Description: Factory Pattern Members adds basic yet beautiful membership tools to your WordPress website. Use and enjoy.
	 *	Author: Factory Pattern
	 *	Version: 1.0
	 *	Author URI: http://factorypattern.co.uk
	 */
	if ( ! class_exists( "FP_Members" ) ) :
		
		class FP_Members {
		
			function __construct() {
				add_filter( 'admin_init', array( $this, 'fp_members_admin_init' ) );
				
				add_action('wp_loaded', array( $this, 'fp_members_roles' ) );
				
				// We don't want to exclude display if they're looking at items in the admin interface
		        if ( ! is_admin() ) {
					add_filter( 'wp_get_nav_menu_items', array( $this, 'fp_members_filter_menu_items' ), null, 3 );
				}
				
				// insert our own admin menu walker
		        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'fp_members_edit_nav_menu_walker' ), 10, 2 );
		
				// save the menu item meta
		        add_action( 'wp_update_nav_menu_item', array( $this, 'fp_members_nav_update'), 10, 3 );

		        // add meta to menu item
		        add_filter( 'wp_setup_nav_menu_item', array( $this, 'fp_members_setup_nav_item' ) );
		
				ob_start();
				add_filter( 'the_content', array( $this, 'fp_members_filter_content' ) );
				
				add_action( 'admin_menu', array( $this, 'fp_members_register_admin_pages' ) );
			}
			
		    /**
		     * Include required admin files.
		     *
		     * @access public
		     * @return void
		     */
		    function fp_members_admin_init() {
		      	/* include the custom admin walker */
		      	include_once( plugin_dir_path( __FILE__ ) . 'classes/class.admin-edit-menu-walker.php');
				/* Include the page functions	*/
				include_once( plugin_dir_path( __FILE__ ) . 'classes/class.page-functions.php');

		    }

			/**
		     * Override the Admin Menu Walker
		     * @since 1.0
		     */
		    function fp_members_edit_nav_menu_walker( $walker, $menu_id ) {
		        return 'Walker_Nav_Menu_Edit_Roles';
		    }
			
			function fp_members_register_admin_pages() {
				$menu_slug = 'fp-members-dashboard';
				
				add_menu_page( 'FP Members', 'Members', 'manage_options', $menu_slug, array( $this, 'fp_members_dashboard_view' ), plugins_url( 'myplugin/images/icon.png' ), 100 );
				add_submenu_page( $menu_slug, 'Page Settings', 'Pages', 'manage_options', 'fp-page-settings', array( $this, 'fp_members_options_view' ));
			}
			
			function fp_members_dashboard_view() {
				echo '<div class="wrap">HELLO</div>';
			}
			
			/** Draws up the menu options page */
			function fp_members_options_view() {
				if ( !current_user_can( 'manage_options' ) )  {
					wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
				}

				// See if the user has posted us some information
			    // If they did, this hidden field will be set to 'Y'
			    if( isset($_POST[ "data_submitted" ]) && $_POST[ "data_submitted" ] == 'Y' ) {

			        // Read their posted value
					$restricted_page_id = stripslashes($_POST[ "restricted_page_id" ]);
					
					if ( isset( $restricted_page_id ) )
			        	update_option( "fp_members_restricted_page_id", $restricted_page_id ); // Save the posted value in the database

			        // Put an settings updated message on the screen
				?>
				<div class="updated"><p><strong><?php _e('Settings saved', 'fp_members_settings_saved' ); ?></strong></p></div>
				<?php

				}

				$restricted_page_id = get_option("fp_members_restricted_page_id");

				include dirname(__FILE__)."/views/pages.php";
			}
		
			function fp_members_filter_menu_items( $items, $menu, $args ) {
				// print_r( $items );
				// Iterate over the items to search and destroy
				foreach ( $items as $key => $item ) {
					
					if( isset( $item->roles ) ) {

						switch( $item->roles ) {
							case 'in' :
								$visible = is_user_logged_in() ? true : false;
							break;
							case 'out' :
								$visible = ! is_user_logged_in() ? true : false;
							break;
							default:
								$visible = false;
								if ( is_array( $item->roles ) && ! empty( $item->roles ) ) foreach ( $item->roles as $role ) {
									if ( current_user_can( $role ) ) $visible = true;
								}
								break;
						}
				  		if ( ! $visible ) unset( $items[$key] ) ;
					}

				}
				return $items;
			}
			
			/**
		     * Save the roles as menu item meta
		     * @return string
		     * @since 1.0
		     */
		    function fp_members_nav_update( $menu_id, $menu_item_db_id, $args ) {
		        global $wp_roles;

		        $allowed_roles = apply_filters( 'nav_menu_roles', $wp_roles->role_names );

		        // verify this came from our screen and with proper authorization.
		        if ( ! isset( $_POST['nav-menu-role-nonce'] ) || ! wp_verify_nonce( $_POST['nav-menu-role-nonce'], 'nav-menu-nonce-name' ) )
		            return;

		        $saved_data = false;

		        if ( isset( $_POST['nav-menu-logged-in-out'][$menu_item_db_id]  )  && in_array( $_POST['nav-menu-logged-in-out'][$menu_item_db_id], array( 'in', 'out' ) ) ) {
		              $saved_data = $_POST['nav-menu-logged-in-out'][$menu_item_db_id];
		        } elseif ( isset( $_POST['nav-menu-role'][$menu_item_db_id] ) ) {
		            $custom_roles = array();
		            // only save allowed roles
		            foreach( $_POST['nav-menu-role'][$menu_item_db_id] as $role ) {
		                if ( array_key_exists ( $role, $allowed_roles ) ) $custom_roles[] = $role;
		            }
		            if ( ! empty ( $custom_roles ) ) $saved_data = $custom_roles;
		        }

		        if ( $saved_data ) {
		            update_post_meta( $menu_item_db_id, '_nav_menu_role', $saved_data );
		        } else {
		            delete_post_meta( $menu_item_db_id, '_nav_menu_role' );
		        }
		    }

		    /**
		     * Adds value of new field to $item object
		     * is be passed to Walker_Nav_Menu_Edit_Custom
		     * @since 1.0
		     */
		    function fp_members_setup_nav_item( $menu_item ) {

		        $roles = get_post_meta( $menu_item->ID, '_nav_menu_role', true );

		        if ( ! empty( $roles ) ) {
		            $menu_item->roles = $roles;
		        }
		        return $menu_item;
		    }
		
			function fp_members_roles() {
				// create a new role for Members
				add_role('member', 'Member', array(
					'read' 			=> true
				));
			}
			
			function fp_members_filter_content( $content ) {
				global $post;

				$allowed_roles = get_post_meta( $post->ID, "available_roles", true );
				
				// No restriction; allow all to view
				if ( empty( $allowed_roles ) )
					return $content;
				
				$visible = false;
				
				foreach ( $allowed_roles as $index => $role ) {
					if ( current_user_can( $role ) ) $visible = true;
				}
				
				if ( $visible ) :
					return $content;
				else :
					$restricted_page_id = get_option("fp_members_restricted_page_id");
					
					if ( isset( $restricted_page_id  ) ) :
						$protected_page = get_page( $restricted_page_id );
					else :
						$protected_page = get_page( get_option('page_on_front') );
					endif;
					
					if ( isset( $protected_page ) ) :
						// Redirect to the protected page chosen
						wp_redirect( get_permalink( $protected_page->ID ) );
					else :
						wp_redirect( home_url() );
					endif;
					
					// Return the content from the protected page if the redirect fails
					return $protected_page->post_content;
				endif;
			}
		    
		}
		
	endif; // End class_exists test
	
	global $fp_members;
	$fp_members = new FP_Members();
?>