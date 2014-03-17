/*
 * autoload.js - any code in this file is loaded automatically on every page
 */

$(document).ready(function(){

	var ver = $().jquery;
	//alert(ver);
	//console.log("jQuery version: " + ver);

	function isNotOpenHouse(){
		var str = $(location).attr('href');
		if (str.toLowerCase().indexOf("openhouse") >= 0) return false;
		return true;
	}
	//console.log("oh: " + isNotOpenHouse());

	if ($("#form1").length > 0){

		$("#form1").validate({
			errorElement: "span",
			errorClass: "invalid",
			errorPlacement: function (error, element) {
				error.insertAfter(element);
			}
		});

	} //end if form1

	$("#icon_print").click(function(){ window.print(); });

	$('a.delete').click(function(event){
		event.preventDefault();
		var target = $(this).attr("href");

		var delete_confirm = $('<div></div>')
		.html('<p>This record will be permanently deleted and cannot be recovered. Are you sure?</p>')
		.dialog({
			autoOpen: false,
			resizable: false,
			modal: true,
			title: 'Confirm Delete',
			buttons: {
				"Delete": function(){
					$(this).dialog("close");
					window.location.href = target;
				},
				"Cancel": function(){
					$(this).dialog("close");
				}
			}
		});

		delete_confirm.dialog("open");
	});


});
