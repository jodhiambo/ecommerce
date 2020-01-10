3	<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/eCommerce/core/init.php';
// if (!is_logged_in()) {
// 		login_error_redirect();
		
// 	}
	
include 'includes/head.php';
include 'includes/navigation.php';
$conpath = '';

//delete product
if (isset($_GET['delete'])) {
	$id = sanitize($_GET['delete']);
	$con->query("UPDATE products SET featured = 0 WHERE id = '$id'");
	header('Location: products.php');
	# code...
}

if (isset($_GET['add']) || isset($_GET['edit'])) {
	$brandQuery = $con->query("SELECT * FROM brand ORDER BY brand");
	$parentQuery = $con->query("SELECT * FROM categories WHERE parent =0 ORDER BY category");
	$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
	$brand = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):'');
	$parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):'');
	$category = ((isset($_POST['child'])) && !empty($_POST['child'])?sanitize($_POST['child']):'');
	$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
	$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
	$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
	$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
	$sizes = rtrim($sizes,',');
	$saved_images = '';

	//edit product
	if (isset($_GET['edit'])) {
		$edit_id = (int)$_GET['edit'];
		$product_results = $con->query("SELECT * FROM products WHERE id = '$edit_id'");
		$product = mysqli_fetch_assoc($product_results);
		if (isset($_GET['delete_images'])) {
			$images_url = $_SERVER['DOCUMENT_ROOT'].$product['images'];echo $images_url;
			unlink($images_url);
			$con->query("UPDATE products SET images = '' WHERE id = '$edit_id'");
			header('Location: products.php?edit='.$edit_id); 
			# code...
		}
		$category = ((isset($_POST['child']) && $_POST['child'] !='')?sanitize($_POST['child']):$product['categories']);
		$title = ((isset($_POST['title']) && !empty($_POST['title']))?sanitize($_POST['title']):$product['title']);
		$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):$product['brand']);
		$parentQ = $con->query("SELECT * FROM categories WHERE id = '$category'");
		$parent_result = mysqli_fetch_assoc($parentQ);
		$parent = ((isset($_POST['parent']) && $_POST['parent'] !='')?sanitize($_POST['parent']):$parent_result['parent']);
		$price = ((isset($_POST['price']) && !empty($_POST['price']))?sanitize($_POST['price']):$product['price']);
		$list_price = ((isset($_POST['list_price']) && !empty($_POST['list_price']))?sanitize($_POST['list_price']):$product['list_price']);
		$description = ((isset($_POST['description']) && !empty($_POST['description']))?sanitize($_POST['description']):$product['description']);
		$sizes = ((isset($_POST['sizes']) && !empty($_POST['sizes']))?sanitize($_POST['sizes']):$product['sizes']);
		$sizes = rtrim($sizes,',');
		$saved_images = (($product['images'] != '')?$product['images']:'');
		$conpath = $saved_images;
	
	}
	if (!empty($sizes)) {
			$sizeString = sanitize($sizes);
			$sizeString = rtrim($sizeString,',');
			$sizesArray = explode(',',$sizeString);
			$sArray = array();
			$qArray = array();
			foreach ($sizesArray as $ss) {
				$s = explode(':', $ss);
				$sArray[] = $s[0];
				$qArray[] = $s[1];
				# code...
			}
			# code...
		}else{$sizesArray = array();}

	if($_POST){
		// $conpath = '';
		$errors = array();
	$required = array('title','brand','price','list_price','parent');
	foreach($required as $field){
		if($_POST[$field] == ''){
			echo "<br>";
			$errors[] = 'All fields with astrisk must be field';
			break;
		}
	}
	if(!empty($_FILES)){
		// var_dump($_FILES);

		$photo = $_FILES['photo'];
		$name = $photo['name'];
		$nameArray = explode('.',$name);
		$fileName = $nameArray[0];
		$fileExt = $nameArray[1];
		$mime = explode('/',$photo['type']);
		$mimeType = $mime[0];
		$mimeExt = $mime[1];
		$tmpLoc = $photo['tmp_name'];
		$fileSize = $photo['size'];
		$allowed = array('png', 'jpg', 'jpeg', 'gif');
		$uploadName = md5(microtime()).'.'.$fileExt;
		$uploadPath = BASEURL.'images/'.$uploadName;
		$conpath = 'eCommerce/images'.$uploadName;
		if ($mimeType != 'image') {
			$errors[] .= 'The file must be an image';
			# code...
		}
		if (!in_array($fileExt, $allowed)) {
			$errors[] .= 'The file extention must be a png, jpg, jpeg or gif.';
			# code...
		}
		if ($fileSize > 15000000){
			$errors[] .= 'The image size must be under 15MB.';
		}
		if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')){
			$errors[] .= 'File extention does not match the file.';
		}
	}
	
	if(!empty($errors)){
		echo display_errors($errors);
	
}
else{
	// echo "<br><br><br><br><br>";
	// print_r($_FILES);
	// chmod("$uploadPath",0777);?
	// chmod(dirname($uploadPath),0777);
	// echo $name;
	// exit;
	if (!empty($_FILES)) {
		move_uploaded_file($tmpLoc, "/opt/lampp/htdocs/eCommerce/images/{$name}");
	}
	
	$sizes = $_POST['size'];
	
	$insertsql = "INSERT INTO `products`
	(`title`, `price`, `list_price`, `brand`, `categories`, `images`, `description`, `sizes`) VALUES 
	('{$title}', '{$price}', '{$list_price}', '{$brand}', '{$parent}', '/eCommerce/images/{$name}','{$description}','{$sizes}')";

	if (isset($_GET['edit'])) {
		$insertsql = "UPDATE products SET title = '$title', price= '$price', list_price= '$list_price' brand = '$brand', categories = '$category', sizes = '$sizes', images = $conpath, description = '$description' WHERE id ='$edit_id'";
		# code...
	}
	$con->query($insertsql)or die(mysqli_error($con));
	header('Location: products.php');
	}
	}

	?><br>
	<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New');?> Product</h2><br>

	<form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
		<div class="form-group col-md-3 text-center">
			<label for="title">Title*:
			</label>
			<input type="text" name="title" class="form-control" id="title" value="<?=$title;?>">
		</div>
		<div class="form-group col-md-3 text-center">
			<label for="brand">Brand*:</label>
			<select class="form-control" id="brand" name="brand">
				<option value=""<?=(($brand =='')?' selected':''); ?>></option>
				<?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
				<option value="<?=$b['id'];?>"<?=(($brand == $b['id'])?' selected':''); ?>><?=$b['brand']; ?></option>

				<?php endwhile; ?>	
			</select>
		</div>
		<div class="form-group col-md-3 text-center">
			<label for="parent">Parent Category*:</label>
			<?php
				$data2 = $con->query("SELECT * FROM categories WHERE id = '{$category}' ORDER BY category");
				$data = mysqli_fetch_assoc($data2);	
			 ?>
			<select class="form-control" id="parent" name="parent">
				<option value="<?=(($data['parent'] =='')?' selected':''); ?>"><?php echo $data['category']; ?></option>
				<option value=""<?=((isset($_POST['parent']) && $_POST['parent'] == '')?' selected':'');?>></option>
				<?php while($parent = mysqli_fetch_assoc($parentQuery)): ?>
					<option value="<?=$parent['id'];?>"<?=(($parent == $parent['id'])?' selected':'');?>><?=$parent['category'];?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group col-md-3 text-center">
			<label for="child">Child Category:</label>
			<select id="child" name="child" class="form-control"></select>

		</div>
			<div class="form-group col-md-3 text-center">
				<label for="price">Price*:</label>
				<input type="text" id="price" name="price" class="form-control" value="<?=$price;?>">
			</div>
			<div class="form-group col-md-3 text-center">
				<label for="list_price">list_price*:</label>
				<input type="text" id="list_price" name="list_price" class="form-control" value="<?=$list_price;?>">
			</div> 
			<div class="form-group col-md-3 text-center">
				<label>Quantity & Sizes*:</label>
				<button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
			</div>
			<div class="form-group col-md-3 text-center">
				<label for="sizes">Sizes & Quantity preview</label>
				<input type="text" class="form-control" name="size" id="sizes" value="<?=$sizes;?>" readonly>
			</div>
			<div class="form-group col-md-6 text-center">
				<?php if($saved_images !=''):?>
					<div class="saved_images"><img src="<?=$saved_images;?>" alt="saved_images"/><br></div>
					<a href="products.php?delete_image=1$edit<?=$edit_id;?>" class="text-danger">Delete Image</a>
				<?php else: ?>
				<label for="photo"> Product Photo</label>
				<input type="file" name="photo" id="photo" class="form-control" multiple="photo">
			<?php endif; ?> 
			</div>
			<div class="form-group col-md-6">
				<label for="description">Description</label>
				<textarea id="description" name="description" class="form-control" rows="6"><?=$description; ?></textarea>
			</div>
			<div class="form-group pull-right">
			<a href="products.php" class="btn btn-danger">Cancel</a>
				<input type="submit" value="<?= ((isset($_GET['edit']))?'Edit':'Add');?> Product" class="btn btn-success">
			</div>
			<div class="clearfix"></div>
			

	</form> 
	
<!-- quantity and sizes Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="sizesModalLabel">Sizes &amp; Quantity</h4>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
        <?php for($i=1;$i<=12;$i++): ?>
        	<div class="form-group col-md-4">
        		<label for="size<?=$i;?>">size:</label>
        		<input type="text" name="size<?=$i;?>" id="size<?=$i;?>"value="<?php echo((!empty($sAraay[$i-1]))?$Array[$si-1]: '');?>"class="form-control">
        	<!-- </div>
        	 	<div class="form-group col-md-2">
        		<label for="qty<?=$i;?>">Quantity:</label>
        		<input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>"value="" min="0"class="form-control">
        	</div> -->
        		</div>
					<div class="form-group col-md-2">
						<label for="qty<?php echo $i; ?>">Quantity:</label>
						<input class="form-control" type="number" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" value="<?php echo ((!empty($qArray[$i-1]))?$qArray[$i-1] : ''); ?>" min="0">
					</div>


        <?php endfor; ?>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updatesizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php }else{
$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $con->query($sql);
if (isset($_GET['featured'])) {
	$id = (int)$_GET['id'];
	$featured = (int)$_GET['featured'];
	$featuredsql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
	$con->query($featuredsql);
	header('Location: products.php'); 
	# code...
}


?>
<br>
<h2 class="text-center">List Of Products</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product</a>
<div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th></th>
		<th>Products</th>
		<th>Price</th>
		<!-- <th>Category</th> -->
		<th>Featured</th>
		<th>Sold</th>
	</thead>
	<tbody>
	<?php //print_r($con); ?>
		<?php while($product = mysqli_fetch_assoc($presults)):


			// $childID = $product['categories'];
			// $catsql = "SELECT * FROM categories WHERE id = '$childID'";
			// $result = $con->query($catsql);
			// $child = mysqli_fetch_assoc($result);

			// $parentID = $child['parent'];
			// $psql = "SELECT * FROM categories WHERE id = '$parentID'";
			// $presults = $con->query($psql);
			// $parent = mysqli_fetch_assoc($presults);
			// $category = $parent['category'].'~'.$child['category'];
			?> 
			
		<tr>
			<td>
				<a href="products.php?edit=<?=$product['id']; ?>" class="btn btn-xs btn-default">
					<span class="glyphicon glyphicon-pencil">
						
					</span>
				</a>
				<a href="products.php?delete=<?=$product['id']; ?>" class="btn btn-xs btn-default">
					<span class="glyphicon glyphicon-remove">
						
					</span>
				</a>
			</td>
			<td>
				<?=$product['title']; ?>
			</td>
			<td>
				<?=money($product['price']); ?>
			</td>
		 	<!-- <td><?=$category;?></td>  -->
			<td>
				<a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0'); ?>&id=<?=$product['id']; ?>" class="btn btn-xs btn-default">
					<span class=" glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus'); ?>">
						
					</span>
				</a>
				&nbsp <?=(($product['featured'] == 1)?'Featured Product':''); ?>
			</td>
			<td>0</td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>



<?php } 
include 'includes/footer.php'; ?>

<script>
	jQuery('document').ready(function(){
		get_child_options('<?=$category;?>'); 
	});
</script>