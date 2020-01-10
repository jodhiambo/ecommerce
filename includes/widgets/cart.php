<h3 class="text-center">Shopping cart</h3>
<div>
	<?php if (empty($cart_id)): ?>
		<!-- <p>Your Shopping Cart is empty.</p> -->
	<?php else: 

			$cartq = $con->query("SELECT * FROM cart WHERE id={$cart_id}");
			$results = mysqli_fetch_assoc($cartq);
			$items = json_decode($results['items'],true);
			$i = 1;
			$sub_total =0;
			print_r($results);
		?>

	<table class="table table-condensed" id="cart_widget">
		<tbody>
			<?php foreach ($items as $items):
				$productQ = $con->query("SELECT * FROM products WHERE id='{$items['id']}'");
				$product = mysqli_fetch_assoc($productQ);
			  ?>
			  <tr>
			  	<td><?=$item['quantity'];?></td>
			  	<td><?=substr($product['title'],0,15);?></td>
			  	<td><?=money($item['quantity'] * $product['price']);?></td>
			  	<td></td>
			  </tr>
			<?php 
			$i++;
			$sub_total += ($item['quantity'] * $product['price']);
		endforeach; ?>
			<tr>
				<td>sub Total</td>
				<td><?=money($sub_total);?></td>
				<td></td>
			</tr>

		</tbody>
	</table>
	<a href="cart.php" class="btn btn-xs btn-primary pull-right">View Cart</a>
	<div class="clearfix"></div>


	<?php endif; ?>
</div>