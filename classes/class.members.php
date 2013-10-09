<?php
	class Members {
		function __construct() {
			
		}
		
		function get_all_members() {
			$args = array(
				'role'					=> 'member',
				'orderby'				=> 'registered'
			);
			return get_users($args);
		}
		
		function get_role_count() {
			$roles = array();
			
			$args = array(
				'role'					=> 'member',
				'orderby'				=> 'registered',
				'count_total'					=> true
			);
			$members = get_users($args);
			//var_dump($members);
			
			$roles['Member'] = count( $members );
			
			return $roles;
		}
		
	}
?>