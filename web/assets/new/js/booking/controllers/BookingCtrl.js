function BookingCtrl ($log, $location, $window, $scope, $timeout, $filter, BasketService, NEXT_URL, BOAT_ID, MESSAGES, datalayers) {

    var vm = this;
    var queryParams = $location.search();
    vm.isDataLoaded = true;
    vm.data = {};
    vm.data.booking_basket = {};
    vm.data.booking_basket.boat = BOAT_ID;
    vm.data.skipper = false;
    window.vm = vm;

    function applyQueryParams() {
        var dateFormat = new RegExp('^[0-9]{4}-[0-9]{2}-[0-9]{2}$');

        if (queryParams.date_from && dateFormat.test(queryParams.date_from)) {
            vm.data.booking_basket.checkin = queryParams.date_from;
        }

        if (queryParams.date_to && dateFormat.test(queryParams.date_to)) {
            vm.data.booking_basket.checkout = queryParams.date_to;
        }

        if (queryParams.nr_guests) {
            queryParams.nr_guests = parseInt(queryParams.nr_guests, 10);
            vm.data.booking_basket.guest_count = isNaN(queryParams.nr_guests) ? 1 : queryParams.nr_guests;
        } else {
            vm.data.booking_basket.guest_count = 1;
        }

        if (queryParams.skipper === '1') {
            vm.data.skipper = true;
        }
    }

    function handleCheckout() {
        $location.search('basket', vm.data.booking_basket.id);
        $window.location.href = NEXT_URL + vm.data.booking_basket.id;
    }

    function triggerGlobalEvent(type, data) {
        if (type) {
            jQuery(document).trigger(type, data);
            radio(type).broadcast(data);
        }
    }

    function formatCurrency(amount) {
        return $filter('currency')(amount, '', 2);
    }

    function pushEcommerceDataLayer() {
        function eventExists(event) {
            var bool = false;
            window.dataLayer.forEach(function(el) { if (el.event === event) bool = true; });
            return bool;
        }

        if (typeof window.dataLayer === 'object' && typeof datalayers.booking === 'object') {
            // add and format price
            datalayers.booking.eventValue = formatCurrency(vm.data.booking_basket.basket_total);
            datalayers.booking.ecommerce.add.products[0].price = formatCurrency(vm.data.booking_basket.basket_total);
            // because the create basket sometimes fires twice, check first if the datalayer has already been pushed to
            if (!eventExists(datalayers.booking.event)) {
                window.dataLayer.push(datalayers.booking);
            }
        }
    }

    function lockUi() {
        vm.isDataLoaded = false;
        window.ajaxProcessFlag = 0;
    }

    function unlockUi() {
        vm.isDataLoaded = true;
        window.ajaxProcessFlag = 1;
    }

    function shouldShowMmkDiscountMessage() {
        var checkinDay = $filter('date')(vm.data.booking_basket.checkin, 'EEE');
        var checkoutDay = $filter('date')(vm.data.booking_basket.checkout, 'EEE');

        if (checkinDay === 'Sat' && checkoutDay === 'Sat') {
            vm.showMmkDiscountMessage = false;
        } else {
            vm.showMmkDiscountMessage = true;
        }
    }

    function syncSkipperState() {
        if (vm.data.booking_basket.basket_items.length) {
            if (vm.data.booking_basket.basket_items[0].product_id === 'skipper') {
                vm.data.skipper = true;
            } else {
                vm.data.skipper = false;
            }
        }
        triggerGlobalEvent('skipperChange', vm.data.skipper);
    }

    function getPayload() {
        var payload = {
            booking_basket: {
                checkin: vm.data.booking_basket.checkin,
                checkout: vm.data.booking_basket.checkout,
                boat: vm.data.booking_basket.boat,
                guest_count: vm.data.booking_basket.guest_count
            }
        };

        if (vm.data.booking_basket.basket_items) {
            payload.booking_basket.basket_items = vm.data.booking_basket.basket_items;
        } else if (vm.data.skipper) {
            payload.booking_basket.basket_items = [{ product_id: 'skipper' }];
        }

        return payload;
    }

    function handleError(response) {
        var errorObj;

        if (response.data.errors) {
            // symfony form error structure :(
            errorObj = response.data.errors.children;
            Object.keys(errorObj).forEach(function (prop) {
                if (errorObj[prop].errors) {
                    vm.data.formError = errorObj[prop].errors[0];
                }
            });
            vm.data.formError = vm.data.formError ? vm.data.formError : response.data.message;
        } else if (response.data.message) {
            vm.data.formError = response.data.message;
        } else {
            vm.data.formError = MESSAGES.errors.general;
        }
        throw new Error(response.statusText);
    }

    function setBasketId(id) {
        vm.data.booking_basket.id = id;
        // hack to notify other js modules of basketId
        triggerGlobalEvent('basketId', id);
    }

    function createBasket() {
        return BasketService
            .create(getPayload())
            .then(function (response) {
                vm.data.formError = false;
                setBasketId(response.id);
            })
            .catch(handleError);
    }

    function updateBasket() {
        return BasketService
            .update(vm.data.booking_basket.id, getPayload())
            .then(function (response) {
                vm.data.formError = false;
            })
            .catch(handleError);
    }

    function getBasket() {
        return BasketService
            .get(vm.data.booking_basket.id)
            .then(function (response) {
                vm.data.booking_basket = response.data.booking_basket;
                if (!vm.data.booking_basket.basket_total) {
                    vm.data.formError = MESSAGES.errors.no_price;
                } else {
                    vm.data.formError = false;
                    triggerGlobalEvent('boatPrice', formatCurrency(vm.data.booking_basket.basket_total));
                }
                syncSkipperState();
                triggerGlobalEvent('nr_guestsDropdownChange', vm.data.booking_basket.guest_count);
            })
            .catch(handleError);
    }

    function addSkipper() {
        return BasketService
            .createItem(vm.data.booking_basket.id, {
                'basket_item': {
                    'product_id': 'skipper'
                }
            })
            .then(function (response) {
                vm.data.formError = false;
            })
            .catch(handleError);
    }

    function removeSkipper() {
        var items = vm.data.booking_basket.basket_items;
        var itemId;

        if (items.length) itemId = items[0].id;

        return BasketService
            .removeItem(vm.data.booking_basket.id, itemId)
            .then(function (response) {
                vm.data.formError = false;
            })
            .catch(handleError);
    }

    // add/replace dates and guest num in url params
    // so booking widget state is persisted when going back and forth
    function updateUrlParams() {
        if (vm.data.booking_basket.checkin && vm.data.booking_basket.checkout) {
            $location.search('date_from', vm.data.booking_basket.checkin.split('T')[0]);
            $location.search('date_to', vm.data.booking_basket.checkout.split('T')[0]);
            $location.search('nr_guests', vm.data.booking_basket.guest_count);
            $location.search('skipper', vm.data.skipper ? '1' : '0');
            $location.replace();
        }
    }

    vm.resolveBasket = function () {
        $timeout(function() {
            if (vm.form.$valid) {
                lockUi();
                if (vm.data.booking_basket.id) {
                    updateBasket()
                        .then(getBasket)
                        .finally(unlockUi);
                } else {
                    createBasket()
                        .then(getBasket)
                        .then(pushEcommerceDataLayer)
                        .finally(unlockUi);
                }
                shouldShowMmkDiscountMessage();
                updateUrlParams();
            }
        }, 100);
    };

    vm.resolveSkipper = function () {
        lockUi();
        updateUrlParams();

        if (!vm.data.booking_basket.basket_items.length) {
            addSkipper()
                .then(getBasket)
                .finally(unlockUi);
        } else {
            removeSkipper()
                .then(getBasket)
                .finally(unlockUi);
        }
    };

    vm.handleOfferCheckout = function() {
        lockUi();
        $window.location.href = NEXT_URL + vm.data.booking_basket.id;
    };

    vm.processForm = function () {
        if (vm.form.$valid && vm.data.booking_basket.basket_total) {
            lockUi();
            handleCheckout();
        }
    };

    if (typeof datalayers.offer === 'object' && queryParams.offer) {
        window.dataLayer.push(datalayers.offer);
    }

    if (queryParams.basket) {
        setBasketId(queryParams.basket);
        lockUi();
        getBasket()
            .catch(function (error) {
                setBasketId(null);
            })
            .finally(unlockUi);
    } else {
        applyQueryParams();
        // wait for the form to become available in the controller
        $scope.$watch('vm.form', function (form) {
            // now wait for the form to validate itself :(
            $timeout(vm.resolveBasket, 500);
        });
    }

}
BookingCtrl.$inject = ['$log', '$location', '$window', '$scope', '$timeout', '$filter', 'BasketService', 'NEXT_URL', 'BOAT_ID', 'MESSAGES', 'datalayers'];

angular
    .module('BookingApp')
    .controller('BookingCtrl', BookingCtrl);
