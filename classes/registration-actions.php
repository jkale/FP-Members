<?	
	function fp_add_payment_button() {
		
		$fp_pp = new FP_PayPal();
		$paypal_purchase = $fp_pp->subscription_payment();
		
	    //Get and set any values already sent
	    //$user_extra = ( isset( $_POST['user_extra'] ) ) ? $_POST['user_extra'] : '';
	    ?>

	    <p>
	        <?php $paypal_purchase->print_buy_button(); ?>
	    </p>

	    <?php
	}
	
	function fp_registration_pay()
	{
	    return plugins_url( ).'/fp-members/views/registration-pay.php';
	}
?>