(function (document, window, $) {

	'use strict';
	
	function setImageOverlay() {
		$(".image-overlay").each(function (i, el) {
			var imgArray = $(el).find('img');
			if(imgArray.length > 0) {
				var img = imgArray[0];

				if (img.tagName == 'IMG') {
					if(img.clientWidth == 0) {
						img.onload = function () {
							setCirclePosition(el, img);
						}
					}
					else {
						setCirclePosition(el, img)
					}
				}
			}
		});
	}

	function setCirclePosition(el, img)
	{
		var imgWidth = el.offsetWidth;
		var imgHeight = el.offsetHeight;

		var divCircle = $(el).find('.image-overlay-circle')[0];
		var span = $(divCircle).find('span')[0];
		var circleWidth = span.offsetWidth;

		circleWidth += 15;

		if(imgWidth < circleWidth) {
			imgWidth = circleWidth;
		}

		if(imgHeight < circleWidth) {
			imgHeight = circleWidth;
		}

		var x = imgWidth / 2 - circleWidth / 2;
		var y = imgHeight / 2 - circleWidth / 2;

		$(el).css("min-width", (parseInt(circleWidth) + 10) + "px");
		$(img).css("min-width", (parseInt(circleWidth) + 10) + "px");
		$(el).css("min-height", (parseInt(circleWidth) + 10) + "px");
		$(img).css("min-height", (parseInt(circleWidth) + 10) + "px");

		$(divCircle).css("width", circleWidth + "px");
		$(divCircle).css("height", circleWidth + "px");
		$(divCircle).css("line-height", circleWidth + "px");
		$(divCircle).css("left", x + "px");
		$(divCircle).css("top", y + "px");
		$(divCircle).css("padding", "0px");
	}

	$(document).ready(function() {
		setImageOverlay();

		$( window ).resize(function() {
			setImageOverlay();
		});
	});

}(document, window, jQuery));