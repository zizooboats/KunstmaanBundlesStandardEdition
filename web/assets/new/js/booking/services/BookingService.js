function BookingService ($q, $http, $window, $location, BASE_URL) {
    var BookingService = {};
    var baseUrl = BASE_URL + '/api/booking/v2/booking';
    var httpConfig = {
        headers: {
            'Content-Type': 'application/json'
        }
    };

    BookingService.payin = function (bookingId, paymentId, payload) {
        if (!bookingId) { throw new Error('BookingService.payin: bookingId is required'); }
        var deferred = $q.defer();

        $http
            .post(
                baseUrl + '/' + bookingId + '/payment/' + paymentId + '/payin',
                { 'payin': payload },
                httpConfig
            )
            .then(function(response) {
                if (response.status === 200) {
                    switch (response.data.status) {
                    case 'success':
                        $window.location.reload();
                        break;
                    case 'failed':
                        deferred.reject(response.data.error);
                        break;
                    case 'pending':
                        $window.location.href = response.data.action_required_url;
                        break;
                    default:
                        deferred.reject(response);
                        break;
                    }
                } else {
                    deferred.reject(response);
                }
            }, function(error) {
                deferred.reject(error);
            });

        return deferred.promise;
    };

    return BookingService;
}
BookingService.$inject = ['$q', '$http', '$window', '$location', 'BASE_URL'];

angular
    .module('BookingApp')
    .factory('BookingService', BookingService);
