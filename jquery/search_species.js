/******************************
**	search_species.js
**	elviscat@gmail.com
**  Author: Elvis Hsin-Hui Wu
*******************************/
function showMsg(e){
	
	$.post("showPost.php",
		{refsid:$("#refsid").val()},
		function(data){//do something
			//alert(data);
			//$('#msg').html('<h1>'+data+'</h1>');
			$('#msg').html(data);
			//$('#msg').fadeIn();
		});
	//$('#msg').html('<h1>This is a test!!</h1>');
}
$(document).ready(function(e){
	//$('#search_form').submit(showMsg);
	$('#submit').click(showMsg);
});



