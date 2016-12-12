(function ($) {
    $(document).ready(function () {
        $('form :input').blur(function () {
            if ($(this).val().length > 0 && !($(this).hasClass('completed'))) {
                // The if statement above checks to see if there is a value in the form field and if that field does NOT have the class "completed".
                // If those conditions are met, we push information to the dataLayer that tells GTM the form field was completed, along with the
                // event category (form name), event action (field name), and event label (completed).
                dataLayer.push({'eventCategory': 'Form - ' + $(this).closest('form').attr('name'),
                    'eventAction': 'completed',
                    'eventLabel': $(this).attr('name'),
                    'event': 'gaEvent'});
                // Once we fire an event for this form field that is completed, we need to add the class "completed" to this form field to prevent it from firing again
                // if the user mouses in and out of this field more than once.
                $(this).addClass('completed');
            }
            else if (!($(this).hasClass('completed')) && !($(this).hasClass('skipped'))) {
                // If the first if statement didn't match, it means that either the form field was empty or it had the class of "completed." Here, the else if statement checks
                // to see if it doesn't have the class "completed" AND doesn't have the class "skipped." In other words, if the form field is empty and we haven't already fired
                // an event to GA to indicate that the field was skipped. If this is the case, we will push information to the dataLayer that tells GTM the form field was
                // skipped, along with the event category (form name), event action (field name), and event label (skipped).
                dataLayer.push({'eventCategory': 'Form - ' + $(this).closest('form').attr('name'),
                    'eventAction': 'skipped',
                    'eventLabel': $(this).attr('name'),
                    'event': 'gaEvent'});
                // Once we fire an event for this form field that is skipped, we need to add the class "skipped" to this form field to prevent it from firing again
                // if the user mouses in and out of this field more than once.
                $(this).addClass('skipped');
            }
        });
    });
})(jQuery);