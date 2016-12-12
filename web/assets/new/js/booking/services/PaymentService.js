function BasePaymentService () {
    this.apiBase = '/api/payment/v1';
}

BasePaymentService.prototype.httpConfig = {
    headers: {
        'Content-Type': 'application/json'
    }
};

BasePaymentService.prototype.getUserCards = function () {
    return this.$http.get(
        this.apiBaseUrl + '/channels/' + this.name + '/cards',
        this.httpConfig
    );
};

BasePaymentService.prototype.deleteUserCard = function (cardId) {
    if (!cardId) throw new Error('BasePaymentService.deleteUserCard: cardId is required');

    return this.$http.delete(
        this.apiBaseUrl + '/cards/' + cardId,
        this.httpConfig
    );
};



MangopayPaymentService.prototype = Object.create(BasePaymentService.prototype);

function MangopayPaymentService($q, $http, BASE_URL, MESSAGES) {
    if (typeof mangoPay !== 'object') throw new Error('MangopayPaymentService: MangoPay js kit missing');

    BasePaymentService.call(this);

    this.name = 'mangopay';
    this.$http = $http;
    this.apiBaseUrl = BASE_URL + this.apiBase;

    this.registerCard = function (userId, cardData) {
        if (!userId) throw new Error('MangopayPaymentService.registerCard: userId is required');
        if (!cardData) throw new Error('MangopayPaymentService.registerCard: cardData is required');

        var deferred = $q.defer();
        var processedCardData = {
            cardNumber: cardData.number,
            cardExpirationDate: cardData.exp_month.concat(cardData.exp_year.slice(-2)),
            cardCvx: cardData.cvx,
            cardType: 'CB_VISA_MASTERCARD'
        };

        function getErrorMessage(id) {
            return MESSAGES.mangopay_errors[id] ? MESSAGES.mangopay_errors[id] : MESSAGES.mangopay_errors.default;
        }

        $http
            .post(
                BASE_URL + '/api/mangopay/v1/users' + '/' + userId + '/cards/registrations',
                this.httpConfig
            )
            .then(function(response) {
                mangoPay.cardRegistration.baseURL = response.data.baseURL;
                mangoPay.cardRegistration.clientId = response.data.clientId;
                delete response.data.baseURL;
                delete response.data.clientId;

                // Initialize the CardRegistration Kit
                mangoPay.cardRegistration.init(response.data);

                // Register card
                mangoPay.cardRegistration.registerCard(
                    processedCardData, // data
                    function (response) { // success
                        deferred.resolve(response.CardId);
                    },
                    function (error) { // error
                        deferred.reject(getErrorMessage(error.id));
                    });
            }, function (error) {
                deferred.reject(getErrorMessage());
            });

        return deferred.promise;
    };
}
MangopayPaymentService.$inject = ['$q', '$http', 'BASE_URL', 'MESSAGES'];

angular
    .module('BookingApp')
    .service('MangopayPaymentService', MangopayPaymentService);



PaymentwallPaymentService.prototype = Object.create(BasePaymentService.prototype);

function PaymentwallPaymentService($q, $http, BASE_URL, MESSAGES, PAYMENTWALL_KEY) {
    if (typeof Brick !== 'function') throw new Error('PaymentwallPaymentService: Brick.js kit missing');

    BasePaymentService.call(this);

    this.name = 'paymentwall';
    this.$http = $http;
    this.apiBaseUrl = BASE_URL + this.apiBase;
    this.brickAPI = new Brick({
        public_key: PAYMENTWALL_KEY,
        form: { formatter: true }
    }, 'custom');

    this.registerCard = function (userId, cardData) {
        if (!userId) throw new Error('PaymentwallPaymentService.registerCard: userId is required');
        if (!cardData) throw new Error('PaymentwallPaymentService.registerCard: cardData is required');

        var deferred = $q.defer();
        var processedCardData = {
            card_number: cardData.number,
            card_expiration_month: cardData.exp_month,
            card_expiration_year: cardData.exp_year,
            card_cvv: cardData.cvx
        };

        function getErrorMessage(id) {
            return MESSAGES.paymentwall_errors[id] ? MESSAGES.paymentwall_errors[id] : MESSAGES.paymentwall_errors.default;
        }

        this.brickAPI.tokenizeCard(
            processedCardData,
            function(response) {
                if (response.type == 'Error') {
                    deferred.reject(getErrorMessage(response.code));
                } else {
                    deferred.resolve(response.token);
                }
            }
        );

        return deferred.promise;
    };

    this.getFingerprint = function() {
        return Brick.getFingerprint();
    };
}
PaymentwallPaymentService.$inject = ['$q', '$http', 'BASE_URL', 'MESSAGES', 'PAYMENTWALL_KEY'];

angular
    .module('BookingApp')
    .service('PaymentwallPaymentService', PaymentwallPaymentService);
