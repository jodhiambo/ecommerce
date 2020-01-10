<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/eCommerce/core/init.php';
include 'includes/head.php';
// $password = 'jaokod15';
// $hashed = password_hash($password, PASSWORD_DEFAULT);
// echo $hashed;
$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$hashed = password_hash($password, PASSWORD_DEFAULT);
$errors = array();


?>
<style>
	body{
		
		background-size: 100vw 100vh;	
		background-attachment: fixed;
	}
</style>
<div id="login-form">
	<div>
		<?php 

		if ($_POST) {
			//Form validation
			if(empty($_POST['email']) || empty($_POST['password'])){
				$errors[] = 'You must enter the email and password to login. ';
			}
			//validate email
			if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
				$errors[] = 'You must enter a valid email.';
				# code...
			}

			//password is more than 4 characters
			if (strlen($password)<4) {
				$errors[] = 'password must be more than 4 characters.';
				# code...
			}



			// check if the email exists in db
			$query = $con->query("SELECT * FROM users WHERE email = '$email'");
			$user = mysqli_fetch_assoc($query);
			$usercount = mysqli_num_rows($query); 
			if ($usercount < 1) {
				$errors[] = 'This email doesnt exist in our batabase';
				# code...
			}

			if (!password_verify($password, $user['password'])) {
				$errors[] = 'The password does not match our records. Please try again';
				# code...
			}


			//check for errors
			if (!empty($errors)) {
				echo display_errors($errors);
				# code...
			}else{
				//login user
				$user_id = $user['id'];
				login($user_id);
			}
			# code...
		}
		?>

	</div>
	<h2 class="text-center">Login</h2><hr>
	<form action="login.php" method="post">
		
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>" placeholder="Enter Your Email Address">
		</div><br> 
		<div class="form-group">
			<label for="password">password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>" placeholder="Enter Your Password">
		</div>
		<div class="form-group">
			<input type="submit" value="Login" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/eCommerce/index.php" alt="home">Visit Site</a></p>

</div>

<?php include 'includes/footer.php';?>