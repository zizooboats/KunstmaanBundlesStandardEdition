angular.module('BookingApp', [
    'angular-loading-bar'
]);

function config($locationProvider, $httpProvider, LOCALE) {
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });
    $httpProvider.defaults.headers.common['Accept-Language'] = LOCALE;
}
config.$inject = ['$locationProvider', '$httpProvider', 'LOCALE'];

angular
    .module('BookingApp')
    .config(config);
