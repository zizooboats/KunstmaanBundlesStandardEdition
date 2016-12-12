(function (document, window, $) {

    'use strict';

    var $doc = $(document);

    function triggerMapLoadedEvent() {
        $doc.trigger('googleMapLoaded');
    }

    function loadScript() {
        if (window.google && window.google.maps) {
            triggerMapLoadedEvent();
        } else {
            var script = document.createElement('script');
            document.body.appendChild(script);
            script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&callback=__initializeGoogleMaps';
        }
    }

    function initialize(el, data) {
        var myLatlng = new window.google.maps.LatLng(data.lat, data.lng);
        var mapOptions = {
            zoom: data.zoom,
            center: myLatlng,
            scrollwheel: false
        };
        var map = new window.google.maps.Map(el, mapOptions);
        var bounds = new window.google.maps.LatLngBounds();
        var marker;
        var googleMarkers = [];

        if (data.markers && data.markers.length) {
            data.markers.forEach(function (item) {
                var position = new window.google.maps.LatLng(item.lat, item.lng);
                googleMarkers.push(new window.google.maps.Marker({
                    position: position,
                    map: map
                }));
                bounds.extend(position);
            });

            if (data.markers.length === 1) {
                map.setZoom(data.zoom);
                map.panTo(googleMarkers[0].getPosition());
            } else {
                map.fitBounds(bounds);
            }
        } else {
            marker = new window.google.maps.Marker({
                position: myLatlng,
                map: map
            });
        }
    }

    window.__initializeGoogleMaps = function() {
        triggerMapLoadedEvent();
    };

    $doc.ready(function() {
        $('[data-map]')
            .on('click.map', function () {
                var $el = $(this);
                var data = $el.data('map');

                $doc.on('googleMapLoaded', function () {
                    if ($el.data('isMapLoaded')) { return; }

                    $el.css('height', data.height ? data.height : $el.css('height'));
                    initialize($el.get(0), data);
                    $el.data('isMapLoaded', true);
                    $el.off('click.map');
                });

                loadScript();
            })
            .css('cursor', 'pointer');
    });

}(document, window, jQuery));
