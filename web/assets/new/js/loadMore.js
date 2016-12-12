(function (doc, $) {

    'use strict';

    $(document.body).on('click', '.js-load-more', function (e) {
        var $el = $(this);
        var target = $el.data('target');
        var spinnerTpl = '&nbsp;<i class="fa fa-spinner fa-spin"></i>';

        if (!$el.find('.fa-spin').length) {
            $el.append(spinnerTpl);
        }

        e.preventDefault();

        if (target) {
            $.ajax({
                url: doc.location.href,
                data: { full: 1 },
                success: function(response) {
                    var $doc = $('<div>' + response + '</div>');
                    $(target).replaceWith($doc.find(target));
                },
                complete: function() {
                    $el.find('.fa-spin').remove();
                }
            })
        }
    });

}(document, jQuery));
