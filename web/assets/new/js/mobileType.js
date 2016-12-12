(function (doc, win) {

    'use strict';

    var hasTouch = 'ontouchstart' in win;
    var forEach = Array.prototype.forEach;

    if (!hasTouch) return;

    forEach.call(doc.querySelectorAll('input[data-mobile-type]'), function(el) {
        el.setAttribute('type', el.getAttribute('data-mobile-type'));
    });

}(document, window));
