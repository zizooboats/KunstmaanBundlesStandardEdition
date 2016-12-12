(function (document, $) {

    'use strict';

    function init() {
        var $docEl = $(document.body);

        $docEl.popover({
            selector: '.js-header-menu',
            trigger: 'click',
            placement: 'bottom',
            container: 'body',
            template: '<div class="popover popover--header-menu" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
            html: true,
            content: function() {
                return $($(this).data('target')).clone();
            }
        }).on('click', function(e) {
            var $target = $(e.target);
            var isInPopover = $target.closest('.popover').length;
            var isTargetTrigger = $target.hasClass('js-header-menu');
            var $popEl;
            var $triggerEl;
            var triggerAPI;

            if (!isTargetTrigger && !isInPopover) {
                $popEl = $('.popover');
                $popEl.each(function(i, el) {
                    $triggerEl = $(el).data('bs.popover').$element;
                    $triggerEl.popover('hide');
                });
            } else if (isTargetTrigger) {
                $popEl = $('.popover');
                $popEl.each(function(i, el) {
                    $triggerEl = $(el).data('bs.popover').$element;

                    if ($target[0] !== $triggerEl[0]) {
                        $triggerEl.popover('hide');
                    }
                });
            }
        });
    }

    $(document).ready(init);

}(document, jQuery));
