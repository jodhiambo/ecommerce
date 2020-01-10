<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/eCommerce/core/init.php';
	$mode = sanitize($_POST['mode']);
	$edit_size = sanitize($_POST['edit_size']);
	$edit_id = sanitize($_POST['edit_id']);
	$cartq = $con->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$result = mysqli_fetch_assoc($cartq);
	$items = json_decode($result['items'],true);
	$updated_items = array();
	$domain = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);
	if($mode == 'remove'){
		foreach ($items as $item) {
			if($item['id'] == $edit_id && item['size'] == $edit_size){
				$item['quantity'] = $item['quantity'] - 1;

			}
			if($item['quantity'] > 0){
				$updated_items[] = $item;
			}
		
		}

	}
	if($mode == 'add'){
			foreach ($items as $item) {
			if($item['id'] == $edit_id && item['size'] == $edit_size){
				$item['quantity'] = $item['quantity'] + 1;

			}
			
			$updated_items[] = $item;
			
		
		}

	}
	if(!empty($updated_items)){
		$json_update = json_encode($updated_items);
		$con->query("UPDATE cart SET items = '{$json_updated}' WHERE id = {$cart_id}");
		$_SESSION['success_flush'] = 'your shopping cart is updates succesfully!';

	}

	if(empty($updated_items)){
		$con->query("DELETE FROM cart WHERE id = '{$cart_id}'");
		setcookie(CART_COOKIE,'',1,"/",$domain,false);
	}
	
?>