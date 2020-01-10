<?php 
require_once '../core/init.php';
$id = $_POST['id'];
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id = '$id'";
$result =$con->query($sql);
$product = mysqli_fetch_assoc($result);
$brand_id = $product['brand'];
$sql = "SELECT brand FROM brand WHERE id = '$brand_id'";
$brand_query = $con->query($sql);
$brand = mysqli_fetch_assoc($brand_query );
$sizestring = $product['sizes'];
$size_array = explode(',', $sizestring);
 ?>


<!--details modal-->

<?php ob_start(); ?>


<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true"> 
<div class="modal-dialog modal-lg">
	<div class="modal-content">
	<div class="modal-header">
		<button class="close" type="button" onclick="closeModal ()" aria-label="close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title text-center"><?= $product['title']; ?></h4>
	</div>
	<div class="modal-body">
		<div class="container-fluid">
			<div class="row">
				<span id="modal_errors" class="bg-danger"></span>
				<div class="col-sm-6">
					<div class="center-block">
					<img src="<?= $product['images']; ?>" alt="<?= $product['title']; ?>" class="img-fluid ">
					</div>
				</div>
				<div class="col-sm-6">
					<h4>Details</h4>
					<p><?= $product['description']; ?></p>
					<hr>
					<p>price: Ksh <?= $product['price']; ?></p>
					<p>brand: <?= $brand['brand']; ?></p>
					<form action="add_cart.php" method="post" id="add_product_form">
						<input type="hidden" name="product_id" value="<?= $product['id']; ?>">
						<input type="hidden" name="available" id="available" value="<?= $product['quantity']; ?>">
				<div class="form-group">
							<div class="col-xs-3">
								<label for="quantity">Quantity:</label>
								<input type="number" class="form-control" id="quantity" name="quantity" required>
							</div><div class="col-xs-9"></div>
						</div><br><br><br><br>
						<div class="form-group">
							<label for="size">size: </label>

							<select name="size" id="size" class="form-control" required>
								<option value=""></option>
								<?php 
								$string_array2 = explode(',', $product['sizes']);
								foreach ($string_array2 as $key => $string) {
									$string_array = explode(':', $string);
									$sizes = $string_array[0];
									$available = $string_array[1];
									if ($available > 0) {
										echo '<option value="'.$sizes.'" data-available="'.$available.'">'.$sizes.'('.$available.' available)</option>'; 
									}
									
								}
								?>
								

							</select>
						</div>
							<div class="modal-footer">
		<button class="btn btn-default" onclick="closeModal()">close</button>
		<button class="btn btn-warning"type="submit" value="Add"onclick="add_to_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"></span> Add To Cart</button>

	</div>	
					</form>
				</div>
			</div>
		</div>
	</div>

	</div>
</div>
</div>
<script>
	jQuery('#sizes').change(function(){
		var available = jQuery('#sizes option:selected').data("available");
		jQuery('#available').val(available);
	});

function closeModal (){
	
	jQuery('#details-modal').modal('hide');
	setTimeout(function(){
		jQuery('#details-modal').remove();
		jQuery('.modal-backdrop').remove();
	},500);
	
}
function update_cart(mode,edit_id,edit_size){
		var data = {"mode": mode, "edit_id" :edit_id, "edit_size": edit_size};
		jQuery.ajax({
			url : '/eCommerce/admin/pasas/update_cart.php',
			method : "post",
			data : data,
			success : function(){Location.reload();},
			error : function(){alart("something went wrong");},
		});
		}
	function add_to_cart(){
		// alert("it works");
		
		jQuery('#modal_errors').html("");
		var quantity = jQuery('#quantity').val();
		var available = jQuery('#available').val();
		var size = jQuery('#size').val();
		var error = '';
		var data = jQuery('#add_product_form').serialize();
		if (size == '' || quantity == '' || quantity ==0 || quantity < 0){
			error += '<p class ="text-center text-danger">You must choose size, quantity and the quantity must be a positive number.</p>';
			jQuery('#modal_errors').html(error);
			return;
		}
		else if(parseInt(quantity) > parseInt(available) ){
			error += "<p class =\"text-center text-danger\">there are only " +available+" available.</p>";
			jQuery('#modal_errors').html(error);
	return;

	}
	else{
		jQuery.ajax({
			// url : '/eCommerce/admin/pasas/add_cart.php',
			url : '/eCommerce/add_cart.php',
			method : 'post',
			data : data,
			success : function(data){
			location.reload();
		},
			error : function(){
				alart("something went wrong");
			}
		});
	}
	
	}

</script>
<?php  echo ob_get_clean(); ?> 


