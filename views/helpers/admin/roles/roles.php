<?php
	/**
	 * Generates the roles checkboxes form
	 *
	 * @param array $param
	 */
	function desi_roles_check($param) {
	    // Get WP Roles
	    global $wp_roles;
		$all_capabilities = $wp_roles->roles['administrator']['capabilities'];

		// Generate HTML code
		foreach ($all_capabilities as $cap => $val) {
			
			// Filter out the old "levels" as these were deprecated in WP 3.0
			if (strpos( $cap, 'level' ) === false) {
			    echo '<input type="checkbox" name="capabilities[' . $cap . ']" id="capabilities[' . $cap . ']" checked/>  '.$cap.'<br />';
			}
			
		}
	}
?>