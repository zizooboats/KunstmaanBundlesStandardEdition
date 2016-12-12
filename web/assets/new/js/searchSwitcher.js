(function (location, $, radio) {

    'use strict';

    var isInited = false;

    function queryToObject(str) {
        return (str || location.search).replace(/(^\?)/, '').split('&').map(function(n) { return n = n.split('='), this[n[0]] = n[1], this; }.bind({}))[0];
    }

    function isOnlyLocationSet(data) {
        var isLocationSet = true;
        var isOtherUnset = true;

        for (var item in data) {
            if (item !== 'location') {
                if (data[item] !== '') {
                    isOtherUnset = false;
                    break;
                }
            }
        }

        return isLocationSet && isOtherUnset;
    }

    function onSubmit(e) {
        e.stopPropagation();
        e.stopImmediatePropagation();

        var $element = $(e.target);
        var $locationEl = $('[name="location"]');
        var data = queryToObject($element.serialize());
        var uriRoot = $element.attr('data-location-url');

        if (isOnlyLocationSet(data)) {
            e.preventDefault();
            location.href = uriRoot + $locationEl.last().val();
        }
    }

    function init() {
        if (!isInited) {
            $(document).on('submit', '.js-search-switcher', onSubmit);
            isInited = true;
        }
    }

    radio('searchAutocompleteInit').subscribe(init);
    radio('searchDropdownInit').subscribe(init);

    // FIXME: for Location landing pages which have no selectize yet
    var config = $('.js-search-switcher').data('config');
    if (config && config.noWait) {
        init();
    }

}(window.location, jQuery, radio));
