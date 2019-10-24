(function (document, window, $, googleApiKey) {

	function triggerMapLoadedEvent() {
		$(document).trigger('googleMapLoaded');
	}

	function loadScript() {
		if (window.google && window.google.maps) {
			triggerMapLoadedEvent();
		} else {
			var script = document.createElement('script');
			document.body.appendChild(script);
			script.src = 'https://maps.googleapis.com/maps/api/js?key=' + googleApiKey + '&v=3.exp&callback=__initializeGoogleMaps';
		}
	}

	function initialize(el) {

		var elId = $(el).attr("id");
		var pagePartId = elId.replace("-map-container", "");

		var mapRouteLocations = window['mapRouteLocations_' + pagePartId];
		var mapOptions = {
			center: new google.maps.LatLng( mapRouteLocations[1]["lat"], mapRouteLocations[1]["lng"]),
			zoom: 10,
		};
		var map = new window.google.maps.Map(el, mapOptions);

		var bounds = new window.google.maps.LatLngBounds();
		var googleMarkers = [];

		var mapRouteCoordinates = [];

		var markerImage = {
			url: 'https://dev.zizoo.technology/assets/new/img/zizoo-map-marker-blue-big.png',
			labelOrigin: new google.maps.Point(27, 27)
		};

		for (var key in mapRouteLocations) {
			var position = new window.google.maps.LatLng(mapRouteLocations[key]["lat"], mapRouteLocations[key]["lng"]);

			googleMarkers.push(new window.google.maps.Marker({
				position: position,
				map: map,
				label: {
					color: "#5ac0cf",
					text: key,
					fontWeight: "900",
					fontSize: "x-large"
				},
				icon: markerImage,
			}));
			bounds.extend(position);

			var lineSymbol = {
				path: 'M 0,-1 0,1',
				strokeOpacity: 1,
				scale: 4
			};
			mapRouteCoordinates.push(mapRouteLocations[key]);
			var mapRoutePath = new window.google.maps.Polyline({
				path: mapRouteCoordinates,
				geodesic: true,
				strokeColor: '#FFFFFF',
				strokeOpacity: 0,
				icons: [{
					icon: lineSymbol,
					offset: '0',
					repeat: '20px'
				}],
				map: map,
			});
		}

		map.fitBounds(bounds);
	}

	window.__initializeGoogleMaps = function() {
		triggerMapLoadedEvent();
	};

	$(document).ready(function() {

		$(document).on('googleMapLoaded', function () {

			$(".map-pp-map-container").each(function (i, el) {
				var $el = $(el);
				if ($el.data('isMapLoaded')) { return; }
				initialize(el);
				$el.data('isMapLoaded', true);
			});
		});

		loadScript();
	});

}(document, window, jQuery, googleApiKey));
