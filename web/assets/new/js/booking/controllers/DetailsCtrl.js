function DetailsCtrl ($log, $location, $window, UserService, BasketService, USER_ID, READY_TO_BOOK, NEXT_URL) {

    var vm = this;
    var basketId = $location.search().basket;
    vm.data = {};
    vm.isBasketLoading = false;
    vm.isPromoLoading = false;
    window.vm = vm;
    function goToNextStep() {
        $window.location.href = NEXT_URL;
    }

    function createUser() {
        return UserService
            .create({ 'zizoo_user': vm.data.zizoo_user })
            .then(function (response) {
                $log.log('User registration success', response);
                return response.user;
            }, function (error) {
                vm.data.formError = error.statusText;
                throw new Error(error.statusText);
            });
    }

    function updateUser() {
        return UserService
            .update(USER_ID, { 'zizoo_user': vm.data.zizoo_user })
            .then(function (response) {
                $log.log('User update success', response);
            }, function (error) {
                vm.data.formError = error.statusText;
                throw new Error(error.statusText);
            });
    }

    function updateBasketWithUser(userId) {
        var payload = { booking_basket: {} };
        if (userId) payload.booking_basket.user = userId;

        return BasketService
            .update(basketId, payload)
            .then(function (response) {
                $log.log('Basket update success', response);
                goToNextStep();
            }, function (error) {
                vm.data.formError = error.statusText;
                throw new Error(error.statusText);
            });
    }

    function updateBasketWithPromoCode(code) {
        return BasketService
            .update(basketId, { booking_basket: { promo_code: code } })
            .then(function (response) {
                $log.log('Basket update success', response);
                vm.data.promoFormError = false;
            }, function (error) {
                vm.data.promoFormError = error.statusText;
                throw new Error(error.statusText);
            });
    }

    function getBasket() {
        vm.isBasketLoading = true;
        return BasketService
            .get(basketId)
            .then(function (response) {
                vm.data.booking_basket = response.data.booking_basket;
            })
            .finally(function () {
                vm.isBasketLoading = false;
            })
    }

    getBasket();

    vm.handlePromoCode = function (code) {
        if (code) {
            vm.isPromoLoading = true;
            updateBasketWithPromoCode(code)
                .then(getBasket)
                .finally(function () {
                    vm.isPromoLoading = false;
                });
        }
    };

    vm.processForm = function () {
        if (vm.form.$valid) {
            if (vm.data.booking_basket.user) {
                goToNextStep();
            } else {
                if (USER_ID) {
                    if (READY_TO_BOOK) {
                        updateBasketWithUser(USER_ID);
                    } else {
                        updateUser()
                        .then(updateBasketWithUser);
                    }
                } else {
                    createUser()
                        .then(updateBasketWithUser);
                }
            }
        }
    };

}
DetailsCtrl.$inject = ['$log', '$location', '$window', 'UserService', 'BasketService', 'USER_ID', 'READY_TO_BOOK', 'NEXT_URL'];

angular
    .module('BookingApp')
    .controller('DetailsCtrl', DetailsCtrl);
