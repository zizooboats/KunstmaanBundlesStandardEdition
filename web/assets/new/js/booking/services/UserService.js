function UserService ($q, $http, BASE_URL) {
    var UserService = {};
    var baseUrl = BASE_URL + '/api/core/v1/users';
    var httpConfig = {
        headers: {
            'Content-Type': 'application/json'
        }
    };

    UserService.get = function (id) {
        if (!id) { throw new Error('UserService.get: id is required'); }

        return $http.get(baseUrl + '/' + id, httpConfig);
    };

    UserService.create = function (data) {
        if (!data) { throw new Error('UserService.create: data is required'); }
        var deferred = $q.defer();

        $http
            .post(baseUrl, data, httpConfig)
            .then(function(data) {
                var headers = data.headers();
                var id;

                if (headers.location) {
                    id = parseInt(headers.location.match(/\/[^\/]+\/?$/)[0].replace(/\//g, ''), 10);
                }

                if (data.status === 204) {
                    deferred.reject({ status: 400, statusText: 'This e-mail address is already in use. Please log in first.' });
                    // deferred.resolve({ user: 150 });
                } else if (data.status === 201) {
                    deferred.resolve({ user: id });
                }
            }, function(error) {
                deferred.reject(error);
            }, function(progress) {
                deferred.notify(progress);
            });

        return deferred.promise;
    };

    UserService.update = function (id, data) {
        if (!data) { throw new Error('UserService.create: data is required'); }
        var deferred = $q.defer();

        return $http.patch(baseUrl + '/' + id, data, httpConfig);
    };

    return UserService;
}
UserService.$inject = ['$q', '$http', 'BASE_URL'];

angular
    .module('BookingApp')
    .factory('UserService', UserService);
