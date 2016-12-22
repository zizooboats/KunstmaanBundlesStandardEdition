$( document ).ready(function()
{
	$( ".cf" ).submit(function( event ) {
		event.preventDefault();
		sendMail($(event.target));
	});
});


function sendMail(form)
{
	var postData = form.serialize();
	var formURL = form.attr("action");
	$.ajax({
		url: formURL,
		type: "POST",
		data: postData,
		success: function (data, textStatus, jqXHR) {
			form.find('input').each(function() {
				$(this).val('');
			});
			form.find('textarea').each(function() {
				$(this).val('');
			});
			alert(data.data);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.error(textStatus);
		}
	});
}
