angular
    .module('BookingApp')
    .directive('dateOnly', function () {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                ngModel.$formatters.push(function(value) {
                    return value ? value.split('T')[0] : value;
                });
                ngModel.$parsers.push(function(value) {
                    return value ? value.split('T')[0] : value;
                });
            }
        };
    });
