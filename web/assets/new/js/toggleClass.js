(function (document, scrollTo, $) {

    'use strict';

    $(document).on('click', '[data-toggle-class]', function (e) {
        var $element = $(this);
        var data = $element.data();
        var text;
        var altText;

        if (data.config && data.config.scrollToTop) { scrollTo(0, 0); }

        if (data.target) {
            $(data.target).toggleClass(data.toggleClass);
            $element.toggleClass(data.toggleClass);
        } else {
            $element.toggleClass(data.toggleClass);
        }

        if (data.toggleText) {
            text = this.innerHTML;
            altText = this.getAttribute('data-toggle-text');

            this.innerHTML = altText;
            this.setAttribute('data-toggle-text', text);
        }

        e.preventDefault();
    });

}(document, window.scrollTo, jQuery));
