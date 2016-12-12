(function (document, $) {

    'use strict';

    function checkValidity($fromEl, $toEl, $actionEl) {
        var fromVal = parseInt($fromEl.val(), 10);
        var toVal = parseInt($toEl.val(), 10);

        if (isNaN(fromVal) || isNaN(toVal)) return;

        if (fromVal <= toVal) {
            $actionEl.removeClass('u-hidden');
        } else {
            $actionEl.addClass('u-hidden');
        }
    }

    function initGroup(index, el) {
        var $rootEl   = $(el);
        var $fromEl   = $rootEl.find('[data-range-from]');
        var $toEl     = $rootEl.find('[data-range-to]');
        var $actionEl = $rootEl.find('[data-range-action]');

        checkValidity($fromEl, $toEl, $actionEl);

        $fromEl.on('change', function (e) {
            checkValidity($fromEl, $toEl, $actionEl);
        });
        $toEl.on('change', function (e) {
            checkValidity($fromEl, $toEl, $actionEl);
        });
    }

    function init() {
        var rangeGroups = $('[data-range]');

        rangeGroups.each(initGroup);
    }

    $(document).on('ready success.ajaxify', function() {
        init();
    });

}(document, jQuery));
