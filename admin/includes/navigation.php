
<!--top nav bar -->
<nav class="navbar navbar-default navbar-fixed-top">
<div class="container">
	<a href="/eCommerce/admin/index.php" class="navbar-brand" > Instant Water & Drainage Solution Admin </a>
	<ul class="nav navbar-nav">
	<!--menu items-->
			<li><a href="brands.php">Brands</a></li>
			<li><a href="categories.php">Categories</a></li>
			<li><a href="products.php">Products</a></li>
			<li><a href="reply.php">reply</a></li>
			<?php if(has_permission('admin')): ?>
			<li><a href="users.php">Users</a></li>	
			<li><a href="achieved.php">Achieved</a></li>	
			<?php endif;?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome <?=$user_data['first'];?>!
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu" >
						<li><a href="change_password.php">Change Password</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
				
	
		<!-- <li class="dropdown">
			<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-right" role="menu">
			 <ul class="dropdown-divider"> 
				<li><a href="#"></a></li>
			</ul>
			</ul>
		</li> -->
	</ul>	
</div>
 </nav>
 