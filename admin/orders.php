<?php
require_once '../core/init.php';
if(!is_logged_in()){
	header('Location login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

//Complete order
if(isset($_GET['complete']) && $_GET['complete'] == 1){
	$cart_id = sanitize((int)$_GET['cart_id']);
	$con->query("UPDATE cart SET shipped = 1 WHERE id = '{$cart_id}'");
	$_SESSION['success_flash'] = "The Order Has been completed";
	header('Location: index.php');

}


$txn_id = sanitize((int)$_GET['txn_id']);
$txnQuery = $con->query("SELECT * FROM transactions WHERE id = '{txn_id}'");
$txn = mysqli_fetch_assoc($txnQuery);
$cart_id = $txn['cart_id'];
$cartQ = $con->query("SELECT * FROM cart WHERE id = '{cart_id}'");
$cart = mysqli_fetch_assoc($cartQ);
$items = json_decode($cart['items'],true);
$idArray = array();
$products = array();var_dump($items);
foreach ($items as $item) {
	$idArray[] = $item['id'];
}
$ids = implode(',',$idArray);
$productQ = $con->query("SELECT i.id as 'id' i.title as 'title',c.id as 'cid', p.category as 'parent' FROM products i
LEFT JOIN categories p ON c.parent = p.id
WHERE i.id IN ({$ids});");

// while($p = mysqli_fetch_assoc($productQ)){
// 	foreach ($$items as $item) {
// 		if ($item['id'] == $p['id']) {
// 			$x = $item;
// 			continue;
// 		}
// 	}
// }
// $products[] = array_merge($x,$p);

?>

<h2 class="text-center">Items Ordered</h2>
<table class="table table-condensed table-bordered table-striped">
	<thead>
		<th>Quantity</th>
		<th>Title</th>
		<th>Category</th>
		<th>Size</th>
		
	</thead>
	<tbody>
		<?php foreach($products as $product): ?>
			<tr>
				<td><?=$product['Quantity'];?></td>
				<td><?=$product['title'];?></td>
				<td><?=$product['parent'];?><?=$product['size'];?></td>
				<td></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php include 'includes/footer.php'; ?>