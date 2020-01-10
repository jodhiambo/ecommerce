<?php
session_start();
$_SESSION['cart'][$_POST['product_id']] = $_POST['quantity'].",".$_POST['size'];
header("Location: cart.php");
// session_unset();
?>