
<?php
	require_once '../core/init.php';
	if (!is_logged_in()) {
		login_error_redirect();
		header('Location: login.php');
	}
	if (!has_permission('admin')) {
		permission_error_redirect('brands.php');
		# code...
	}
	
	include 'includes/head.php';
	include 'includes/navigation.php';	
?>

<br><br><br><center><h3>this are the orders to transit to the customers</h3></center>

<!-- orders to fill -->
<?php
$txnQuery = "SELECT t.id, t.full_name, t.email, c.item, c.quantity, c.shipped, c.txn_id, t.description, t.grand_total, t.txn_date FROM transactions t 
LEFT JOIN cart c ON c.txn_id = t.id
WHERE c.paid = 0 AND c.shipped = 0
ORDER BY t.txn_date";

	$txnResults = $con->query($txnQuery);
?>

<div class="col-md-12">
	<h3 class="text-center">Orders To Ship</h3>
	<table class="table table-condensed table-bordered table-striped">
		<thead class="text-center">
			<th></th>
				<th>Name</th>
					<th>Description</th>
						<th>Total</th>
							<th>Date</th>
		</thead>
		<tbody>
			<?php while($order = mysqli_fetch_assoc($txnResults)): ?>
			<tr>
				<td><a href="orders.php?txn_id=<?=$order['id'];?>" class="btn btn-xs btn-info">Details</a></td>
				<td><?=$order['full_name'];?></td>
				<td><?=$order['description'];?></td>
				<td><?=money($order['grand_total']);?></td>
				<td><?=prety_date($order['txn_date']);?></td>
			</tr>

			<?php endwhile; ?>
		</tbody>
	</table>
</div>



<?php include 'includes/footer.php'; ?>