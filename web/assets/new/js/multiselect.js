(function (document, $) {

    'use strict';
    function init() {
        $('.js-multiselect').each(function() {
            var el = this;
            var $el = $(el);
            var $hiddenEl = $('<input type="hidden" name="' + el.name + '" value="' + getValues(el) + '">');
            var config = $el.data('config');
            var defaults = {
                buttonClass: 'fm-widget2',
                // buttonContainer: '',
                // inheritClass: true,
                onInitialized: function(select, container) {
                    select
                        .addClass('is-loaded u-hidden')
                        .closest('.fm-multiselect2')
                        .css('visibility', 'visible');
                },
                onChange: function(option, checked) {
                    $hiddenEl.val(getValues(el));
                },
            };
            var settings = $.extend({}, defaults, config);

            $hiddenEl.insertAfter($el);

            $el
                .attr('multiple', 'multiple')
                .multiselect(settings);

            $el.removeAttr('name');
        });
    }

    function getValues(el) {
        var reduce = Array.prototype.reduce;

        return reduce.call(el.selectedOptions, function(acc, option) {
            if (acc.length) {
                acc += (',' + option.value);
            } else {
                acc = option.value;
            }

            return acc;
        }, '');
    }

    $(document).ready(init);

}(document, jQuery));
