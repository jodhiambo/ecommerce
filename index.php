
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
 include 'includes/headerfull.php';
 include 'includes/leftbar.php';
 $sql = "SELECT * FROM products WHERE featured = 1";
 $featured = $con->query($sql);
?>
	<!--main content-->
	<div class="col-md-8">
		<div class="row">
			<h2 class="text-center">Sample Products </h2>
		<?php while ($product = mysqli_fetch_assoc($featured)) :?>
			
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
	include 'includes/rightbar.php';
	include 'includes/footer.php';

	?>
	<script type="text/javascript">
			function detailsmodal(id){ 
		// alert("welocome");
		
		var data = {"id" : id};
		jQuery.ajax({
			url : 'includes/detailsmodal.php',
			method : "POST",
			data : {"id" : id},
			success: function(data){
				jQuery('body').append(data);
				jQuery('#details-modal').modal('toggle');

			},
			error: function(){
				alert ("there is a problem somewhere!");

			}
		});

	}
	</script>
</body>
