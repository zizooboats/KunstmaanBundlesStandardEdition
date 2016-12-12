function BasketService ($q, $http, $window, $location, BASE_URL, BASKET_API_VERSION) {
    var BasketService = {};
    var baseUrl = BASE_URL + '/api/booking/v' + (BASKET_API_VERSION || 2) + '/baskets';
    var baseCommandUrl = BASE_URL + '/api/command/v1/commands';
    var httpConfig = {
        headers: {
            'Content-Type': 'application/json',
            'Cache-Control': 'no-cache', // force fresh API call responses
            'Pragma': 'no-cache'
        }
    };

    function extractId(location) {
        var id = null;

        if (location) {
            id = location.match(/\/[^\/]+\/?$/)[0].replace(/\//g, '');
        }

        return id;
    }

    BasketService.get = function (id) {
        if (!id) { throw new Error('BasketService.get: id is required'); }

        return $http.get(baseUrl + '/' + id, httpConfig);
    };

    BasketService.create = function (payload) {
        if (!payload) { throw new Error('BasketService.create: payload is required'); }
        var deferred = $q.defer();

        $http
            .post(baseUrl, payload, httpConfig)
            .then(function(response) {
                if (response.status === 201) {
                    deferred.resolve({ id: extractId(response.headers().location) });
                } else {
                    deferred.reject(response.data);
                }
            }, function(error) {
                deferred.reject(error);
            });

        return deferred.promise;
    };

    BasketService.update = function (id, data) {
        if (!id) { throw new Error('BasketService.update: id is required'); }
        if (!data) { throw new Error('BasketService.update: data is required'); }

        return $http.patch(baseUrl + '/' + id, data, httpConfig);
    };

    BasketService.remove = function (id) {
        if (!id) { throw new Error('BasketService.remove: id is required'); }

        return $http.delete(baseUrl + '/' + id, httpConfig);
    };

    BasketService.createItem = function (basketId, payload) {
        if (!basketId) { throw new Error('BasketService.createItem: basketId is required'); }
        if (!payload) { throw new Error('BasketService.createItem: payload is required'); }
        var deferred = $q.defer();

        $http
            .post(baseUrl + '/' + basketId + '/items', payload, httpConfig)
            .then(function(response) {
                if (response.status === 201) {
                    deferred.resolve({ id: extractId(response.headers().location) });
                } else {
                    deferred.reject(response.data);
                }
            }, function(error) {
                deferred.reject(error);
            });

        return deferred.promise;
    };

    BasketService.removeItem = function (basketId, itemId) {
        if (!basketId) { throw new Error('BasketService.removeItem: basketId is required'); }
        if (!itemId) { throw new Error('BasketService.removeItem: itemId is required'); }

        return $http.delete(baseUrl + '/' + basketId + '/items/' + itemId, httpConfig);
    };

    BasketService.checkout = function (data, successUrl) {
        if (typeof data !== 'object') { throw new Error('BasketService.checkout: data is required'); }

        var deferred = $q.defer();
        var callbackUrl = $location.search().callback;
        var payload = { 'checkout_quote': data };

        function getCheckoutCommand(id) {
            return $http.get(baseCommandUrl + '/' + id, httpConfig);
        }

        if (callbackUrl) {
            payload.checkout_quote.action_required_return_url = callbackUrl;
        }

        $http
            .post(baseCommandUrl, payload, httpConfig)
            .then(function(response) {
                var headers = response.headers();

                if (response.status === 201) {
                    getCheckoutCommand(extractId(headers.location))
                        .then(function(response) {
                            var result = response.data.result;

                            switch (result.status) {
                            case 1: // failed
                                deferred.reject(result.message);
                                break;
                            case 2: // pending
                                $window.location.href = result.action_required.url;
                                break;
                            case 3: // success
                                $window.location.href = callbackUrl ? callbackUrl : successUrl;
                                break;
                            default:
                                deferred.reject(response);
                                break;
                            }
                        }, deferred.reject);
                } else {
                    deferred.reject(response);
                }
            }, function(error) {
                deferred.reject(error);
            });

        return deferred.promise;
    };

    return BasketService;
}
BasketService.$inject = ['$q', '$http', '$window', '$location', 'BASE_URL', 'BASKET_API_VERSION'];

angular
    .module('BookingApp')
    .factory('BasketService', BasketService);
