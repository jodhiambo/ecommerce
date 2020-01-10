
<!DOCTYPE html>
<html>
 <head>
	<title>Water & Drainage Solution</title>
<link rel="stylesheet" type="text/css" href="css/main.css">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
<script src="js/jquery-3.0.0.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="admin/includes/script.js"></script><hr>
<a href="/eCommerce/index.php" alt="home" class="btn btn-warning text-right">Visit Home</a></b><br>

 </head>
 <body>

 <div class="col-md-12">

 	<div class="col-md-2"></div>
 	<div class="col-md-6">
 		

 		<?php
 		include('core/init.php');
 		// include 'includes/navigation.php';
 		if(!$_SESSION['usee']){
 			$_SESSION['usee']=0;
 		}
	$usee=$_SESSION['usee'];
	
	$se=mysqli_query($con,"SELECT * FROM messages WHERE session='$usee' ");

	echo '<div class="table">';
echo '<table class="table table-stripped" style="border=10px;">';
echo '<thead style="color:purple;">

<th>QUERY</th>
<th>ANSWER</th>

</thead>';
while($row=mysqli_fetch_assoc($se)){

	$message=$row['message'];
	$reply=$row['reply'];
	

		echo '<tbody>';
	echo '<td>'.$message.'</td>';	


	echo '<td>'.$reply.'</td>'.'</tbody>';
}
echo'</table>';

echo '</div>';


 		?>

 <form method="post">

                 <div class="form-group">
                    <label for="Email">Query</label>
                    <textarea class="form-control" type="text" name="query" cols="2" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
               <!--<button type="submit" class="btn btn-danger" name="close">Close</button> -->
            </form>		
            <?php
if(isset($_POST['submit'])){
	if(!$_SESSION['usee']){

		$max=mysqli_query($con,"SELECT MAX(session) as max FROM messages ");
		while($row=mysqli_fetch_assoc($max)){
			$max=$row['max'];
		}
		$_SESSION['usee']=$max+1;
	}
	$usee=$_SESSION['usee'];
	$query=$_POST['query'];
	$current=date("Y-m-d");
	$in=mysqli_query($con,"INSERT INTO messages(session,message_id,message,date) VALUES('$usee','','$query','$current') ");
	if($in){
header('location:chat.php');
	}

	else{
		echo mysqli_error();
	}

}
            ?>


 	 <!--center!-->  </div>
 	<div class="col-md-3"></div>
 </div>

 
 
 
 </body>
</html>