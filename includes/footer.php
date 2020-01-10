
</div><br><br><br>
<footer class="col-md-12 text-center" style="background-color:black; color: white;">
	&copy; copyright 2019-2030 Instant Water & Drainage Solutions
	 <table class="table table-bordered table-striped table-auto dropdown-divider ">
	 	<tbody>
	 		<h6 class="text-left"><a href="about.php" >About Us</a></h6>
	 	</tbody>
	 </table>
</footer>


<script type="text/javascript">
	// jquery(window).scroll(function(){
	// 	var vscroll =jquery(this).scrollTop();
	// 	jquery('#logotext').css({
	// 		"transform" : "translate(0px, "+vscroll/2+"px)"
	// 	});
	// 	var vscroll =jquery(this).scrollTop();
	// 	jquery('#back-flower').css({
	// 		"transform" : "translate("+vscroll/5+"px, -"+vscroll/2+"px)"
	// 	});
	// 	var vscroll =jquery(this).scrollTop();
	// 	jquery('#for-flower').css({
	// 		"transform" : "translate(0px, -"+vscroll/2+"px)"
	// 	});
	// });
	function detailsmodal(id){ 
		
		var data = {"id" : id};
		jQuery.ajax({
			url : 'includes/detailsmodal.php',
			method : "POST",
			data : {"id" : id},
			success: function(data){
				jQuery('body').append(data);
				jQuery('#details-modal').modal('toggle');

			},
			error: function(){
				alert ("there is a problem somewhere!");

			}
		});

	}

	
	function add_to_cart(){
		// alert("it works");
		jQuery('#modal_errors').html("");
		var sizes = jQuery('#sizes').val();
		var quantity = jQuery('#quantity').val();
		var available = jQuery('#available').val();
		var error = '';
		var data = jQuery('#add_product_form').serialize();
		if (sizes == '' || quantity == '' || quantity ==0){
			error += '<p class ="text-center text-danger">You must choose size and quantity.</p>';
			jQuery('#modal_errors').html(error);
			return;
		}
		else if(quantity > available){
			error += '<p class ="text-center text-danger">there are only'+available+' available.</p>';
			jQuery('#modal_errors').html(error);
	return;

	}
	else{
		jQuery.ajax({
			url : '/eCommerce/admin/pasas/add_cart.php',
			method : 'post',
			data : data,
			success : function(){'Location.reload();'},
			error : function(){
				alart("something went wrong");
			}
		});
	}
}
	function update_cart(mode,edit_id,edit_size){
		var data = {"mode": mode, "edit_id" :edit_id, "edit_size": edit_size};
		jQuery.ajax({
			url : '/eCommerce/admin/pasas/update_cart.php',
			method : "post",
			data : data,
			success : function(){Location.reload();},
			error : function(){alart("something went wrong");},
		});
	}

</script>

</body>
</html>