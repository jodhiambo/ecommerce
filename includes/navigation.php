<?php
$sql = "SELECT * FROM categories WHERE parent = 0";
$pquery = $con -> query($sql);
?>




<!--top nav bar -->
<nav class="navbar navbar-default navbar-fixed-top">

<div class="container">
	<a href="index.php" class="navbar-brand" style="color: blue;" > Instant Water & Drainage Solution </a>
	<ul class="nav navbar-nav">
		<?php while($parent = mysqli_fetch_assoc($pquery)) : ?> 
		 <?php 
		 $parent_id = $parent['id']; 
		 $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
		 $cquery = $con->query($sql2);


		 ?>
		 <!-- menu items -->
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;"><?php echo $parent['category']; ?> 
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left" role="menu">
			 <ul class="dropdown-divider"> 
				<?php while ($child = mysqli_fetch_assoc($cquery)) : ?>
				<li><a href="category.php?cat=<?=$parent['id'];?>"><?php echo $child['category']; ?> </a></li>
				<?php endwhile; ?>
			</ul>
			</ul>
		</li>

		<?php endwhile; ?>
		<li><a href="cart.php" style="color: black;"><span class="glyphicon glyphicon-shopping-cart" style="color: green;"></span> My Cart</a></li>
	 <li><a href="chat.php" style="color: blue;">chat with us</a></li>
	 <!-- <li><a href="uregister.php" style="color: black;">register</a></li> -->
	</ul>
		
        </div>
    </div>
</div>
 </nav>
 