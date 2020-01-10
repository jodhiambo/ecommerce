<?php
function display_errors($errors){
	$display = '<ul class= "bg-danger">';
	if (is_array($errors)) {
		foreach ($errors as $error) {
		$display .= '<li class="text-danger">' .$error. '</li>'; 
	}
	}
	
	$display .= '</ul>';
	return $display;
}

function sanitize($dirty){
	return htmlentities($dirty, ENT_QUOTES, "UTF-8");
}

function money($number){
	return 'Ksh ' .number_format($number,2);
}
function login($user_id){
	$_SESSION['Xuser'] = $user_id;
	global $con;
	$date = date("Y-m-d H:i:s");
	$con->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
	$_SESSION['success_flash'] = '';
	header('Location: index.php');
}
function is_logged_in(){
	if (isset($_SESSION['Xuser']) && $_SESSION['Xuser'] > 0) {
		return true;
		# code...
	}
	return false;
}
function login_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'You must be logged in to access that page.';
	header('Location: '.$url);
}

function permission_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'You do not have permissions to access this page.';
	header('Location: '.$url);
}

function has_permission($permission){

	global $user_data;
	$permissions_array = explode(',', $user_data['permissions']);
	// var_dump($permissions_array);die();
	// in_array(needle, haystack)
	if (in_array($permission, $permissions_array)) {
		return true;
		# code... 
	}
	return false;
}

function prety_date($date){
	return date("M d, Y h:i A",strtotime($date));

}

function get_category($child_id){
	global $con;
	$id = sanitize($child_id);
	$sql = "SELECT p.id AS 'pid' , p.category AS 'parent' , c.id AS 'cid' , c.category AS 'child' FROM categories c INNER JOIN categories p ON c.parent = p.id WHERE c.id = '$id'";
	$query = $con->query($sql);
	$category = mysqli_fetch_assoc($query);
	return $category;
}
function sizesToArray($string){
	$sizesArray = explode(',',$string);
	$returnArray = array();
	foreach ($sizesArray as $string) {
		$s = explode(':', $size);
		$returnArray[] = array('size' => $s[0], 'quantity' => $s[1]);
		# code...
	}
	return $returnArray;
}
function sizesToString($sizes){
	$sizeString = '';
	foreach($sizes as $size){
		$sizeString = $size['size'].':'.$size['quantity'].',';
	}
	$strimmed = rtrim($sizeString, ',');
	return $strimmed;
}