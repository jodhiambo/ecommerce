<?php 
$db_name="eCommerce";
$mysql_user="root";
$mysql_pass="";
$server_name="localhost";

$con =mysqli_connect($server_name, $mysql_user, $mysql_pass, $db_name);

if(!$con)
{
echo"Connection error..........".mysqli_connect_error();
die();
} 
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/eCommerce/config.php';
require_once BASEURL.'helpers/helpers.php';
// require_once('vendor/autoload.php');
require_once BASEURL.'vendor/autoload.php';

$cart_id = '';
if(isset($_COOKIE[CART_COOKIE])){
	$cart_id = sanitize($_COOKIE[CART_COOKIE]);
}

if (isset($_SESSION['Xuser'])) {

	$user_id = $_SESSION['Xuser'];
	$query = $con->query("SELECT * FROM users WHERE id = '$user_id' ");
	$user_data = mysqli_fetch_assoc($query);
	$fn = explode(' ', $user_data['full_name']);
	$user_data['first'] = $fn[0];
	$user_data['last'] = @$fn[1];
	# code...
}


// if (isset($_SESSION['success_flash'])) {
// 	echo '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
// 	unset($_SESSION['session_flash']);
// 	# code...
// }

if (isset($_SESSION['error_flash'])) {
	echo '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
	unset($_SESSION['error_flash']);
	# code...
}








