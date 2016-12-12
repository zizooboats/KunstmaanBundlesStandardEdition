function InstallmentCtrl (
    $location,
    BookingService,
    MangopayPaymentService,
    PaymentwallPaymentService,
    PAYMENT_METHODS,
    EXP_MONTHS,
    EXP_YEARS,
    MESSAGES,
    USER,
    BOOKING,
    PAYMENT
) {

    var vm = this;
    var PaymentService;
    vm.data = {};
    vm.data.booking_basket = {};
    vm.data.existing_cards = [];
    vm.data.credit_card = {};
    vm.payment_methods = PAYMENT_METHODS;
    vm.exp_months = EXP_MONTHS;
    vm.exp_years = EXP_YEARS;
    vm.isNewCard = false;
    vm.isDataLoaded = false;
    vm.data.credit_card.exp_month = vm.exp_months[0];
    vm.data.credit_card.exp_year = vm.exp_years[0];
    vm.data.booking_basket.user = USER.id;
    vm.data.booking_basket.payment_method = vm.payment_methods[0].id;

window.vm = vm;

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

    function payin() {
        var extra_data = vm.data.booking_basket.payment_extra_data;

        if (PaymentService.getFingerprint) {
            extra_data = angular.extend({}, vm.data.booking_basket.payment_extra_data, {
                paymentwall_fingerprint: PaymentService.getFingerprint()
            });
        }

        return BookingService
            .payin(
                BOOKING.id,
                PAYMENT.id,
                {
                    payment_method: vm.data.booking_basket.payment_method,
                    payment_extra_data: extra_data
                }
            )
            .then(function (response) {
                vm.formError = false;
            })
            .catch(function (error) {
                vm.formError = error.data.message || error.statusText;
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
                        // FIXME: this is different, handle it
                        // updateBasket();
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
                    payin()
                        .finally(unlockSubmission);
                } else {
                    registerCard()
                        .then(payin)
                        .finally(unlockSubmission);

                }
            } else {
                clearPaymentExtraData();
                payin()
                    .finally(unlockSubmission);
            }
        }
    };

    // kickoff
    setPaymentService();
    getUserCards()
        .then(unlockSubmission);

}
InstallmentCtrl.$inject = [
    '$location',
    'BookingService',
    'MangopayPaymentService',
    'PaymentwallPaymentService',
    'PAYMENT_METHODS',
    'EXP_MONTHS',
    'EXP_YEARS',
    'MESSAGES',
    'USER',
    'BOOKING',
    'PAYMENT'
];

angular
    .module('BookingApp')
    .controller('InstallmentCtrl', InstallmentCtrl);
