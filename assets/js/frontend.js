(function($){
		//new sendit js
		$('#senditform').submit(function(e){
			e.preventDefault();
			$('#sendit_subscribe_button').prop('disabled', true);
			$('#sendit_response').fadeOut();
			$('#sendit-wait').show();
			$('#sendit-wait').spin('start');

			subscriber = $( "#email_add" ).val();
			options = $("#senditform").serialize();
			lista = $('#lista').val();
				$.post(sendit_ajaxurl, {
					action: 'sendit_subscription',
					options: options, email_add: $( "#email_add" ).val(), lista: lista
				}, function(output) {
				$('#sendit_subscribe_button').prop('disabled', false);
				$('#sendit-wait').fadeOut();
				$('#sendit_response').fadeIn();
				$('#sendit_response').html(output);
				//alert(output);
			});
		});
})(jQuery);
