$(document).ready(function(){
	$('#email_form').submit(function(){
		var email = $('#email_value').val();
		
		$.ajax({
			'url': 'pixel.submit.php',
			'type': 'post',
			'async': true,
			'cache': false,
			'data': {'email': email},
			'dataType': 'json',
			'error': function(jqXHR, textStatus, errorThrown) {
				alert('There has been an error. Refresh and try again?');
			},
			'success': function(data, textStatus, xhr) {
				console.log('You haz success!');
				console.log(data);
				
				$('#content div').html('<div class="info">Your pixel:</div><textarea>' + data.link + '</textarea>');
				$('#content textarea').focus();
			}
		});
		
		return false;
	});
});
