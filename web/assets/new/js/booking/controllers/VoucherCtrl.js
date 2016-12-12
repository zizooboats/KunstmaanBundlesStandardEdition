function VoucherCtrl ($location, UserService, BasketService, PaymentService, USER_ID, PAYMENT_METHODS, EXP_MONTHS, EXP_YEARS, NEXT_URL, MESSAGES) {

    var vm = this;
    var basketId = $location.search().basket;
    vm.data = {};
    vm.data.zizoo_registration = {};
    vm.data.existing_cards = [];
    vm.data.credit_card = {};
    vm.payment_methods = PAYMENT_METHODS;
    vm.exp_months = EXP_MONTHS;
    vm.exp_years = EXP_YEARS;
    vm.isNewCard = false;
    vm.isDataLoaded = false;
window.vm = vm;
    // set default values for month and year dropdowns
    vm.data.credit_card.exp_month = vm.exp_months[0];
    vm.data.credit_card.exp_year = vm.exp_years[0];

    function createUser() {
        return UserService
            .create({ 'zizoo_registration': vm.data.zizoo_registration })
            .then(function (response) {
                console.log('User registration success', response);
                vm.data.booking_basket.user = response.user;
                return response.user;
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
                console.log('Basket user update success', response);
            }, function (error) {
                vm.data.formError = error.statusText;
                throw new Error(error.statusText);
            });
    }

    function createBasket() {
        var payload = { booking_basket: {} };
        if (USER_ID) payload.booking_basket.user = USER_ID;

        return BasketService
            .create(payload)
            .then(function (response) {
                vm.data.formError = false;
                console.log('Create basket response', response);
                basketId = response.id;
                $location.search('basket', basketId);
                $location.replace();
                return basketId;
            });
    }

    function getBasket(id) {
        return BasketService
            .get(id ? id : basketId)
            .then(function (response) {
                vm.data.booking_basket = response.data;
                // FIXME: this differs from basket v2 API because the response is not
                // embedded in "booking_basket"
                console.log('getBasket response', response.data);

                if (!vm.data.booking_basket.payment_method) {
                    vm.data.booking_basket.payment_method = vm.payment_methods[0].id;
                }
                return response.data;
            });
    }

    function addBasketItem() {
        return BasketService
            .createItem(basketId, {
                'basket_item': {
                    'product_id': 'voucher-' + $location.search().amount
                }
            })
            .then(function (response) {
                console.log('Add basket item response', response);
            })
            .catch(function (error) {
                console.error(error);
            });
    }

    function getUserCards() {
        return PaymentService
            .getUserCards(vm.data.booking_basket.user)
            .then(function (response) {
                if (response.data.cards.length) {
                    vm.data.existing_cards = response.data.cards;

                    // set default values for existing cards
                    // FIXME: should set the first card which is not INVALID
                    vm.data.booking_basket.payment_extra_data = {};
                    vm.data.booking_basket.payment_extra_data.mangopay_credit_card = vm.data.existing_cards[0].id;
                }
            });
    }

    function registerCard() {
        return PaymentService
            .registerCard(vm.data.booking_basket.user, vm.data.credit_card)
            .then(function (data) {
                vm.cardFormError = false;
                vm.data.booking_basket.payment_extra_data = {};
                vm.data.booking_basket.payment_extra_data.mangopay_credit_card = data.CardId;
            }, function (error) {
                vm.cardFormError = error;
                throw new Error(error);
            });
    }

    function updateBasket() {
        return BasketService
            .update(basketId, {
                booking_basket: {
                    payment_method: vm.data.booking_basket.payment_method,
                    payment_extra_data: vm.data.booking_basket.payment_extra_data
                }
            })
            .then(function (response) {
                vm.formError = false;
                return response.data;
            }, function (error) {
                vm.formError = error.statusText;
                throw new Error(error.statusText);
            });
    }

    function checkout() {
        return BasketService
            .checkout(basketId, NEXT_URL + '?basket=' + basketId)
            .then(function (response) {
                console.log('checkout response', response);
                vm.formError = false;
            }, function (error) {
                console.error('checkout error', error);
                vm.formError = error;
            });
    }

    function clearPaymentExtraData() {
        vm.data.booking_basket.payment_extra_data = null;
    }

    function lockSubmission() {
        vm.isDataLoaded = false;
    }

    function unlockSubmission() {
        vm.isDataLoaded = true;
    }

    vm.addNewCard = function () {
        vm.isNewCard = true;
        clearPaymentExtraData();
    };

    vm.disableNewCard = function () {
        vm.isNewCard = false;
    };

    vm.deleteCard = function (index) {
        var cardId = vm.data.existing_cards[index].id;

        if (confirm(MESSAGES.interface.card_delete_prompt)) {
            vm.isDataLoaded = false;

            PaymentService
                .deleteUserCard(vm.data.booking_basket.user, cardId)
                .then(function() {
                    vm.data.existing_cards.splice(index, 1);
                    vm.cardFormError = false;
                    if (vm.data.booking_basket.payment_extra_data.mangopay_credit_card && (vm.data.booking_basket.payment_extra_data.mangopay_credit_card == cardId)) {
                        clearPaymentExtraData();
                        updateBasket();
                    }
                }, function (error) {
                    vm.cardFormError = error.statusText;
                })
                .finally(function() {
                    unlockSubmission();
                });
        }
    };

    vm.processForm = function () {
        function handleCheckout() {
            if (vm.data.booking_basket.payment_method === 'mangopay.credit_card') {
                if (vm.data.booking_basket.payment_extra_data) {
                    updateBasket()
                        .then(checkout)
                        .finally(unlockSubmission);
                } else {
                    registerCard()
                        .then(updateBasket)
                        .then(checkout)
                        .finally(unlockSubmission);
                }
            } else {
                clearPaymentExtraData();
                updateBasket()
                    .then(checkout)
                    .finally(unlockSubmission);
            }
        }

        if (vm.form.$valid) {
            console.log('start processing form');
            lockSubmission();
            if (vm.data.booking_basket.user) {
                // FIXME: Should user data be updated in case of a payment error?
                handleCheckout();
            } else {
                createUser()
                    .then(updateBasketWithUser)
                    .then(handleCheckout);
            }
        }
    };

    if (basketId) {
        getBasket()
            .then(addBasketItem)
            .then(getBasket)
            .then(getUserCards)
            .finally(unlockSubmission);
    } else {
        createBasket()
            .then(getBasket)
            .then(addBasketItem)
            .then(getBasket)
            .then(getUserCards)
            .finally(unlockSubmission);
    }

}
VoucherCtrl.$inject = ['$location', 'UserService', 'BasketService', 'PaymentService', 'USER_ID', 'PAYMENT_METHODS', 'EXP_MONTHS', 'EXP_YEARS', 'NEXT_URL', 'MESSAGES'];

angular
    .module('BookingApp')
    .controller('VoucherCtrl', VoucherCtrl);
