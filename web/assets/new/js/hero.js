(function (document, $) {

    'use strict';

    if (!('transition' in document.createElement('p').style)) {
        console.log('.js-hero: browser does not support CSS transitions');
        return;
    }

    function createElements(images) {
        var markup = '';

        images.forEach(function(image) {
            markup += '<div class="hero__image" style="background-image: url(' + image + ');"></div>';
        });

        return markup;
    }

    function start($el, images, delay) {
        var imageIndex = 0;

        function getNextImage() {
            return images[(imageIndex++) % images.length];
        }

        setInterval(function() {
            images.removeClass('is-current');
            $(getNextImage()).addClass('is-current');
        }, delay);
    }

    $('.js-hero').each(function () {
        var $el = $(this);
        var config = $el.data('config');
        var images = $el.data('images');
        var elements;

        if (config && config.minWidth) {
            if (document.documentElement.clientWidth >= config.minWidth) {
                elements = $(createElements(images)).appendTo($el);
                start($el, elements, config.delay);
                console.log('.js-hero: started with config', config);
            } else {
                console.log('.js-hero: viewport is < ' + config.minWidth + 'px');
            }
        } else {
            console.log('.js-hero: no config found');
        }
    });

}(document, jQuery));
