(function (document, window, $) {

    'use strict';

    var $doc = $(document);

    // FIXME: separate GMaps API into a standalone component
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

    function createInfoWindow() {
        return new google.maps.InfoWindow({
            content: ''
        });
    }

    function getInfoWindowContent(data, texts) {
        var tmpl = [
            '<div class="info-window">',
            '    <dl class="info-window__data">',
            '        <dt class="info-window__data-name">{NAME_LABEL}</dt>',
            '        <dd class="info-window__data-value">{NAME}</dd>',
            '        <dt class="info-window__data-name">{BOAT_COUNT_LABEL}</dt>',
            '        <dd class="info-window__data-value">{BOAT_COUNT}</dd>',
            '    </dl>',
            '    <a href="{URL}" target="_blank" class="button button--primary button--block info-window__cta">{CTA}</a>',
            '</div>'
        ].join('');

        return tmpl.replace('{NAME_LABEL}', texts.location)
                   .replace(/\{NAME\}/gm, data.name)
                   .replace('{BOAT_COUNT_LABEL}', texts.boatCount)
                   .replace('{BOAT_COUNT}', data.boat_count)
                   .replace('{URL}', data.url)
                   .replace('{CTA}', texts.cta);
    }

    function initialize(el, data) {
        var myLatlng = new window.google.maps.LatLng(data.lat, data.lng);
        var mapOptions = {
            zoom: data.zoom,
            center: myLatlng,
            scrollwheel: false,
            zoomControl: true,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false,
            // https://snazzymaps.com/style/61/blue-essence
            styles: [{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]}]
        };
        var map = new window.google.maps.Map(el, mapOptions);
        var bounds = new window.google.maps.LatLngBounds();
        var mapMarkers = [];
        var markerCluster;
        var infoWindow = createInfoWindow();

        function createMarker(position, itemData, texts) {
            var marker;
            var config = {
                position: position,
                map: map
            };

            if (data.markerImg) {
                config.icon = data.markerImg;
            }

            marker = new window.google.maps.Marker(config);

            if (itemData) {
                marker.addListener('click', function() {
                    infoWindow.setContent(getInfoWindowContent(itemData, texts));
                    infoWindow.open(map, marker);
                });
            }

            return marker;
        }

        if (data.markers && data.markers.length) {
            data.markers.forEach(function (item) {
                var position = new window.google.maps.LatLng(item.lat, item.lng);
                mapMarkers.push(createMarker(position, item, data.texts));
                bounds.extend(position);
            });

            if (data.markers.length === 1) {
                map.setZoom(data.zoom);
                map.panTo(mapMarkers[0].getPosition());
            } else {
                map.fitBounds(bounds);
            }

            markerCluster = new MarkerClusterer(map, mapMarkers, {
                gridSize: 50,
                maxZoom: 15,
                styles: [{
                    url: data.clusterImg,
                    width: 31,
                    height: 31,
                    textColor: '#333',
                    textSize: 13
                }]
            });
        }
    }

    window.__initializeGoogleMaps = function() {
        triggerMapLoadedEvent();
    };

    $doc.ready(function() {
        $('.js-locality-map')
            .on('click.map', function (e) {
                e.stopPropagation();
                e.stopImmediatePropagation();

                var $el = $(this);
                var data = $el.data('config');

                $doc.on('googleMapLoaded', function () {
                    if ($el.data('isLoaded')) { return; }

                    $el.css('height', data.height ? data.height : $el.css('height'));
                    initialize($el.get(0), data);
                    $el.data('isLoaded', true);
                    $el.off('click.map');
                });

                loadScript();
            })
            .css('cursor', 'pointer');
    });

}(document, window, jQuery));
