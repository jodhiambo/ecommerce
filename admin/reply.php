
<!DOCTYPE html>
<html>
 <head>
	<title>Administrator</title>
<link rel="stylesheet" type="text/css" href="../css/main.css">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../css/bootstrap.min.css" >

<!-- Optional theme -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" > -->
<link rel="stylesheet" href="../css/bootstrap-theme.min.css" >
<script src="../js/jquery-3.0.0.min.js"></script><hr>
<a href="/eCommerce/admin/index.php" alt="home"> Visit Home Page</a></p>
 </head>
 <body>
 
 <div class="row">

 	<div class="col-md-2"></div>
 	<div class="col-md-7"><!--center!-->
<?php
 	include('../core/init.php');
 	include 'includes/navigation.php';
$f=mysqli_query($con,"SELECT * FROM messages");
if(mysqli_num_rows($f)>0){

echo '<div class="table">';
echo '<table class="table table-stripped style="border= 1.5px;">';
echo '<br>';
echo '<thead style="color:skyblue;" class="text-center">

<td>DATE</td>	

<td>QUERY</td>
<td>RESPONSE</td>
<td>UNRESPONDED </td>
</thead>';
while($row=mysqli_fetch_assoc($f)){
	$mid=$row['message_id'];
	$date=$row['date'];
	

	$message=$row['message'];
	$reply=$row['reply'];
	

		echo '<tbody class="text-left">';
	echo '<td>'.$date.'</td>';	
	
	echo '<td>'.$message.'</td>';

	echo '<td>'.$reply.'</td>';
	$ch=mysqli_query($con,"SELECT * FROM messages WHERE message_id='$mid' AND reply!='' ");
	if(mysqli_num_rows($ch)==0){

	echo '<td><center><a style=color:green; href=answer1.php?id='.$mid.'>RESPOND TO</a></center></td></tbody>';
}
else{
	echo '</tbody>';
}

}
echo'</table>';

echo '</div>';


}
else{
	echo '<h3>'.'<center>'.'No queries made by any customer'.'</center>'.'</h3>';
}


 	?>

 	 <!--center!-->  </div>
 	<div class="col-md-3"></div>
 </div>
 
 </body>
</html>