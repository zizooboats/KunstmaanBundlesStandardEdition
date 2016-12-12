(function (document, localStorage, $, DeviceInspector) {

    'use strict';

    function init() {
        var $el = $('.js-newsletter-popup');

        if (!$el.length) {
            return;
        }

        if (/(l)|(xl)|(xxl)/.test(DeviceInspector.getDevice())) {
            $el
                .modal({
                    backdrop: 'static',
                    keyboard: false
                })
                .on('shown.bs.modal', function() {
                    document.getElementById('popup_newsletter_email').focus();
                })
                .on('hide.bs.modal', function() {
                    localStorage.setItem('newsletterPopupDismissed', 'true');
                });
        }
    }

    $(document).ready(function() {
        if (localStorage.getItem('newsletterPopupDismissed') !== 'true') {
            var due;
            var interval;

            if (!localStorage.getItem('newsletterPopupDue')) {
                localStorage.setItem('newsletterPopupDue', Date.now() + (1000 * 60));
            }

            due = Number(localStorage.getItem('newsletterPopupDue'));

            interval = setInterval(function() {
                if (Date.now() > due) {
                    clearInterval(interval);
                    localStorage.removeItem('newsletterPopupDue');
                    init();
                }
            }, 1000);
        }
    });

}(document, localStorage, jQuery, DeviceInspector));
