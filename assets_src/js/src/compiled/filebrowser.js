var jQuery = window.jQuery || require('jquery');

var openFileBrowser = function (params) {
	var defaults = {
		model: "filebrowser/file", //unused at the moment
		callback: function () {},
		width: 750,
		height: 500,
		name: 'filebrowser',
		filters: 'all'
	};

	jQuery.extend(defaults, params);
	window.open(window.baseURL + "filebrowser/index/index?model=" + encodeURI(defaults.model) + "&filters=" + encodeURI(defaults.filters), defaults.name, 'width=' + defaults.width + ',height=' + defaults.height);
	window.filebrowser_callback = defaults.callback;
	window.filebrowser_model = defaults.model;
	window.filebrowser_filters = defaults.filters;
	return false;
};

(function ($)
{
	$.fn.filebrowser = function (params)
	{

		return this.each(function ()
		{
			$(this).click(function (e) {
				e.preventDefault();
//				console.log(window.baseURL+"/filebrowser/index/index?model="+defaults.model.replace('/','-')+"&filters="+defaults.filters.replace(' ','').replace(',','-').replace('/','_'));
				openFileBrowser(params);
			});
		});


	};

})(jQuery);

module.exports = openFileBrowser;


