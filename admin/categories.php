<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/eCommerce/core/init.php';
if (!is_logged_in()) {
		login_error_redirect();
		
	}
	
include 'includes/head.php';
include 'includes/navigation.php';

$sql= "SELECT * FROM categories WHERE parent = 0";
$result = $con->query($sql);
$errors = array();
$category = '';
$post_parent = '';
//edit category
// print_r($_GET);
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
	$edit_id = (int)$_GET['edit'];
	$edit_id = sanitize($edit_id);
	$edit_sql = "SELECT * FROM categories WHERE id = '$edit_id'";
	$edit_result = $con->query($edit_sql);
	$edit_category = mysqli_fetch_assoc($edit_result);
	# code...
}

//delete category
if(isset($_GET['delete']) && !empty($_GET['delete'])){
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);

	$sql = "SELECT * FROM categories WHERE id = '$delete_id'";
	$result = $con->query($sql);
	$category = mysqli_fetch_assoc($result);
	if ($category['parent'] == 0) {
		$sql = "DELETE FROM categories WHERE parent = '$delete_id'";
		$con->query($sql);
		# code...
	}
	$dsql = "DELETE FROM categories WHERE id = '$delete_id'";
	$con->query($dsql);
	header('Location: categories.php');


}

//process form
if(isset($_POST) && !empty($_POST)){
	$post_parent = sanitize($_POST['parent']);
	$category = sanitize($_POST['category']);
	$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent= '$post_parent'";
	if (isset($_GET['edit'])) {
		$id = $edit_category['id'];
		$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND id !=''";
		# code...
	}
	$fresult = $con->query($sqlform);
	$count = mysqli_num_rows($fresult);

	//if category is blank
	if($category == ''){
		$errors[] .= 'the category can not be left blank.';
	}

	//if it exists in the db
	if($count > 0){
		$errors[] .=$category. ' already in place. choose a new category';

	}
	//display errors or update to db
	if (!empty($errors)) {
		//display errors
		$display = display_errors($errors); ?>  
		<script>
			
			jQuery('document').ready(function(){
				jQuery('#errors').html('<?=$display; ?>' );
			});

		</script>
		<?php
	}
	else{
		//update to db
		$updatesql = "INSERT INTO categories (category, parent) VALUES ('$category', '$post_parent')";
		if (isset($_GET['edit'])) {
			$updatesql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id'";
			# code...
		}
		$con->query($updatesql);
		header('Location: categories.php');
	}
	


	}

		$category_value = '';
		$parent_value = 0;
	if (isset($_GET['edit'])) {
		$category_value = $edit_category['category']; 
		$parent_value = $edit_category['parent'];
		# code...
	}else{
		if (isset($_POST)) {
			$category_value = $category;
			$parent_value = $post_parent;  

			# code...
		}
	}

?>
<br>
<h2 class="text-center">Categories</h2>
<hr>
<div class="row modal-lg">

	<!--form-->
	<div class="col-md-6">
		
		<form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
			<legend><?=((isset($_GET['edit']))?'Edit':'Add A' );?> Category</legend>
			<div id="errors"></div>
			<div class="form-group">
				<label for="parent">parent</label>
				<select class="form-control" name="parent" id="parent">
					<option value="0" <?=(($parent_value== 0)?'selected="selected"':''); ?>>parent</option>

					<?php while($parent = mysqli_fetch_assoc($result)) { ?>
						<option value="<?=$parent['id'];?>"<?=(($parent_value == $parent['id'])?' selected="selected"':'')?>><?=$parent['category'];?></option>
					<?php } ?> 

				</select>
			</div>
			<div class="form-group">
				<label for="Category">Category</label>
				<input type="text" class="form-control" id="category" name="category" value="<?=$category_value;?>">

			</div>
			<div class="form-group">
				<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add A');?> category" class="btn btn-success">
			</div>
		</form>

	</div> 
	<!--Category table-->
	<div class="col-md-6"></div>

	<!-- //================ -->
<table class="table table-bordered">
	<thead>
		
		<th>category</th>
		<th>parent</th>
		<th></th>

	</thead>
	<tbody>
<?php

	$dd= $con->query("SELECT * FROM categories WHERE parent = 0 ");
	while($row333 = mysqli_fetch_assoc($dd)):
		$parent_id = (int)$row333['id'];
		$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
		$cresult = $con->query($sql2);
			$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
			$result = $con->query($sql2);

	 ?>
		<tr class="bg-primary">
			<td><?php echo $row333['category'];?></td>
			<td><?=$parent['category'];?>parent</td>
			<!-- <td>parent</td> -->
			

			<td>
					<a href="categories.php?edit=<?=$row333['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="categories.php?delete=<?=$row333['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>

			</td>
		</tr>
		<?php while($child = mysqli_fetch_assoc($result)): ?>
		<tr class="bg-info">
			<td><?=$child ['category']; ?></td>
			<td><?=$parent['category']; ?></td>

			<td>
				<a href="categories.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				<a href="categories.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>

			</td>
		</tr>
			<?php endwhile; ?> 
		<?php endwhile; ?> 
	</tbody>

</table>




<?php include 'includes/footer.php'; ?>