<?php
define ('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/eCommerce/');
define('CART_COOKIE', 'sbfa1245DFSVZsfbf');
define('CART_COOKIE_EXPIRE', time() +(86400 * 30));
define('TAXRATE', 0.004);

define('CURRENCY', 'ksh');
define('CHECKOUTMODE', 'TEST');

if(CHECKOUTMODE == 'TEST'){
	define('STRIPE_PRIVATE','sk_test_14rAbVLiopNNEUlJdwZQ9AJt');
	define('STRIPE_PUBLIC','pk_test_8tW5Vr1G4kHitcUX0VbUEXeZ');
}
if(CHECKOUTMODE == 'LIVE'){
	define('STRIPE_PRIVATE','');
	define('STRIPE_PUBLIC','');
}
// require_once('/vendor/stripe/init.php');

// $stripe = array( "secret_key" => "sk_test_14rAbVLiopNNEUlJdwZQ9AJt", "publishable_key" => "pk_test_8tW5Vr1G4kHitcUX0VbUEXeZ" );

// \Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
