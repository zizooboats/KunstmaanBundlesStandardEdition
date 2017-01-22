(function (document, window, $) {

	'use strict';
	
	function setImageOverlay() {
		$(".image-overlay").each(function (i, el) {
			var imgArray = $(el).find('img');
			if(imgArray.length > 0) {
				var img = imgArray[0];
				if(img.tagName == 'IMG') {

					var imgWidth = img.clientWidth;
					var imgHeight = img.clientHeight;
					console.log($(".image-overlay").height());
					console.log($(img).height());
					console.log($(img).css("height"));

					console.log(imgWidth);
					console.log(imgHeight);

					var divCircle = $(el).find('.image-overlay-circle')[0];
					var span = $(divCircle).find('span')[0];
					var circleWidth = span.offsetWidth;

					circleWidth += 15;
					var x = imgWidth/2 - circleWidth/2;
					var y = imgHeight/2 - circleWidth/2;
					$(divCircle).css("width", circleWidth + "px");
					$(divCircle).css("height", circleWidth + "px");
					$(divCircle).css("line-height", circleWidth + "px");
					$(divCircle).css("left", x + "px");
					$(divCircle).css("top", y + "px");
					$(divCircle).css("padding", "0px");

				}
			}
		});
	}

	$(document).ready(function() {
		setImageOverlay();

		$( window ).resize(function() {
			setImageOverlay();
		});
	});

}(document, window, jQuery));