$(document).ready(function() {	

	function change_pane(panel_id){
		$('.login_pane').hide();
		$('#'+panel_id).show();
	}

	change_pane('login_pane');

	$('#a_register').click(function(event){
		event.preventDefault();
		change_pane('register_pane');
	});

	$('#a_remember').click(function(event){
		event.preventDefault();
		change_pane('remember_pane');
	});

	$('.a_login').click(function(event){
		event.preventDefault();
		change_pane('login_pane');
	});

	//Send Login Data
	$('#btn-login').click(function(){
		//Send ajax request
		$.ajax({
			url: $('#form-login').attr('action'),
			type: "post",
			data: $('#form-login').serialize(),
			// callback handler that will be called on success
			success: function(result){
				//Parse JSON
				var data = $.parseJSON(result);

				//Sucess
				if(data.result=='success'){
					document.location.href = data.url;
				}
				//Fail
				else{
					$('#div-login_message p').html(data.message);
					$('#div-login_message').show();
				}
			},
			// callback handler that will be called on error
			error: function(jqXHR, textStatus, errorThrown){
			    // log the error to the console
			    $('#error-container').slideToggle();
			}
		});	
	});

	//Send Register Data
	$('#btn-register').click(function(){
		//Send ajax request
		$.ajax({
			url: $('#form-register').attr('action'),
			type: "post",
			data: $('#form-register').serialize(),
			// callback handler that will be called on success
			success: function(result){
				//Parse JSON
				var data = $.parseJSON(result);

				$('#div-register_message p').html(data.message);
				$('#div-register_message').show();
			},
			// callback handler that will be called on error
			error: function(jqXHR, textStatus, errorThrown){
			    // log the error to the console
			    $('#error-container').slideToggle();
			}
		});	
	});

	//Send Register Data
	$('#btn-remember').click(function(){
		//Send ajax request
		$.ajax({
			url: $('#form-remember').attr('action'),
			type: "post",
			data: $('#form-remember').serialize(),
			// callback handler that will be called on success
			success: function(result){
				//Parse JSON
				var data = $.parseJSON(result);

				$('#div-remember_message p').html(data.message);
				$('#div-remember_message').show();
			},
			// callback handler that will be called on error
			error: function(jqXHR, textStatus, errorThrown){
			    // log the error to the console
			    $('#error-container').slideToggle();
			}
		});	
	});

	change_pane('login_pane');
});