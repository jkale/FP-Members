<?php
	/**
	 *	Encapsulates a user
	 */
	
	class Member {
		
		protected $wp_id;
		protected $wp_record;
		protected $first_name;
		protected $surname;
		protected $valid;
		
		/**
		 *	Constructs a user. Pass an id of a wordpress user
		 *	to have it automatically grab that user
		 */
		function __construct( $id = null ) {	
			
			$this->wp_id = $id;
			
			do_action( "dovetail_before_user_loaded" ); 
			
			$wp_record = new WP_User( $this->wp_id ); 
			
			do_action( "dovetail_wordpress_user_loaded" );
			
			if ( !$wp_record ) {
				$this->valid = false;
				return $this;
			} else {
				$this->first_name 		= $wp_record->first_name;
				$this->surname 			= $wp_record->last_name;
				
			}
			
			do_action( "dovetail_user_loaded" );

			return $this;
		}
		
		/*
		 *	Returns the full name of the user
		 */
		public function full_name() {
			
			return $this->first_name." ".$this->surname;
			
		}
		
	}

?>