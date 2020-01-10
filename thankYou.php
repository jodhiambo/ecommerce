<?php
require_once 'core/init.php';
// \Stripe\Stripe::setApiKey($stripe['sk_test_14rAbVLiopNNEUlJdwZQ9AJt']);
\Stripe\Stripe::setApiKey('STRIPE_PRIVATE');

//get the credit card details submitted by the form
$token = $_POST['stripeToken'];
//get the rest of the postb data
$full_name = sanitize($_POST['full_name']); 
$email = sanitize($_POST['email']); 
$county = sanitize($_POST['county']); 
$shipping_address = sanitize($_POST['address']);
$town = sanitize($_POST['town']); 
$zip_code = sanitize($_POST['Zip_code']);
$sub_total = sanitize($_POST['sub_total']); 
$tax = sanitize($_POST['tax']);  
$cart_id= sanitize($_POST['cart_id']); 
$grand_total = sanitize($_POST['grand_total']); 
$description = sanitize($_POST['description']); 
$charge_amount = number_format($grand_total,2) * 100;
$metadata = array(
"cart_id" => $cart_id,
"tax" => $tax,
"sub_total" => $sub_total,
);
// var_dump($_POST['stripe-token']);
// print_r($token);

//create the charge on stripe's server -this will charge the users card 
try{
	$charge = \Stripe\Charge::create(array(
		"amount" => $charge_amount, //amount in cents 
		"currency" => CURRENCY,
		"source" => $_POST['stripeToken'],
		"description" => $description,
		"receipt_email" => $email, //dont receive it while on test mode
		"metadata" => $metadata,


	));

//DEMO
// 	require_once('vendor/autoload.php');
// $stripe = array(
//   'secret_key'      => '<YOUR SECRET STRIPE API KEY>',
//   'publishable_key' => '<YOUR PUBLISHABLE STRIPE API KEY>'
//   );
// \Stripe\Stripe::setApiKey($stripe['secret_key']);
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//   $charge = \Stripe\Charge::create(array(
//     'source'     => $_POST['stripeToken'],
//     'amount'   => 53500,
//     'currency' => 'usd'
//   ));


//adjust inventory
$itemQ = $con->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$iresults = mysqli_fetch_assoc($itemQ);
$items = json_decode($iresults['items'],true);
foreach($items as $item){
	$newSizes = array();
	$item_id = $item['id'];
	$productQ = $con->query("SELECT sizes FROM products WHERE id = '{$item_id}'");
	$product = sizesToArray($product['sizes']);
	foreach($sizes as $size){
		if($size['size'] == $item['size']){
			$q = $size['quantity'] - $item['quantity'];
			$newSizes[] = array('size' => $size['size'],'quantity' => $q);
		}else{
			$newSizes[] = array('size' => $size['size'],'quantity' => $size['quantity']);
		}
	}
	$sizeString = sizeToString($newSizes);
	$con->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
}





//update cart
$con->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
$con->query("INSERT INTO `transactions`(`sub_total`, `tax`,`grand_total`,`description`, `txn_type`, `exp_date`) VALUES ('{$sub_total}', `{$tax}`, '{$grand_total}', '{$description}', '{$charge->object}' )");
// $con->query("INSERT INTO transactions
// 	()

// 	");
$domain = ($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST']:false;
setcookie(CART_COOKIE,'',1,"/",$domain,false);
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
?>
<div>
	<h2 class="text-center text-success">Thank You for shopping with us!</h2>
	<p>your card was susscessfully charged <?=money($grand_total);?> and the receipt has been sent to your email. you can also print this page as your receipt if you cant access your email.</p>
	<p>your receipt number is: <strong><?=$cart_id;?></strong></p>
	<p>expect the order after 24hrs to the address below</p>
	<address>
		<?=$full_name;?><br>
		<?=$county;?><br>
		<?=$shipping_address;?>
		<?=$town;?>
	</address>
</div>
<?php

} 
catch(\Stripe\Error\Card $e){
	//the card has been declined

	echo $e;
}


?>