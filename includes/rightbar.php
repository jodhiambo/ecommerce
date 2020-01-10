<!--right side bar-->
	<div class="col-md-2">

		<a href="chat.php" class='message'><span></span><img src='/eCommerce/message.png' height='35' width='35' alt=''>Chat With Us </a><br>
	 <table class="table table-bordered table-striped table-auto ">
	 	<thead>
	 		<tr>Contact information</tr>
	 	</thead>
	 	<tbody>
	 	<th class="text-center">Safaricom<td>0718109741</td>
	 	</tbody>
	 </table>
   <?php
   include 'widgets/cart.php';
   include 'widgets/recent.php';

    ?>
	</div> 
<!-- <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: #555;
  color: white;
  padding: 10px 15px;
  border: none;
  cursor: pointer;
  opacity: 0.5;
  position: fixed;
  bottom: 23px;
  right: 5px;
  width: 280px;
}

/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: black;
  color: blue;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>
</head>
<body>
<button class="open-button" style="background-color: black; color: white;" onclick="openForm()">register / login</button>

<div class="form-popup" id="myForm">
  <form action="uregister.php" class="form-container">
    <h1>Login</h1>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit" class="btn">Login</button>
    
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
 	 <button type="submit" class="btn" onclick="regform()">Register here</button>
  </form>
 
</div>

<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
function regform(){
  document.getElementById("myForm").style.display = "block";
}
</script>

</body>
</html>

 -->

	
	
		
		