<?php
if(isset($_POST['submit'])){
include('../core/init.php');
$mid=$_SESSION['mid'];
$answer=$_POST['answer'];

$in=mysqli_query($con,"UPDATE messages SET reply ='$answer' WHERE message_id='$mid' ");
if($in){
	header('location:reply.php');
}
else{echo mysqli_error();}
}
?>