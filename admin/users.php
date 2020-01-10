
<?php
	require_once '../core/init.php';
	if (!is_logged_in()) {
		login_error_redirect();
		# code...
	}
	if (has_permission('admin') == false) {
		permission_error_redirect('login.php');
		// exit(1);
		# code...
	}
	include 'includes/head.php';
	include 'includes/navigation.php';
	if(isset($_GET['delete'])){
		$delete_id = sanitize($_GET['delete']);
		$con->query("DELETE FROM users WHERE id = '$delete_id'");
		$_SESSION['success_flash'] = 'user has been deleted successfully';
		header('Location: users.php');
	}
	if (isset($_GET['add'])) {
		$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
		$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
		$Password = ((isset($_POST['Password']))?sanitize($_POST['Password']):'');
		$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
		$permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');

		$errors = array();
		if($_POST){
			$emailQuery = $con->query("SELECT * FROM users WHERE email = '$email'");
			$emailCount = mysqli_num_rows($emailQuery);

			if($emailCount != 0){
				$errors[] = 'that email already exist...try a different email';
			}

			$required = array('name','email','password','confirm','permissions');
			foreach($required as $f){
				if(empty($_POST[$f])){
					echo'<br>';
					$errors[] = 'you must fill all fields.';
					break;
				}
			}

			if(strlen($Password) < 4){
				$errors[] = 'your password must be at least 4 characters';
			}

			if($Password !=$confirm){
				$errors[] = 'your passwords does not match';
			}

			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$errors[] = 'you must enter a valid email address';
			}

			if(empty($errors)){
				echo display_errors($errors);
			}
			else{
				//add user to db
				$hashed = Password_hash($Password, PASSWORD_DEFAULT);
				$con->query("INSERT INTO users(full_name,email,password,permissions) VALUES ('$name','$email','$hashed','$permissions')");
				$_SESSION['success_flash'] = 'user added successfully';
				header('Location: users.php');
			}
			// echo $hashed;
			// print_r($_POST);
			// exit();
		}
		?>
		<br>
		<h2 class="text-center">Add A New User</h2><hr>
		<form action="users.php?add=1" method="post">
			<div class="form-group col-md-6">
				<label for="name">Full Name:</label>
				<input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="email">Email:</label>
				<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="password">Enter Password:</label>
				<input type="password" name="Password" id="password" class="form-control" value="<?=$Password;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="confirm">Confirm Password:</label>
				<input type="Password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
			</div>
			<div class="form-group col-md-6">
				<label for="name">Permissions:</label>
				<select class="form-control" name="permissions">
					<option value="" <?=(($permissions =='')?' selected':'');?>></option>
					<option value="editor" <?=(($permissions =='editor')?' selected':'');?>>Editor</option>
					<option value="admin,editor" <?=(($permissions =='admin,editor')?' selected':'');?>>Admin</option>
				</select>
			</div>
			<div class="form-group col-md-6 text-right">
				<a href="users.php" class="btn btn-danger">Cancel</a>
				<input type="submit" value="Add User" class="btn btn-primary">
			</div>
		</form>
		<?php
		
	}else{

	$UserQuery = $con->query("SELECT * FROM users ORDER BY full_name");	
?>
<br>
<br>
<br>
<h2 class="text-center">Users</h2>
<a href="users.php?add=1" class="btn btn-success pull-right" id="add-product-btn ">Add New User</a><br>
<hr>
<table class="table table-bordered table-striped table-condensed">
	<thead><th></th><th>Name</th><th>Email</th><th>Join Date</th><th>Last Login</th><th>Permissions</th></thead>
	<tbody>
		<?php while($user = mysqli_fetch_assoc($UserQuery)): {
		} ?>
		<tr>
			<td>
				<?php if($user['id'] != $user_data['id']):?>
					<a href="users.php?delete=<?=$user['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
				<?php endif; ?>

			</td>
			<td><?=$user['full_name'];?></td>
			<td><?=$user['email'];?></td>
			<td><?=prety_date($user['join date']);?></td>
			<td><?=(($user['last login'] == '0000-00-00 00:00:00')?'Never':prety_date($user['last login']));?></td>
			<td><?=$user['permissions'];?></td>
		</tr>
	<?php endwhile; ?>
	</tbody>
</table>
<?php } include 'includes/footer.php'; ?>


