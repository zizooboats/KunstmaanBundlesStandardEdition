(function (document, window, $, radio, DeviceInspector) {

    'use strict';

    var $win = $(window);

    function init() {
        $('.js-fb-page').each(function () {
            var $el = $(this);
            var config = $el.data('config');

            if (!config) console.error('fbPage: config missing');

            if (typeof FB === 'object') {
                start($el, config);
            } else {
                radio('fbInit').subscribe(function () {
                    start($el, config);
                });
            }
        });
    }

    function start($el, config) {
        var debouncedRender = debounce(render, 200);

        render($el, config);
        $win.on('resize', debouncedRender.bind(null, $el, config));
    }

    function render($container, config) {
        var settings = getSettings(config);
        var tmpl = [
            '<div',
            '    class="fb-page"',
            '    data-href="' + settings.href + '"',
            '    data-width="' + settings.width + '"',
            '    data-height="' + settings.height + '"',
            '    data-tabs="' + settings.tabs + '"',
            '    data-small-header="false"',
            '    data-adapt-container-width="true"',
            '    data-hide-cover="false"',
            '    data-show-facepile="true"',
            '></div>',
        ].join('');

        $container.html(tmpl);
        FB.XFBML.parse($container[0]);
    }

    function getSettings(config) {
        var deviceSize = DeviceInspector.getDevice();
        var height = config.height;
        var tabs = 'timeline';

        if (deviceSize === 's') {
            height = 220;
            tabs = '';
        } else {
            if (/^\.js-/.test(height)) {
                height = $(height).outerHeight();
            }
        }

        return $.extend({}, config, {
            'height': height,
            'tabs': tabs,
        });
    }

    function debounce(fn, delay) {
        var timer = null;

        return function () {
            var context = this, args = arguments;

            clearTimeout(timer);
            timer = setTimeout(function () {
                fn.apply(context, args);
            }, delay);
        };
    }

    $win.load(init);

}(document, window, jQuery, radio, window.DeviceInspector));
