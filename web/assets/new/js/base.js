(function iifeBase (document, window, $, radio) {

    'use strict';

    var $doc = $(document);
    var $win = $(window);

    function lazyLoadImages() {
        $('.js-img-lazy').unveil(50, function () {
            $(this).load(function () {
                this.style.opacity = 1;
                this.className += ' js-img-lazy--is-loaded';
            });
        });
    }

    function trackPageview(url) {
        if (url) {
            if (typeof window.ga === 'function') {
                window.ga('send', 'pageview', url);
                console.log('Manually tracking pageview for', url);
            }
        } else {
            console.error('No url to track');
        }
    }

    // used on the search page to append the values of selected filters to the main search form
    // so that the user doesn't lose selected filters when making a new search
    function updateSearchFormFilters(url) {
        var elements = document.querySelectorAll('.js-search-filter');
        var searchFilterHolder = document.getElementById('js-search-filter-values');
        var successfulElements = [];
        var mergedValues = {};
        var markup = '';

        // get out if we're not on the search page
        if (!searchFilterHolder) { return; }

        // find selected/checked/filled elements
        [].forEach.call(elements, function (el) {
            switch (el.nodeName.toLowerCase()) {
            case 'input':
                if (el.type && el.type === 'checkbox' && el.checked) { successfulElements.push(el); }
                if (el.type && el.type === 'radio' && el.selected) { successfulElements.push(el); }
                if (el.type && /(text|number)/.test(el.type) && el.value.length) { successfulElements.push(el); }
                break;
            }
        });

        // combine values of elements with the same name, comma-delimited
        successfulElements.forEach(function (el) {
            if (mergedValues[el.name]) {
                mergedValues[el.name] += (',' + el.value);
            } else {
                mergedValues[el.name] = el.value;
            }
        });

        // construct markup with hidden inputs
        for (var key in mergedValues) {
            if (mergedValues.hasOwnProperty(key)) {
                markup += '<input type="hidden" name="' + key + '" value="' + mergedValues[key] + '">';
            }
        }

        // append hidden inputs to search form
        searchFilterHolder.innerHTML = markup;
    }

    function handleDeferredClicks() {
        document.removeEventListener('click', deferredClickListener, false);
        Object.keys(window.deferredClicks).forEach(function(key) {
            console.log('Triggering deferred click on', window.deferredClicks[key]);
            $(window.deferredClicks[key]).trigger('click');
        });
        window.deferredClicks = null;
    }

    function bindEvents() {
        radio('ajaxSuccess').subscribe(function (data) {
            lazyLoadImages();
            trackPageview(data.url);
            updateSearchFormFilters(data.url);
        });
    }

    function init() {
        lazyLoadImages();
        updateSearchFormFilters(document.location.href);
        bindEvents();
        handleDeferredClicks();
    }

    $doc.ready(init);

}(document, window, jQuery, radio));
