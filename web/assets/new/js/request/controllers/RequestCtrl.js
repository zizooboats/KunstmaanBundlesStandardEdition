function RequestCtrl (
    $location,
    $window,
    $timeout,
    $scope,
    ContactService,
    config
) {

    var vm = this;
    var queryParams = $location.search();
    var gclid = (name = new RegExp('(?:^|;\\s*)gclid=([^;]*)').exec(document.cookie)) ? name.split(',')[1] : '';

    vm.isDataLoaded = true;
    vm.isSent = false;
    vm.data = {};
    vm.data.extra_fields = {};
    vm.data.extra_fields.adults = '1';
    vm.data.extra_fields.newsletter = true;
    vm.data.extra_fields.eagerness = 'asap';
    vm.data.extra_fields.txt_gclid = gclid; /* Campaign_Content */
    window.vm2 = vm;

    if (config.USER) {
        angular.extend(vm.data, config.USER);
    }

    if (config.BOAT) {
        vm.data.extra_fields.boat_id = config.BOAT.id;
    }

    if (config.LOCATION) {
        if (config.widgetType === 'full') {
            radio('searchAutocompleteInit').subscribe(function() {
                setLocationDropdown(config.LOCATION);
            });
        } else {
            vm.data.extra_fields.location = config.LOCATION;
        }
    } else {
        // wait for the form to become available in the controller
        $scope.$watch('vm.form', function (form) {
            vm.form.$setValidity('location', false);
        });
    }

    if (config.DATES.checkin) {
        vm.data.extra_fields.checkin = config.DATES.checkin;
    }

    if (config.DATES.checkout) {
        vm.data.extra_fields.checkout = config.DATES.checkout;
    }

    if (config.GUESTS) {
        vm.data.extra_fields.adults = config.GUESTS;
    }

    if (config.source) {
        vm.data.extra_fields.source = config.source;
    }

    if (config.widgetType === 'full') {
        vm.data.extra_fields.boat_types = [];

        vm.toggleBoatTypeSelection = function(item) {
            var idx = vm.data.extra_fields.boat_types.indexOf(item);

            if (idx > -1) {
                // is currently selected
                vm.data.extra_fields.boat_types.splice(idx, 1);
            }
            else {
                // is newly selected
                vm.data.extra_fields.boat_types.push(item);
            }
        };
    }

    jQuery(document).on('basketId', function (event, id) {
        vm.data.extra_fields.basket_id = id;
    });

    jQuery(document).on('boatPrice', function (event, amount) {
        config.BOAT.price = amount;
    });

    radio('locationDropdownChange').subscribe(setLocationDropdown);

    radio('rf_locationDropdownChange').subscribe(setLocationValue);

    radio('nr_guestsDropdownChange').subscribe(function(val) {
        $scope.$apply(function() {
            vm.data.extra_fields.adults = val;
        });
    });

    radio('skipperChange').subscribe(function(val) {
        $scope.$apply(function() {
            vm.data.extra_fields.skipper = val;
        });
    });

    radio('dateRangeFrom').subscribe(function(val) {
        $scope.$apply(function() {
            vm.data.extra_fields.checkin = val;
        });
    });

    radio('dateRangeTo').subscribe(function(val) {
        $scope.$apply(function() {
            vm.data.extra_fields.checkout = val;
        });
    });

    function toTitleCase(str) {
        return str.replace(
            /\w\S*/g,
            function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            }
        );
    }

    function setLocationValue(val) {
        $scope.$apply(function() {
            vm.data.extra_fields.location = val;
            vm.form.$setValidity('location', val ? true : false);
        });
    }

    function setLocationDropdown(val) {
        var payload = { id: val, name: toTitleCase(val.replace(/-/g, ' ')) };
        var el = document.getElementById('rf_location');

        el.selectize.addOption(payload);
        el.selectize.refreshOptions();
        el.selectize.setValue(val);

        setLocationValue(val);
    }

    function lockUi() {
        vm.isDataLoaded = false;
        window.ajaxProcessFlag = 0;
    }

    function unlockUi() {
        vm.isDataLoaded = true;
        window.ajaxProcessFlag = 1;
    }

    function handleError(response) {
        var errorObj;

        if (response.data.errors && response.data.errors.children) {
            // symfony form error structure :(
            errorObj = response.data.errors.children;
            Object.keys(errorObj).forEach(function (prop) {
                if (errorObj[prop].errors) {
                    vm.formError = errorObj[prop].errors[0];
                }
            });
            vm.formError = vm.formError ? vm.formError : response.data.message;
        } else if (response.data.message) {
            vm.formError = response.data.message;
        } else {
            vm.formError = config.MESSAGES.errors.general;
        }

        throw new Error(response.statusText);
    }

    function sendMessage() {
        lockUi();

        return ContactService
            .send(vm.data)
            .then(function () {
                var eventType = config.datalayerEventType || 'generalRequest';
                var eventLabel = config.datalayerEventLabel || 'generalRequest';
                var eventAction = config.datalayerEventAction || 'General Request';

                vm.formError = false;
                vm.isSent = true;
                jQuery('.modal--request').modal('hide');
                if (typeof window.dataLayer === 'object') {
                    window.dataLayer.push({
                        'event': eventType,
                        'eventAction': eventAction,
                        'eventLabel': eventLabel,
                        'eventValue': config.BOAT ? config.BOAT.price : ''
                    });
                }
            })
            .catch(handleError)
            .finally(unlockUi);
    }

    vm.processForm = function () {
        if (vm.form.$valid) {
            // if (vm.data.extra_fields.location) {
                // vm.formError = false;
                sendMessage();
            // } else {
                // vm.formError = config.MESSAGES.errors.general;
            // }
        }
    };

}
RequestCtrl.$inject = [
    '$location',
    '$window',
    '$timeout',
    '$scope',
    'ContactService',
    'config'
];

angular
    .module('RequestApp')
    .controller('RequestCtrl', RequestCtrl);
