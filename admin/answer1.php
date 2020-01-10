
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
<script src="../js/jquery-3.0.0.min.js"></script>


 </head>
 <body>
 	
 


 <div class="row">

 	<div class="col-md-2"></div>
 	<div class="col-md-7"><!--center!-->
<?php
$mid=$_GET['id'];
include('../core/init.php');
$_SESSION['mid']=$mid;
 	$f=mysqli_query($con,"SELECT * FROM messages where message_id='$mid' ");

echo '<div class="table">';
echo '<table class="table table-stripped">';
echo '<thead style="color:blue;">

<td>DATE</td>	

<td>Message</td>


</thead>';
while($row=mysqli_fetch_assoc($f)){
	$date=$row['date'];
	

	$message=$row['message'];
	
	

		echo '<tbody>';
	echo '<td>'.$date.'</td>';	
	
	echo '<td>'.$message.'</td>'.'</tbody>';
}
echo'</table>';

echo '</div>';


?>

<form action="answer3.php" method="post">

                 <div class="form-group">
                    <label for="Email">Answer</label>
                    <textarea class="form-control" type="text" name="answer" rows="2" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>


            
            </form>



 	 <!--center!-->  </div>
 	<div class="col-md-3"></div>
 </div>

 
 
 
 </body>
</html>