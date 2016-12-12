(function (document, $) {

    'use strict';

    function init() {
        $('.js-carousel-nav').each(function () {
            var $el = $(this);
            var config = $el.data('config');

            if (!config) console.error('carouselNav: config missing');

            if (config.minWidth) {
                if (document.documentElement.clientWidth >= config.minWidth) {
                    start($el, config);
                }
            } else {
                start($el, config);
            }
        });
    }

    function start($el, config) {
        loadItems($el, config.items);
        bindEvents($el, config.carousel);
        markItem($el, 0);
    }

    function loadItems($container, urls) {
        var tmpl = [
            '<img',
            '    src="{URL}"',
            '    data-index="{INDEX}"',
            '    width="60" height="40"',
            '    class="boatview__thumb js-carousel-thumb"',
            '    data-track="click"',
            '    data-track-label="Boat page"',
            '    data-track-action="Select gallery thumbnail"',
            '    alt=""',
            '>'
        ].join('');

        $container.html(urls.map(function(url, index) {
            return tmpl
                .replace('{URL}', url)
                .replace('{INDEX}', index);
        }).join(''));
    }

    function bindEvents($container, carouselSelector) {
        var carousel = jQuery(carouselSelector).data('owlCarousel');

        if (carousel) {
            carousel.options.beforeMove = function() {
                markItem($container, carousel.currentItem);
            };
        }

        $container.on('click', '.js-carousel-thumb', function(e) {
            var index = parseInt(e.target.getAttribute('data-index'), 10);

            if (!$(e.target).hasClass('is-current')) {
                $(carouselSelector).trigger('owl.goTo', index);
                markItem($container, index);
            }
        });
    }

    function markItem($container, index) {
        $container
            .find('.js-carousel-thumb')
            .removeClass('is-current')
            .eq(index)
            .addClass('is-current');
    }

    $(document).ready(init);

}(document, jQuery));
