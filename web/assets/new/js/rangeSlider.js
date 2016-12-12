(function (document, $) {

    'use strict';

    function initSlider(el, config) {
        var $el = $(el);
        var $tooltipFromEl = $el.siblings('.js-tooltip-from');
        var $tooltipToEl = $el.siblings('.js-tooltip-to');
        var $fromInput = $el.closest('.fm-field').find('.js-search-filter-from');
        var $toInput = $el.closest('.fm-field').find('.js-search-filter-to');

        // console.log('init range slider', config);

        if (!el) {
            return;
        }

        if (typeof config.min !== 'number') {
            config.min = 0;
        }

        if (typeof config.max !== 'number') {
            throw new Error('rangeSlider: config.max is missing or not a number');
        }

        // var currencyFormat = wNumb({
        //     decimals: 0,
        //     thousand: ',',
        //     postfix: '€',
        // });
        // function formatter(compareValue, prefix, value) {
        //     if (value === compareValue) {
        //         return prefix + currencyFormat.to(value);
        //     } else {
        //         return currencyFormat.to(value);
        //     }
        // }

        noUiSlider.create(el, {
            start: [config.from || config.min, config.to || config.max],
            step: config.step || 1,
            margin: config.margin || 1,
            connect: true,
            // tooltips: [
            //     { to: formatter.bind(undefined, config.from, '<&nbsp;') },
            //     { to: formatter.bind(undefined, config.to, '>&nbsp;') }
            // ],
            range: {
                'min': config.min,
                'max': config.max
            }
        });

        el.noUiSlider.on('update', function(values, handle) {
            var value = values[handle];
            var roundedValue = Math.round(value);

            if (handle) {
                if (config.openended && (roundedValue == config.max)) {
                    $tooltipToEl.html('>&nbsp;' + config.max);
                } else {
                    $tooltipToEl.html(roundedValue);
                }
            } else {
                $tooltipFromEl.html(roundedValue);
            }
        });

        el.noUiSlider.on('change', function(values, handle) {
            var value = values[handle];
            var roundedValue = Math.round(value);
            var inputData;

            if (handle) {
                inputData = $toInput.data();
                $toInput.val(roundedValue);
                if (config.openended && (roundedValue == config.max)) {
                    ajax($toInput.attr('name'), '', inputData.ajaxify);
                    EventTracker.track({
                        label: inputData.trackLabel,
                        action: inputData.trackAction,
                        value: '> ' + config.max
                    });
                } else {
                    ajax($toInput.attr('name'), roundedValue, inputData.ajaxify);
                    EventTracker.track({
                        label: inputData.trackLabel,
                        action: inputData.trackAction,
                        value: roundedValue
                    });
                }
            } else {
                inputData = $fromInput.data();
                $fromInput.val(roundedValue);
                ajax($fromInput.attr('name'), roundedValue, inputData.ajaxify);
                EventTracker.track({
                    label: inputData.trackLabel,
                    action: inputData.trackAction,
                    value: roundedValue
                });
            }
        });
    }

    function ajax(name, value, targets) {
        var query = window.ajaxify.queryToObject();

        query[name] = value;
        window.ajaxify.updateHistory('?' + $.param(query));
        window.ajaxify.loadData({ data: query, targets: targets });
    }

    function init() {
        var sliders = $('.js-range-slider');

        sliders.each(function(idx, el) {
            initSlider(el, $(el).data());
        });
    }

    $(document).on('ready', function() {
        init();
    });

}(document, jQuery));
