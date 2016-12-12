function PaymentCtrl (
    $location,
    BasketService,
    MangopayPaymentService,
    PaymentwallPaymentService,
    PAYMENT_METHODS,
    EXP_MONTHS,
    EXP_YEARS,
    NEXT_URL,
    MESSAGES
) {

    var vm = this;
    var basketId = $location.search().basket;
    var PaymentService;
    vm.data = {};
    vm.data.existing_cards = [];
    vm.data.credit_card = {};
    vm.payment_methods = PAYMENT_METHODS;
    vm.exp_months = EXP_MONTHS;
    vm.exp_years = EXP_YEARS;
    vm.isNewCard = false;
    vm.isDataLoaded = false;
    vm.data.credit_card.exp_month = vm.exp_months[0];
    vm.data.credit_card.exp_year = vm.exp_years[0];

    window.vm = vm;

    function getBasket() {
        return BasketService
            .get(basketId)
            .then(function (response) {
                vm.data.booking_basket = response.data.booking_basket;

                if (!vm.data.booking_basket.payment_method) {
                    vm.data.booking_basket.payment_method = vm.payment_methods[0].id;
                }

                setPaymentService();
            });
    }

    function getUserCards() {
        return PaymentService
            .getUserCards()
            .then(function (response) {
                if (response.data.length) {
                    vm.data.existing_cards = response.data;

                    // set default values for existing cards
                    // FIXME: should set the first card which is not INVALID
                    applyCardToBasket(vm.data.existing_cards[0].token);
                }
            });
    }

    function registerCard() {
        return PaymentService
            .registerCard(vm.data.booking_basket.user, vm.data.credit_card)
            .then(function (cardToken) {
                vm.cardFormError = false;
                applyCardToBasket(cardToken);
            }, function (error) {
                vm.cardFormError = error;
                throw new Error(error);
            });
    }

    function updateBasket() {
        var extra_data = vm.data.booking_basket.payment_extra_data;

        if (PaymentService.getFingerprint && vm.data.booking_basket.payment_method != 'iban') {
            extra_data = angular.extend({}, vm.data.booking_basket.payment_extra_data, {
                paymentwall_fingerprint: PaymentService.getFingerprint()
            });
        }

        return BasketService
            .update(basketId, {
                booking_basket: {
                    payment_method: vm.data.booking_basket.payment_method,
                    payment_extra_data: extra_data
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
        var basket = vm.data.booking_basket;

        return BasketService
            .checkout({
                quote: basketId,
                payment_method: basket.payment_method,
                payment_extra_data: basket.payment_extra_data
            }, NEXT_URL)
            .then(function (response) {
                vm.formError = false;
            }, function (error) {
                vm.formError = error;
            });
    }

    function applyCardToBasket(id) {
        vm.data.booking_basket.payment_extra_data = {};
        vm.data.booking_basket.payment_extra_data.credit_card_id = id;
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

    function setPaymentService() {
        if (vm.isPaymentMethod('mangopay')) {
            PaymentService = MangopayPaymentService;
        } else {
            PaymentService = PaymentwallPaymentService;
        }
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
        var cardToken = vm.data.existing_cards[index].token;

        if (confirm(MESSAGES.interface.card_delete_prompt)) {
            vm.isDataLoaded = false;

            PaymentService
                .deleteUserCard(cardId)
                .then(function() {
                    vm.data.existing_cards.splice(index, 1);
                    vm.cardFormError = false;
                    if (
                        vm.data.booking_basket.payment_extra_data.credit_card_id
                        && (vm.data.booking_basket.payment_extra_data.credit_card_id == cardToken)
                    ) {
                        clearPaymentExtraData();
                        updateBasket();
                    }
                }, function (error) {
                    vm.cardFormError = error.statusText;
                })
                .finally(unlockSubmission);
        }
    };

    vm.isPaymentMethod = function (type) {
        var basket = vm.data.booking_basket;

        if (basket) {
            return basket.payment_method.indexOf(type) > -1;
        } else {
            return false;
        }
    };

    vm.changePaymentMethod = function(type) {
        setPaymentService();

        if (vm.isPaymentMethod('credit_card')) {
            lockSubmission();
            getUserCards()
                .finally(unlockSubmission);
        }
    };

    vm.processForm = function () {
        if (vm.form.$valid) {
            lockSubmission();

            if (vm.isPaymentMethod('credit_card')) {
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
    };

    // kickoff
    getBasket()
        .then(getUserCards)
        .finally(unlockSubmission);

}
PaymentCtrl.$inject = [
    '$location',
    'BasketService',
    'MangopayPaymentService',
    'PaymentwallPaymentService',
    'PAYMENT_METHODS',
    'EXP_MONTHS',
    'EXP_YEARS',
    'NEXT_URL',
    'MESSAGES'
];

angular
    .module('BookingApp')
    .controller('PaymentCtrl', PaymentCtrl);
