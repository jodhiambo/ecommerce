<?php
 require_once 'core/init.php';
 include 'includes/head.php';
 include 'includes/navigation.php';
 // include 'includes/headerfull.php';
 // $_SESSION['cart'] = array();
 if ($cart_id != '') {
 	$cartq = $con->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
 	$result = mysqli_fetch_assoc($cartq);
 	$items = json_decode($result['items']);
 }
?>
 <div class="col-md-12">
 	<div class="row"><hr><br>
 			<a href="/eCommerce/index.php" alt="home" class="btn btn-warning text-right">Visit Home</a></b><br>
 		<h2 class="text-center"> My Shopping Cart</h2><br>
 			
 		<?php if(isset($_SESSION['cart']) == ''): ?>
 			<div class="bg-danger">
 				<p class="text-center text-danger"> Your Shopping Cart is empty please add something...</p>

 			</div>
 		<?php else: ?>
 			<table class="table table-border table-condensed table-striped ">
 				<thead>
 					<th>#</th>
 					<th>item</th>
 					<th>price</th>
 					<th>size</th>
 						<th>quantity</th>
 					<th>total</th>
 				</thead>
				<tbody> 
					 <?php
 $i= 1;
$item_count = 0;
 $sub_total = 0;
 $grand_total = 0;
 foreach ($_SESSION['cart'] as $product_id => $details) {
 	$data = explode(",", $details);
 	$quantity = $data[0];
 	$size = $data[1];

 	$cartq =$con->query("SELECT * FROM products WHERE id='$product_id'")or die(mysqli_error($con));
 	$result = mysqli_fetch_assoc($cartq);
 	// $items = json_decode($result['items'],true);var_dump($items);
 	
 	
 	$item_count += $quantity;
 	$total = $result['price'] * $quantity;
 	$size=explode(':',$result['sizes'])[0];
 	echo "<tr>
 	<td>{$i}</td>
	<td>{$result['title']}</td>
	<td>{$result['price']}</td>
	<td>{$size}</td>
	<td>{$quantity}</td>

	";
	?>
	 <!-- 	<td>
 			<button class="btn btn-xs btn-default" onclick="update_cart('remove','<?=$product['id']; ?>''<?=$result['size']; ?>');">-</button>
 			<?=$result['quantity']; ?>	
 			<button class="btn btn-xs btn-default" onclick="update_cart('add','<?=$product['id']; ?>''<?=$result['size']; ?>');">+</button>
 				<?php $available = $quantity;?>
 			<?php if($result['quantity'] < $available):?>
 			<?php else: ?>
 				<span class="text-danger">Max</span>
 		<?php endif; ?>

 			</td> -->
	<?php
	echo "<td>{$total}</td>
 	</tr>";
 	$sub_total = $sub_total +$total;
 	// $grand_total = $grand_total + $total;
 	$i++;
 }
?>
 <?php
 // echo $items;
 $items = $product_id;
 if(is_array($items)){
 	 foreach($items as $item ) {
 	$product_id = $value->id;
 	$productQ = $con->query("SELECT * FROM products WHERE id = '{$product_id}'");
 	$products = mysqli_fetch_assoc($productQ);
 	$sArray = explode(',', $products['sizes']);
 	foreach ($sArray as $sizeString ) {
 		$s = explode(':', $sizeString);
 		if($s[0] == $item['size']){
 			$available = $s[1];
 		}
 		# code...
 	}

 }
 	?>
 	<tr>
 		<td><?=$i;?></td>
 		<td><?=$products['title']?></td>
 		<td><?=money($products['price']); ?></td>
 		<td><?=$item['size'] ?></td>
 		<td><?=money($item['quantity'] * $products['size']); ?></td>
 	</tr>

 <?php 
	 $i =1;
	 for($i=1;$i<=12;$i++);
	 $item_count += $item['quantity'];
	 $sub_total += ($products['price'] * $item['quantity']);
}


	$tax = TAXRATE * $sub_total;
	// $tax = number_format($tax,2);
	$grand_total = $tax + $sub_total;
 ?>
 	</tbody>

</table>
	<table class="table table-bordered table-condensed text-right">
		<legend>Totals</legend>
		<thead class="totals-table-header bg-danger">
			<th>Total items</th>
			<th>sub total</th>
			<th>Tax</th>
			<th>Grand total</th>
		</thead>
		<tbody>
			<tr>
				<td><?=$item_count;?></td>
				<td><?=money($sub_total);?></td>
				<td><?=money($tax); ?></td>
				<td class="bg-success"><?=money($grand_total); ?></td>

			</tr>
		</tbody>
		
	</table>
	<!--check out button -->
	<button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#checkoutModal"> <span class="glyphicon glyphicon-shopping-cart"></span>Check Out >></button>			


	<!-- modal -->

	<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center" id="checkoutModalLabel">Shipping Address</h4>
				</div>
						<div class="modal-body">
							<div class="row">

							<form action="thankYou.php" method="post" id="payment-form">
								<span class="bg-danger" id="payment-errors"></span>
								<input type="hidden" name="tax" value="<?=$tax;?>">
								<input type="hidden" name="sub_total" value="<?=$sub_total ;?>">
								<input type="hidden" name="grand_total" value="<?=$grand_total ;?>">
								<input type="hidden" name="cart_id" value="<?=$cart_id ;?>">
								<input type="hidden" name="description" value="<?=$item_count.' item'.(($item_count>1)?'s':'').' from Instant Water And Drainage Solution';?>">
								<div id="step1" style="display: block;">
								

								<div class="from-group col-md-6">
									<label for="full_name">Full_name:</label>
									<input type="text" name="full_name" class="form-control" id="full_name">
								</div>
								<div class="from-group col-md-6">
									<label for="email">Email:</label>
									<input type="email" name="email" class="form-control" id="email">
								</div>

								<div class="from-group col-md-6">
									<label for="County">County:</label>
									<input type="text" name="county" class="form-control" id="county" data-stripe="address_county">
								</div>
				
								<div class="from-group col-md-6">
									<label for="Address">Shipping Address:</label>
									<input type="text" name="Address" class="form-control" id="Address" data-stripe="address_shipped">
								</div>
								
								<div class="from-group col-md-6">
									<label for="Town">Town:</label>
									<input type="text" name="town" class="form-control" id="town" data-stripe="address_town">
								</div>

								<div class="from-group col-md-6">
									<label for="Zip-code">Zip-code:</label>
									<input type="text" name="Zip-code" class="form-control" id="Zip-code" data-stripe="address_zip">
								</div>
								</div>
								<div id="step2" style="display: none;">
									<div class="from-group col-md-3">
										<label for="name">Name On Card:</label>
										<input type="text" id="name" class="form-control" data-stripe="name">
									</div>
									<div class="from-group col-md-3">
										<label for="name">card number:</label>
										<input type="text" id="number" class="form-control" data-stripe="number">
									</div>
									<div class="from-group col-md-3">
										<label for="cvc">CVC:</label>
										<input type="text" id="cvc" class="form-control" data-stripe="cvc">
									</div>
									<div class="from-group col-md-3">
										<label for="exp-month">Expire Month:</label>
										<select type="text" id="exp-month" class="form-control" data-stripe="exp_month">
										<?php for($i=1; $i<13;$i++): ?>
											<option value="<?=$i;?>"><?=$i;?></option>
										<?php endfor; ?>
										</select>
									</div>
								
									<div class="from-group col-md-3">
										<label for="name">Expire Year:</label>
										<select type="text" id="exp-year" class="form-control" data-stripe="exp_year">
											<option value=""></option>
											<?php $yr= date("Y"); ?>
											<?php for ($i=0; $i < 11 ; $i++): ?>
												<option value="<?=$yr+$i;?>"><?=$yr+$i;?></option>
											<?php endfor; ?>
											</select>
									</div>
								</div>
						</div>
				</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" onclick="back_address();" id="back_button" style="display: none;"><< Back</button>
			<button type="button" class="btn btn-primary" onclick="check_address();" id="next_button">Next Step>></button>
			<button type="submit" class="btn btn-primary" id="checkout_button" style="display: none;">CheckOut>></button>
			</form>
				
		</div>
			</div>
		</div>
	</div>

 		<?php endif; ?>
 	</div>
 </div>

 <script>
 	function back_address(){
 		jQuery('#payment-errors').html("");
 		jQuery('#step1').css("display","block");
 		jQuery('#step2').css("display","none");
 		jQuery('#Next_button').css("display","inline-block");
 		jQuery('#back_button').css("display","none");
 		jQuery('#checkout_button').css("display","none");
 		jQuery('#checkoutModalLabel').html("Shipping Address");

 	}
 	function check_address(){
 		var data = {
 			'full_name' : jQuery('#full_name').val(),
 			'email' : jQuery('#email').val(),
 			'County' : jQuery('#county').val(),
 			'town' : jQuery('#town').val(),
 			'Address' : jQuery('#Address').val(),
 			'Zip-code' : jQuery('#Zip-code').val(),
 		};

 		jQuery.ajax({
 			url : '/eCommerce/admin/pasas/check_address.php',
 			method : 'POST',
 			data : data,
 			success : function(data){
 				if(data != 'passed') {
 					jQuery('#payment-errors').html(data);
 				}
 			
 				if(data == 'passed') {
 					jQuery('#payment-errors').html("");
 					jQuery('#step1').css("display","none");
 					jQuery('#step2').css("display","block");
 					jQuery('#next_button').css("display","none");
 					jQuery('#back_button').css("display","inline-block");
 					jQuery('#checkout_button').css("display","inline-block");
 					jQuery('#checkoutModalLabel').html("Enter Your Card Details");
 				}
 			},
 			error : function(){alert("something went wrong");}
 		});
 	}

 	stripe.setPublishableKey('<?=STRIPE_PUBLIC;?>');

 	function stripeResponceHandler(status, response){
 		var $form = $('#payment-form');

 		if(response.error){
 			$form.find('#payment-errors').text(response.error.message);
 			$form.find('button').prop('disable', false);

 		}else{
 			//response contains id and card, which contains additional card details
 			var token = response.id;
 			//insert the token into form so it gets submitted to the server
 			$form.append($('<input type="hidden" name="stripeToken" />').val(token));
 			//and submit
 			$form.get(0).submit();
 		}
 	};
//  	var stripe = Stripe('pk_test_TYooMQauvdEDq54NiTphI7jx');
// var elements = stripe.elements();

// var card = elements.create('card');
// card.mount('#card-element');

// var promise = stripe.createToken(card);
// promise.then(function(result) {
//   // result.token is the card token.
// });
// // Set your secret key: remember to change this to your live secret key in production
// // See your keys here: https://dashboard.stripe.com/account/apikeys
// \Stripe\Stripe::setApiKey("sk_test_4eC39HqLyjWDarjtT1zdp7dc");

// $charge = \Stripe\Charge::create([
//     'amount' => 999,
//     'currency' => 'usd',
//     'source' => 'tok_visa',
//     'receipt_email' => 'jenny.rosen@example.com',
// ]);






 	jQuery(function($) {
 		$('#payment-form'),submit(function(event) {
 			var $form = $(this);

 			//disable the submit button to prevent repetition on clicks
 			$form.find('button').prop('disable', true);

 			Stripe.card.createToken($form, stripeResponseHandler);
 			//prevents the form from submitting with the default action
 			return false;
 		});
 	});
 </script>
 <?php include 'includes/footer.php'; ?>