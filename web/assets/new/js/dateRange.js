(function (document, $, radio) {

    'use strict';

    function init() {
        $('.js-date-range').each(function(i, el) {
            initRange(el);
        });
    }

    function initRange(rootEl) {
        var $rootEl = $(rootEl);
        var $dateFrom = $rootEl.find('.js-date-range-from');
        var $dateTo = $rootEl.find('.js-date-range-to');

        if (!$dateFrom.length || !$dateTo.length) return;

        var fromValue = $dateFrom.val();
        var toValue = $dateTo.val();
        var pickerFromData = $dateFrom.data();
        var pickerToData = $dateTo.data();
        var pickerOptions = {
            weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            showMonthsShort: true,
            close: false,
            format: 'yyyy-mm-dd',
            firstDay: 1,
            min: true
        };
        var pickerFromOptions = {};
        var pickerToOptions = {};

        if (pickerFromData.disabled) pickerFromOptions.disable = pickerFromData.disabled;
        if (pickerToData.disabled) pickerToOptions.disable = pickerToData.disabled;

        var fromPickerEl = $dateFrom.pickadate($.extend({}, pickerOptions, pickerFromOptions));
        var fromPicker = fromPickerEl.pickadate('picker');

        var toPickerEl = $dateTo.pickadate($.extend({}, pickerOptions, pickerToOptions));
        var toPicker = toPickerEl.pickadate('picker');

        function addHeader($element, text) {
            $element.find('.picker__wrap').prepend('<div class="picker__preheader">' + text + '</div>');
        }

        function openPicker(picker) {
            setTimeout(function () {
                picker.open();
            }, 350);
        }

        if (pickerFromData.header) addHeader(fromPicker.$root, pickerFromData.header);
        if (pickerToData.header) addHeader(toPicker.$root, pickerToData.header);

        if (pickerFromData.publishChange) radio('dateRangeFrom').broadcast(fromValue);
        if (pickerToData.publishChange) radio('dateRangeTo').broadcast(toValue);

        /*
        when From is set
            if both are empty
                set To to From and open To
            elseif To < From
                set To to From and open To

        when To is set
            if To < From
                set From to To and open From
        */

        fromPicker.on('set', function (event) {
            if (event.select) {
                if ((!fromValue && !toValue) || (toPicker.get('value') && (toPicker.get('select').pick < event.select))) {
                    toPicker.set('select', event.select);
                    openPicker(toPicker);
                }
            } else if ('clear' in event && toPicker.get('value')) {
                toPicker.set('clear');
            }

            fromValue = fromPicker.get('value');
            if (pickerFromData.publishChange) radio('dateRangeFrom').broadcast(fromValue);
        });

        toPicker.on('set', function (event) {
            if (event.select) {
                if (fromPicker.get('value') && (event.select < fromPicker.get('select').pick)) {
                    fromPicker.set('select', event.select);
                    openPicker(fromPicker);
                }
            } else if ('clear' in event && fromPicker.get('value')) {
                fromPicker.set('clear');
            }

            toValue = toPicker.get('value');
            if (pickerToData.publishChange) radio('dateRangeTo').broadcast(toValue);
        });
    }

    $(document).ready(init);

}(document, jQuery, radio));
