$( document ).ready(function()
{
	$( "button.instagram-load-more-btn" ).click(function( event ) {
		loadMore($(event.target));
	});
});


function loadMore($button) {

	var divWraper = $button.closest('.wrapper')[0];
	var divContainer = $(divWraper).find('.instagram-media-container')[0];

	var mediaCount = $button.attr('data-count');
	var lastMediaId = $(divContainer).find('.instagram-media').last().attr('id');

	var url = $button.attr('data-url');
	var lastMediaParam = 'lastMediaId=' + lastMediaId;

	if(url.indexOf('?') === -1) {
		url += 	'?' + lastMediaParam;
	}
	else {
		url += '&' + lastMediaParam;
	}

	$.ajax({
		url: url,
		type: "GET",
		success: function (data, textStatus, jqXHR) {
			$(divContainer).append(data.html);
			if(!data.showLoadMore) {
				$button.hide();
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.error(jqXHR);
		}
	});
}