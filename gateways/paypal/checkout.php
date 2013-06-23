<?php 
	$fp_pp = new FP_PayPal();
	$paypal_purchase = $fp_pp->subscription_payment();
	
	$paypal_purchase->start_subscription(); 
?>
<h1>Processed</h1>
<a href="/">Continue</a>