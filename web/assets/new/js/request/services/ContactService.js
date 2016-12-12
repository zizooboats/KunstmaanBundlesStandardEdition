function ContactService ($q, $http, BASE_URL) {
    var ContactService = {};
    var baseUrl = BASE_URL + '/api/boat/v2/contact_me';
    var httpConfig = {};

    ContactService.send = function (payload) {
        if (!payload) { throw new Error('ContactService.get: payload is required'); }

        return $http.post(baseUrl, { zizoo_contact_me: payload }, httpConfig);
    };

    return ContactService;
}
ContactService.$inject = ['$q', '$http', 'BASE_URL'];

angular
    .module('RequestApp')
    .factory('ContactService', ContactService);
