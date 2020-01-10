<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/eCommerce/core/init.php';

if(!is_logged_in()){
	login_error_redirect();
}
include 'includes/head.php'; 
$hashed = $user_data['password'];

$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);
$user_id = $user_data['id'];
$errors = array();

?>

<div id="login-form">
	<div>
		<?php 

		if ($_POST) {
			//Form validation
			if(empty($_POST['old_password']) || empty($_POST['confirm'])){
				$errors[] = 'You must fill all fields';
			}

			//password is more than 4 characters
			if (strlen($password)<4) {
				$errors[] = 'password must not be less than 4 characters.';
				# code...
			}
			//if new password matches confirm
			if ($password !=$confirm) {
				$errors[] = 'The new password does not match please try again!';
				# code...
			}

			if (!password_verify($old_password, $hashed)) {
				$errors[] = 'The old password does not match our records. Please try again';
				# code...
			}


			//check for errors
			if (!empty($errors)) {
				echo display_errors($errors);
				# code...
			}else{
				//change paswword 
				$con->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
				$_SESSION['success_flash'] = 'Your Password Changed Successfully';
				unset($_SESSION['Xuser']);
				header('Location: login.php'); 
			}
			# code...
		}
		?>

	</div>
	<h2 class="text-center">Change Password</h2><hr>
	<form action="change_password.php" method="post">
		
		<div class="form-group">
			<label for="old_password">Enter Old Password:</label>
			<input type="password" name="old_password" id="old_password" class="form-control" >
		</div><br> 
		<div class="form-group">
			<label for="password">Enter New Password:</label>
			<input type="password" name="password" id="password" class="form-control" >
		</div>
		<div class="form-group">
			<label for="confirm">Confirm New Password:</label>
			<input type="password" name="confirm" id="confirm" class="form-control" >
		</div>
		<div class="form-group">
			<a href="index.php" class="btn btn-default">Cancel</a>
			<input type="submit" value="Save" name="change_password" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/eCommerce/index.php" alt="home">Visit Site</a></p>

</div>

<?php include 'includes/footer.php';?>