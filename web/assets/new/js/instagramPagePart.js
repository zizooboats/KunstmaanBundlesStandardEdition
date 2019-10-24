$( document ).ready(function()
{
	$( "button.instagram-load-more-btn" ).click(function( event ) {
		loadMore($(event.target));
	});
});


function loadMore($button) {

	var divWraper = $button.closest('.instagram-pp')[0];
	var divContainer = $(divWraper).find('.instagram-media-container')[0];

	var pageNumber = $button.attr('data-page');
	if(typeof pageNumber == 'undefined') {
		pageNumber = 0;
	}
	var mediaCount = $button.attr('data-count');
	var url = $button.attr('data-url');

	$.ajax({
		url: url,
		type: "GET",
		data: {
			'pageNumber': pageNumber,
			'mediaCount': mediaCount
		},
		success: function (data, textStatus, jqXHR) {
			$(divContainer).append(data.html);
			$button.attr('data-page', parseInt(pageNumber) + 1);
			if(!data.showLoadMore) {
				$button.hide();
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.error(jqXHR);
		}
	});
}