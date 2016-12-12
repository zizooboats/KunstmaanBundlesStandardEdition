(function (document, location, history, $, radio) {

    'use strict';

    var networkTimeout;

    function extractQueryStringFromUri(uri) {
        if (/\?/.test(uri)) {
            return uri.split('?')[1];
        } else {
            return '';
        }
    }

    function queryToObject(str) {
        var string = str || location.search;

        if (string) {
            return string
                .replace(/(^\?)/, '')
                .split('&')
                .map(function(n) {
                    return n = n.split('='), this[n[0]] = n[1].replace(/%2C/g, ','), this;
                }.bind({}))[0];
        } else {
            return {};
        }
    }

    function stringToArray(str) {
        var arr = str.split(',');
        return arr.map(function (item) {
            return item.trim();
        });
    }

    function updateHistory(data) {
        if (typeof history.replaceState === 'function') {
            history.replaceState({}, '', data);
        }
    }

    function isNumberBetween(min, max, x) {
        return x >= min && x <= max;
    }

    function matchesPattern(code, comparator) {
        if (/-/.test(comparator)) {
            var c = comparator.split('-');
            return isNumberBetween(c[0], c[1], code);
        } else {
            return code == comparator;
        }
    }

    function isKeyAllowed(code, patterns) {
        return patterns.some(function(el) {
            return matchesPattern(code, el);
        });
    }

    function loadData(config) {
        clearTimeout(networkTimeout);

        networkTimeout = setTimeout(function () {
            var targetsSelector = config.targets.split(',');
            var targets = targetsSelector.map(function (item) {
                return $(item.trim());
            });
            var url = config.url || (location.protocol + '//' + location.host + location.pathname);
            var doc = $(document);

            $.ajax({
                type: config.type || 'get',
                url: url,
                data: config.data,
                beforeSend: function () {
                    doc.trigger('start.ajaxify', { url: url });
                    radio('ajaxifyStart').broadcast({ url: url });

                    targets.forEach(function (item) {
                        item.addClass('is-loading');
                    });
                    ajaxProcessFlag = 0;
                },
                success: function (response, status, xhr) {
                    var responseDOM = jQuery('<div>' + response + '</div>');

                    targets.forEach(function (item) {
                        item.replaceWith(responseDOM.find(item.selector));
                    });

                    doc.trigger('success.ajaxify', { url: url });
                    radio('ajaxSuccess').broadcast({ url: url });
                    ajaxProcessFlag = 1;
                },
                error: function (xhr, status, error) {
                    targets.forEach(function (item) {
                        item.removeClass('is-loading');
                    });

                    doc.trigger('error.ajaxify', { url: url });
                    radio('ajaxError').broadcast({ url: url });
                }
            });
        }, 200);
    }

    $(document).on('change', 'input[data-ajaxify], select[data-ajaxify]', function (e) {
        var element = e.target;
        var $element = $(e.target);
        var params = $element.data();
        var query = queryToObject();

        // if (/(input|select)/.test(element.nodeName.toLowerCase())) {}
        if (!('ajaxifyDebounce' in params)) {
            query[element.name] = element.value;
            updateHistory('?' + $.param(query));
            loadData({ data: query, targets: params.ajaxify });
        }
    });

    var inputDebounceTimeout;

    $(document).on('keydown', 'input[data-ajaxify-debounce]', function (e) {
        var element = e.target;
        var $element = $(e.target);
        var params = $element.data();
        var query = queryToObject();

        // https://css-tricks.com/snippets/javascript/javascript-keycodes/
        if (!isKeyAllowed(e.which, ['8-27', '33-57', '96-105'])) {
            e.preventDefault();
        }

        if ('ajaxifyDebounce' in params && isKeyAllowed(e.which, ['8', '13', '46', '48-57', '96-105'])) {
            clearTimeout(inputDebounceTimeout);
            inputDebounceTimeout = setTimeout(function() {
                query[element.name] = element.value;
                updateHistory('?' + $.param(query));
                loadData({ data: query, targets: params.ajaxify });
            }, 400);
        }
    });

    $(document).on('click', 'a[data-ajaxify]', function (e) {
        var element = e.target;

        if (e.target.nodeName.toLowerCase() !== 'a') {
            element = e.target.parentNode;
        }

        var $element = $(element);
        var uri = element.href;
        var params = $element.data();
        var query;

        if (params.ajaxifyInputs) {
            query = queryToObject(extractQueryStringFromUri(uri));
            stringToArray(params.ajaxifyInputs).forEach(function (item) {
                var el = document.querySelector(item);
                query[el.name] = el.value;
            });
            if (/\?/.test(uri)) {
                uri = uri.replace(/\?.+$/g, '?' + $.param(query));
            } else {
                uri = uri + '?' + $.param(query);
            }
        }

        e.preventDefault();

        updateHistory(uri);
        loadData({ url: uri, targets: params.ajaxify });
    });

    window.ajaxify = {
        loadData: loadData,
        updateHistory: updateHistory,
        queryToObject: queryToObject
    }

}(document, window.location, window.history, jQuery, radio));
