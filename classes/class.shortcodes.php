<?php
	class FP_Shortcodes {
		
		function __construct() {
			add_shortcode( "account_upgrade", array( $this, "fp_account_upgrade" ) );
		}
		
		function fp_account_upgrade() {
			$content = "";
			
			$fp_pp = new FP_PayPal();
			$paypal_purchase = $fp_pp->subscription_payment();
			
		    $content .= "<p>".$paypal_purchase->print_buy_button()."</p>";
		
			return $content;
		}
		
	}
?>