<?php
	
	class Dovetail_Roles {
		
		function __construct() {
			
		}
		
		/**
		 *	Creates a new WordPress role to assign people to. Requires
		 *	a name for the role and the capabilities array as per 
		 *	WordPress guidelines for <code>add_role()</code> (http://codex.wordpress.org/Function_Reference/add_role)
		 */
		function create_role( $name, $capabilities ) {
			
			add_role( $name, ucwords( strtolower( $name ) ), $capabilities );
			
		}
		
	}

?>