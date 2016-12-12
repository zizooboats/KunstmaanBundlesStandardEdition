(function (doc, $, radio) {

    'use strict';

    var $doc = $(document);

    $doc.on('click', '.js-append-more', function (e) {
        var url = this.href;
        var $el = $(this);
        var $targetEl = $el.closest('.js-append-container').find('.js-append-items');
        var spinnerTpl = '&nbsp;<i class="fa fa-spinner fa-spin"></i>';

        if (!$el.find('.fa-spin').length) {
            $el.append(spinnerTpl);
        }

        e.preventDefault();

        if ($targetEl.length) {
            $.ajax({
                url: url,
                success: function(response) {
                    var $doc = $('<div>' + response + '</div>');
                    $targetEl.append($doc.find('.js-append-item'));
                    $el.replaceWith($doc.find('.js-append-more'));
                    radio('ajaxSuccess').broadcast({ url: url });
                }
            })
        }
    });

}(document, jQuery, radio));
