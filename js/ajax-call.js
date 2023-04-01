(function($) {

	$(document).on( 'click', 'a.post-month-ajax-call', function( event ) {
		event.preventDefault();
		$('a.post-month-ajax-call').removeClass('active');
		$(this).addClass('active');
		var month = $(this).attr('data-month-id');

		// alert(month);

		$.ajax({
			url: ajaxcall.ajaxurl,
			type: 'post',
			data: {
				action : 'ajax_get_post_by_month',
				month  : month
			},
			beforeSend: function() {
				$('#places #places-list').html("");
				$(document).scrollTop();
				$('#places #places-list').append( '<div class="post-content alert alert-primary" id="loader">Loading</div>' );
				$('#place').css({
					'left' : '100%',
					'transition' : '1s'
				});
			},
			success: function( html ) {
				$('#places #places-list #loader').remove();
				$('#places #places-list').html( html );
			}
		});

	});


	$(document).on( 'click', '.ajax-post-call', function( event ) {
		event.preventDefault();
		$('div.card.stacked').removeClass('bg-primary').removeClass('text-white');
		$(this).find('div.card.stacked').addClass('bg-primary').addClass('text-white');
		var post_id = $(this).attr('data-post-id');
		Mapper.handleShowPost(post_id);
	});



	$(document).on( 'click', 'a.previous_post', function( event ) {
		event.preventDefault(); 
		var previd = $(this).attr('data-previd');
		Mapper.handleShowPost(previd);
	});

	$(document).on( 'click', 'a.next_post', function( event ) {
		event.preventDefault(); 
		var nextid = $(this).attr('data-nextid');
		Mapper.handleShowPost(nextid);
	});


})(jQuery);
