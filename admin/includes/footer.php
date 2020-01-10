
</div><br><br>  
<footer class="col-md-12 text-center" style="background-color:black; color: white;">&copy; copyright 2019-2030 Instant Water & Drainage Solutions
	 	
	 		<h6 class="text-left"><a href="" style="color: white;">About Us</a></h6><br><br>
	 
</footer>


<script>
	function updatesizes(){
		alert("update sizes");
		var sizeString ='';
		for(var i=1;i<=12;i++){
			if (jQuery('#size'+i).val()!=''){
				sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
			}

		}
		alert(sizeString);
		
		jQuery('#sizes').val(sizeString); 
	}
	function get_child_options(selected){
		if(typeof selected === 'undefined'){
			var selected = '';
		}
		var parentID = jQuery('#parent').val(),
		jQuery.ajax({
			url: '/eCommerce/admin/pasas/child_categories.php',
			type: 'POST',
			data: {parentID : parentID, selected: selected},
			success: function(data){
				jQuery('#child').html(data);
			},
			error: function(){alert("something went wrong with the child options.")};
		}),
	};
	jQuery('select[name="parent"]').change(function(){
		get_child_options();
	});
</script>
</body>
</html>