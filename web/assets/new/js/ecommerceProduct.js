(function (document, window, $) {

    'use strict';

    function init() {
        $('.js-ecommerce-product-click').on('click', function (e) {
            var $el = $(this);
            var props = $el.closest('.js-ecommerce-product').data();
            var boatData = window.boatEcommerceData;
            var payload = {
                'event': 'productClick',
                'ecommerce': {
                    'click': {
                        'actionField': {},
                        'products': []
                    }
                }
            };

            if (typeof props.position === 'number' && boatData) {
                if (props.ecommerceList) {
                    payload.ecommerce.click.actionField.list = props.ecommerceList;
                }
                payload.ecommerce.click.products.push(boatData[props.position]);
                window.dataLayer.push(payload);
            }
        });
    }

    $(document).ready(init);

}(document, window, jQuery));
