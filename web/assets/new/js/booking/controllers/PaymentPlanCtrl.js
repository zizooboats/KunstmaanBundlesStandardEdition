function PaymentPlanCtrl ($location, $window, BasketService, PAYMENT_PLANS, NEXT_URL) {

    var vm = this;
    var basketId = $location.search().basket;
    vm.data = {};
    vm.isBasketLoading = false;
    vm.payment_plans = PAYMENT_PLANS;
window.vm = vm;
    function goToNextStep() {
        $window.location.href = NEXT_URL;
    }

    function getBasket() {
        vm.isBasketLoading = true;

        return BasketService
            .get(basketId)
            .then(function onGetBasketSuccess(response) {
                vm.data = response.data;
                vm.isBasketLoading = false;
            })
            .catch(function onGetBasketError(error) {
                vm.isBasketLoading = false;
                throw new Error(error.data.message || error.statusText);
            });
    }

    function updatePlan() {
        return BasketService
            .update(basketId, { booking_basket: { payment_plan: vm.data.booking_basket.payment_plan } })
            .catch(function onUpdatePlanError(error) {
                throw new Error(error.data.message || error.statusText);
            });
    }

    getBasket();

    vm.handlePlanChange = function () {
        vm.isBasketLoading = true;

        updatePlan()
            .then(getBasket)
            .finally(function () {
                vm.isBasketLoading = false;
            });
    };

    vm.processForm = function () {
        if (vm.form.$valid) {
            goToNextStep();
        }
    };

}
PaymentPlanCtrl.$inject = ['$location', '$window', 'BasketService', 'PAYMENT_PLANS', 'NEXT_URL'];

angular
    .module('BookingApp')
    .controller('PaymentPlanCtrl', PaymentPlanCtrl);
