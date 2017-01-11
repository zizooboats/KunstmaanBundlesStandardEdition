(function (document, window, $) {

	function addMapRouteLocation(event) {
		event.preventDefault();
		var eventTarget = event.target;

		var buttonId;
		if($(eventTarget).prop('tagName') == "I") {
			buttonId = $(eventTarget).parent().attr('id');
		}
		else {
			buttonId = $(eventTarget).attr('id');
		}

		var pagePartId =  buttonId.replace("_add_new_map_route_location", "");

		var mapRouteLocationForm = window["mapRouteLocationFormTemplate_" + pagePartId].replace(/_mapRouteLocationCounter_/g, window["dayNumber_" + pagePartId] - 1);
		mapRouteLocationForm = mapRouteLocationForm.replace(/0dn/g, window["dayNumber_" + pagePartId]);

		var divFormsContainer = $("#" + pagePartId + "_map_route_location_forms_container")
		$(divFormsContainer).append(mapRouteLocationForm);
		var newDivContainer = $(divFormsContainer).find("." + pagePartId + "_map_route_location_form_container").last();
		var dayNumberInput = $(newDivContainer).find(".map-region-location-day-number-hidden-input");
		$(dayNumberInput).val(window["dayNumber_" + pagePartId]);
		window["dayNumber_" + pagePartId] += 1;
	}


	function deleteMapRouteLocation(event) {
		event.preventDefault();
		var eventTarget = event.target;

		var divContainer;

		if($(eventTarget).prop('tagName') == "I") {
			divContainer = $(eventTarget).parent().parent().parent();
		}
		else {
			divContainer = $(eventTarget).parent().parent();
		}

		var divContainerId = $(divContainer).attr('id');
		var pagePartId = divContainerId.replace("_map_route_location_forms_container", "");

		var divContainerParent = $(eventTarget).closest("div." + pagePartId + "_map_route_location_form_container");
		$(divContainerParent).nextAll().each(function (i, elem) {
			var dayNumberInput = $(elem).find(".map-region-location-day-number-hidden-input");
			var oldDayNumber = $(dayNumberInput).val();
			var dayNumberLabel = $("#" + pagePartId + "_day_number_" + oldDayNumber);

			var newDayNumber = oldDayNumber - 1;
			$(dayNumberInput).val(parseInt(newDayNumber));
			$(dayNumberLabel).html(newDayNumber + ".");
			$(dayNumberLabel).attr('id', "" + pagePartId + "_day_number_" + newDayNumber)
		});
		$(divContainerParent).html("");
		window["dayNumber_" + pagePartId] -= 1;
	}

	$(document).ready(function () {
		$("body").on('click', "button.add_new_map_route_location", function (event) {
			addMapRouteLocation(event);
		})

		$("body").on('click', "button.delete_map_route_location", function (event) {
			deleteMapRouteLocation(event);
		})
	});

}(document, window, jQuery));