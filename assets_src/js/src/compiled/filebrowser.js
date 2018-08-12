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
  var childWindow = window.open(window.baseURL + "filebrowser/index/index?model=" + encodeURI(defaults.model) + "&filters=" + encodeURI(defaults.filters), defaults.name, 'width=' + defaults.width + ',height=' + defaults.height);
  var childConf = {};
  childConf.filebrowser_callback = defaults.callback;
  childConf.filebrowser_model = defaults.model;
  childConf.filebrowser_filters = defaults.filters;
  childWindow.conf = childConf;
  console.log(childWindow);
  var intervalConf = setInterval(function () {
    if ( ! childWindow.closed) {
      childWindow.conf = childConf;
    }
  }, 500);

  var intervalCheckClosed = setInterval(function () {
    if (childWindow.closed) {
      clearInterval(intervalCheckClosed);
      clearInterval(intervalConf);
    }
  }, 500);

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


