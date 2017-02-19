$( document ).ready(function()
{
	$( ".download-with-email-pp form" ).submit(function( event ) {
		event.preventDefault();
		downloadFile($(event.target));
	});
});


function downloadFile($form)
{
	clearErrorMsg($form);
	var postData = $form.serialize();
	var formURL = $form.attr("action");

	$.ajax({
		url: formURL,
		type: "POST",
		data: postData,
		success: function (data, textStatus, jqXHR) {
			$form.find('input').each(function() {
				$(this).val('');
			});

			//Creating new link node.
			var link = document.createElement('a');
			link.href = data.url;
			link.download = data.filename;

			//Dispatching click event.
			if (document.createEvent) {
				var e = document.createEvent('MouseEvents');
				e.initEvent('click' ,true ,true);
				link.dispatchEvent(e);

				var divContainer = ($form.closest(".download-with-email-pp")[0]);
				var divWrapper = $(divContainer).find('.wrapper')[0];
				var divSuccessMessage = $(divContainer).find('.dwef-success-msg')[0];

				$(divWrapper).hide();
				$(divSuccessMessage).show();
				return true;
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			var errorMsgs = $.parseJSON(jqXHR.responseText);
			if(errorMsgs.length > 0) {
				var errorMsg = "";
				$(errorMsgs).each(function (key, value) {
					errorMsg += value + ". ";
				});
				setErrorMsg($form, errorMsg);
			}
		}
	});
}

function getErrorLabel($form) {
	return $form.find('label[for="downloadwithemailpagepart_email"]')[0];
}

function clearErrorMsg($form) {
	var label = getErrorLabel($form);
	$(label).text("");
}

function setErrorMsg($form, errorMsg) {
	var label = getErrorLabel($form);
	$(label).css('color', 'red');
	$(label).text(errorMsg);
}