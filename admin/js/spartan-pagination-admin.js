(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(function() {

		$('#spartan-pagination-exclude').on('click', function(){
			var $this = $(this);
			var operation = 'add';
			if (!$this.is(':checked')) {
				operation = 'remove';
			}
			$.ajax({
				url: ajax_object.ajax_url,
				type: 'POST',
				data: {
					action: 'spartan_pagination_get_option',
					_ajax_nonce: ajax_object.nonce,
					pageId: spartan_pagination_page_id,
					operation: operation
				},
				dataType: 'json',
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(jqXHR.status);
				},
				// success: function(response) {
				// 	console.log(response);
				// 	$('.currently-excluded').html(response.excluded_pages);
				// }
			});
		});

	});

})( jQuery );
