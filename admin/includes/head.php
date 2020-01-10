<!DOCTYPE html>
<html lang="en">
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

<!-- <script type="text/javascript" src="/script.js" ></script> -->

<script type="text/javascript">
	function updatesizes(){
		// alert("update sizes");
		var sizeString ='';
		for(var i=1;i<=12;i++){
			if (jQuery('#size'+i).val()!=''){
				sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
			}

		}
		//alert(sizeString);
		
		jQuery('#sizes').val(sizeString); 
	}
	
</script>
<script src="../js/bootstrap.min.js"></script>

</head>
<body>
<div class="container-fluid">