$(document).ready(function() {

	$("#contact" ).validVal();
	$( "input[type=submit]" ).on('click', function(event) {
		event.preventDefault();

		var form_data = $( "#contact" ).triggerHandler( "submitForm" );
		if ( form_data ) {
			$.ajax({
				type: "POST",
				url: "savecontact.php",
				data: form_data,
				beforeSend: function() { $("#sentm").html('Please wait sending details...'); },
				success: function( msg ) {
					$("#sentm").html('Thank you for contacting us.')
					$( "#contact" ).trigger( "resetForm" );
				}
			});
		}
	});

});
