
<!DOCTYPE html>
<html>
<head>
	<title>Everything Instantlly</title>
</head>
<body>
<?php 
require_once 'core/init.php';
 include 'includes/head.php';
 include 'includes/navigation.php';
 include 'includes/headerpartial.php';
 include 'includes/leftbar.php';

 if (isset($_GET['cat'])) {
 	$cat_id = sanitize($_GET['cat']);
 
 }else{
 	$cat_id = '';
 }

 $sql = "SELECT * FROM products WHERE categories = '$cat_id'";
 $productQ = $con->query($sql);
 $category = get_category($cat_id);
?>
	<div class="col-md-8">
		<div class="row">
			<h2 class="text-center">Sample Products <?=$category['parent']. ' ' . $category['parent'];?> </h2>
		<?php while ($product = mysqli_fetch_assoc($productQ)) :?>
			
			<div class="col-md-3 text-center" >
				<h4><?php echo $product['title']; ?></h4>
				<img src="<?= $product['images']; ?>" alt="  " class="img-thumb"><s>
				<p class="list_price text-danger">list_price: Ksh <?= $product['list_price']; ?></s></p>
				<p class="price">our price: Ksh <b><?= $product['price']; ?></b></p>
				<button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id']; ?>)">
				details</button>
			</div>
		 <?php endwhile; ?>
		</div>
	</div>

	<?php
	include 'includes/footer.php';

	?>
</body>
</html>




