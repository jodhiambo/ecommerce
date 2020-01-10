<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/eCommerce/core/init.php';
	$name = sanitize($_POST['full_name']);
	$email = sanitize($_POST['email']);
	$county = sanitize($_POST['County']);
	$town = sanitize($_POST['town']);
	$shipping_address = sanitize($_POST['Address']);
	$zip_code = sanitize($_POST['Zip-code']);
	// var_dump($_POST);
	$errors = array();
	$required = array('full_name','email','County','town','Address','Zip-code');
	//check if all trequired fields are filled out
	foreach ($required as $field => $display) {
		if(empty($_POST[$display]) || $_POST[$display] == ''){
			$errors[$display] = $display.' is required.';
		}
		
	}
	//check if email is valid
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$errors['email'] = 'please enter a valid email address';
	}
	if (!empty($errors)) {
		echo display_errors($errors);
		return;
	}
	else{
		

		require_once $_SERVER['DOCUMENT_ROOT'].'/eCommerce/core/init.php';
		
		$insert_txn = $con->query("INSERT INTO `transactions`(`full_name`, `email`, `country`, `town`, `zip_code`) VALUES ( '{$name}', '{$email}', '{$county}', '{$town}', '{$zip_code}' )");
		$txn_id = $con->insert_id;
		

		// $_SESSION['cart'][$_POST['product_id']] = $_POST['quantity'].",".$_POST['size'];
		foreach ($_SESSION['cart'] as $product_id => $value) {
			$item_detail = explode(".", $value);

			//add the cart to the db and set cookie
			$cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
			$con->query("INSERT INTO cart(item,quantity,expire_date,txn_id) VALUES ('{$product_id}','{$item_detail[0]}','{$cart_expire}','{$txn_id}')");
			$cart_id = $con->insert_id;
			// setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE,'/',$domain,false);
		}

		//proceed to step 2
		echo "passed";

	}

?>