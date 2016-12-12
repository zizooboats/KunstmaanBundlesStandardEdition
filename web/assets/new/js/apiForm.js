(function (document, window, JSON, $) {

    'use strict';

    var timeout;

    function queryToObject(str) {
        return str.replace(/(^\?)/, '').split('&').map(function(n) { return n = n.split('='), this[n[0]] = decodeURIComponent(n[1]), this; }.bind({}))[0];
    }

    function handleSuccess($element) {}

    function loadData(config) {
        clearTimeout(timeout);

        timeout = setTimeout(function () {
            $.ajax({
                type: config.type || 'get',
                url: config.uri,
                data: JSON.stringify(config.data),
                contentType: 'application/json',
                beforeSend: function () {
                    config.$element.addClass('is-loading is-loading--w-indicator');
                    window.ajaxProcessFlag = 0;
                },
                success: function (response, status, xhr) {
                    if (response.status === 'success') {
                        showSuccessMsg(config.$element, config.params.messages.success);
                    } else {
                        showErrorMsg(config.$element, response.msg || config.params.messages.error);
                    }
                },
                error: function (xhr, status, error) {
                    showErrorMsg(config.$element, config.params.messages.error);
                },
                complete: function() {
                    config.$element.removeClass('is-loading is-loading--w-indicator');
                    window.ajaxProcessFlag = 1;
                }
            });
        }, 200);
    }

    function showErrorMsg($element, data) {
        $element.find('.js-error-holder').text(data);
    }

    function showSuccessMsg($element, data) {
        $element.replaceWith('<div class="notification notification--s bg-success">' + data + '</div>');
    }

    function isFormValid($element, data) {
        var isValid = true;
        var elements = $element.find('[required]');

        for (var i = elements.length - 1; i >= 0; i--) {
            if (!data[elements[i].name]) {
                isValid = false;
                break;
            }
        }

        return isValid;
    }

    $(document).on('submit', 'form[data-apiform]', function (e) {
        var element = e.target;
        var $element = $(element);
        var params = $element.data('apiform');
        var data;

        e.preventDefault();

        if (params.dataPadding) {
            data = {};
            data[params.dataPadding] = queryToObject($element.serialize());
        } else {
            data = queryToObject($element.serialize());
        }

        if (isFormValid($element, params.dataPadding ? data[params.dataPadding] : data)) {
            loadData({ uri: element.action, type: element.method, data: data, $element: $element, params: params });
        } else {
            showErrorMsg($element, params.messages.requiredError);
        }
    });

}(document, window, JSON, jQuery));
