<?php
	require_once( plugin_dir_path( __FILE__ ).'../../libs/paypal-digital-goods/paypal-digital-goods.class.php' );
	require_once( plugin_dir_path( __FILE__ ).'../../libs/paypal-digital-goods/paypal-subscription.class.php' );
	
	class FP_PayPal {
		private $api_username;
		private $api_password;
		private $api_signature;
		
		function __construct() {
			
			// $api_username = get_option( 'fp_paypal_username');
			// $api_password = get_option( 'fp_paypal_password');
			// $api_signature = get_option( 'fp_paypal_signature');
			$api_username = "rich-business_api1.factorypattern.co.uk";
			$api_password = "1371913120";
			$api_signature = "AFcWxV21C7fd0v3bYYYRCpSSRl31AbMh39co3pjz7Ej8Qr4IV6Fk3byE";
			
			//PayPal_Digital_Goods_Configuration::environment( 'live' );
			PayPal_Digital_Goods_Configuration::username( $api_username );
			PayPal_Digital_Goods_Configuration::password( $api_password );
			PayPal_Digital_Goods_Configuration::signature( $api_signature );

			PayPal_Digital_Goods_Configuration::return_url( plugins_url( ).'/fp-members/gateways/paypal/checkout.php' );
			PayPal_Digital_Goods_Configuration::cancel_url( get_bloginfo( 'wpurl' ).'/?payment=user_cancelled' );
			PayPal_Digital_Goods_Configuration::notify_url( plugins_url( ).'/fp-members/gateways/paypal/notify.php' );
			
		}
		
		function subscription_payment() {
			$subscription_details = array(
			    'description'        => 'Example Subscription: $10 sign-up fee then $2/week for the next four weeks.',
			    'initial_amount'     => '0.00',
			    'amount'             => '2.00',
			    'period'             => 'Day',
			    'frequency'          => '1', 
			    'total_cycles'       => '1',
			);

			$paypal_subscription = new PayPal_Subscription( $subscription_details );
			return $paypal_subscription;
		}
		
	}
?>