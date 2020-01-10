<?php
require_once '../core/init.php';
if (!is_logged_in()) {
		login_error_redirect();
		
	}
	
include 'includes/head.php';
include 'includes/navigation.php';
//get brands from database
$sql = "SELECT * FROM brand ORDER BY brand";
$results = $con->query($sql);
$errors = array();

//edit brand
if(isset($_GET['edit']) && !empty($_GET['edit'])){
	$edit_id = (int)$_GET['edit'];
	$edit_id = sanitize($edit_id);
	$sql = "SELECT * FROM brand WHERE id = '$edit_id'";
	$edit_result = $con->query($sql);
	$ebrand = mysqli_fetch_assoc($edit_result);
	

}



//delete brand
if(isset($_GET['delete']) && !empty($_GET['delete'])){
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);
	$sql = "DELETE FROM brand WHERE id = '$delete_id'";
	$con->query($sql);
	header('Location: brands.php'); 

}



//if add form is submitted
if(isset($_POST['add_submit'])){
	$brand = sanitize ($_POST['brand']);
//check if brand is blank
	if($_POST['brand'] == ''){
		$errors[] .='your have to enter a brand';
	}
	//check if brand exists in db
	$sql = "SELECT * FROM brand WHERE brand = '$brand'";
	if(isset($_GET['edit'])){
		$sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";

	}
	$result = $con->query($sql);
	$count = mysqli_num_rows($result);
	if ($count > 0) {
		$errors[] .= $brand.' brand already exists choose another';
		# code...
	}

	//display errors
	if (!empty($errors)) {
		echo  display_errors($errors);
		# code...
	}else{
		//add brand to db
		$sql = "INSERT INTO brand (brand) VALUES ('$brand')";
		if (isset($_GET['edit'])) {
			$sql = "UPDATE brand SET brand = '$brand' WHERE id ='$edit_id '";
			# code...
		}
		$con->query($sql);
		header('location: brands.php'); 

	}

}
?>
<br>
<h2 class="text-center">Brands</h2><hr>
<!--brand form-->
<div class="text-center">
	<form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
	<div class="form-group">

	<?php 
		$brand_value = '';
			if(isset($_GET['edit'])){
		$brand_value = $ebrand['brand'];
		}else{
			if(isset($_POST['brand'])){
				$brand_value = sanitize($_POST['brand']);
			}
		}

	?>
		<label for="brand"><?=(isset($_GET['edit']))?'Edit' : 'Add A' ?> Brand:</label>
		<input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value; ?>">
			<?php if (isset($_GET['edit'])): ?>
			<a href="brands.php" class="btn btn-default">Cancel</a>
			<?php endif;?>
		<input type="submit" name="add_submit" value="save" class="btn btn-success">

	</div>
		
	</form>

</div><hr>
<table class="table table-bordered table-striped table-auto table-condensed">
	<thead>
		<th></th><th>Brand</th><th></th>
	</thead>
<tbody>
	<?php while($brand = mysqli_fetch_assoc($results)): ?>
	<tr>
		<td><a href="brands.php?edit=<?=$brand['id']; ?>" class="btn btn-xs btn-default "><span class="glyphicon glyphicon-pencil"></span></a>
		</td>

		<td><?=$brand ['brand'] ?></td>

		<td><a href="brands.php?delete=<?=$brand['id']; ?>" class="btn btn-xs btn-default "><span class="glyphicon glyphicon-remove-sign"></span></a>
		</td>
	</tr>
<?php endwhile; ?>

</tbody>

</table>
<?php include 'includes/footer.php'; ?> 