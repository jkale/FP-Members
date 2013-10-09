<?php
	/**
	 * Generates the roles checkboxes form
	 *
	 * @param array $param
	 */
	function desi_roles_check($param) {
	    // Roles list
	    $settings = get_option($param[1]);
	    if (isset($settings[$param[0]])) {
	        $val = $settings[$param[0]];
	    }
	    else {
	        $val = '';
	    }
 
	    // Generate HTML Code
	    // Get WP Roles
	    global $wp_roles;
	    $roles = $wp_roles->get_names();
	    unset($roles['administrator']);
	    // Generate HTML code
	    if ($val['all'] === 'on') {
	        echo '<input type="checkbox" name="' . $param[1] . '[' . $param[0] . '][all]" id="' . $param[0] . '[all]" checked/>  All<br />';
	    }
	    else {
	        echo '<input type="checkbox" name="' . $param[1] . '[' . $param[0] . '][all]" id="' . $param[0] . '[all]" />  All<br />';
	    }
 
	    foreach ($roles as $key => $value) {
	        if ($val[$key] === 'on') {
	            echo '<input type="checkbox" name="' . $param[1] . '[' . $param[0] . '][' . $key . ']" id="' . $param[0] . '[' . $key . ']" checked />  ' . $value . '<br />';
	        }
	        else {
	            echo '<input type="checkbox" name="' . $param[1] . '[' . $param[0] . '][' . $key . ']" id="' . $param[0] . '[' . $key . ']" />  ' . $value . '<br />';
	        }
	    }
	}
?>