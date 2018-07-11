var $ = require('jquery');

$('.admin-message').each(function () {
	var $adminMessage = $(this);
	$adminMessage.find('.bt-close').click(function () {
		var $p = $(this).parent().removeClass('displayed');
		window.setTimeout(function () {
			$p.remove();
		}, 1000);
	});
	$('body').append($adminMessage);

	window.setTimeout(function () {

		$adminMessage.addClass('displayed');

	}, 1);

});


