var $ = window.jQuery || require('jquery');

global.jQuery = $;

require('bootstrap');

$("[rel=tooltip]").tooltip();
$(function () {
	$('.demo-cancel-click').click(function () {
		return false;
	});
});