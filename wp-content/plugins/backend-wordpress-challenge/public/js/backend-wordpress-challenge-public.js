(function( $ ) {
	'use strict';

	$( document ).ready( function() {

		$('#confirmar_interesse').on( 'submit', function(e) {
			
			e.preventDefault();
			var serialized = $('#confirmar_interesse').serializeArray();

			$('#confirmar_interesse input').attr( 'disabled', true );
			$('#loading').css({"display": "inline-block"});

			var data = {};

			$.map( serialized, function(n, i){

				data[n['name']] = n['value'];
			});

			var action = $('#confirmar_interesse').attr('action');

			var email = $('#email').val();
			var curso_id = $('#curso_id').val();
			$.post( action.replace('insert', 'verify'), {curso_id: curso_id, email: email} )
			.success( has_interessado => {

				notify( has_interessado );

				if ( false === has_interessado ) {

					$.post( action, data )
					.success( response => {
						
						notify( response );
						window.location.href = JSON.parse( response ).redirect;
					})
					.fail( err => {

						$('#msg_status').text( err.responseJSON.message )
						.removeClass()
						.addClass( 'fail' );
					});
				}
			})
			.complete(() => {
						
				$('#confirmar_interesse input').attr( 'disabled', false );
				$('#loading').css({"display": "none"});
			});
		});
	});

	function notify( response ){

		let resp = JSON.parse( response );
					
		$('#msg_status').text( resp.message )
		.removeClass()
		.addClass( resp.code );
	}

})( jQuery );
