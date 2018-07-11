var jQuery = window.jQuery || require('jquery');

(function($)
{
    $.fn.removeClassRegEx = function(condition)
    {
        return this.each(function(){
			var classes = $(this).attr('class');

			if(!classes || !condition) return false;

			var classArray = [];
			classes = classes.split(' ');

			for(var i=0, len=classes.length; i<len; i++) {
				var clazz = classes[i];
				if(typeof condition === 'function') {
					if( ! condition(clazz)) classArray.push(clazz);
				} else {
					if(!clazz.match(condition)) classArray.push(clazz);
				}
			}

			$(this).attr('class', classArray.join(' '));
		});
    };
})(jQuery);