<?php

mail('rich@factorypattern.co.uk', 'IPN Start', "IPN Started");

include('../../libs/php-paypal-ipn/ipnlistener.php');

ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');

$listener = new IpnListener();
$listener->use_sandbox = true;

try {
    $verified = $listener->processIpn();
} catch (Exception $e) {
    // fatal error trying to process IPN.
	mail('rich@factorypattern.co.uk', 'IPN Failure', "IPN Failed to work");
    exit(0);
}

if ($verified) {
    mail('rich@factorypattern.co.uk', 'Verified IPN', $listener->getTextReport());
} else {
    mail('rich@factorypattern.co.uk', 'Invalid IPN', $listener->getTextReport());
}

?>