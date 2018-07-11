var $ = window.jQuery || require('jquery');

$(window).scroll(function () {
  var scrollTop = $(this).scrollTop();

  $('.affix:not(.affix-clone)').each(function () {

    var $affix = $(this);
    var $clone = $affix.data('affix-clone');
    if ($clone) {
      if ($affix.data('original-top') > scrollTop) {
        $affix.html($clone.html());
        $clone.remove();
        $affix.data('affix-clone', null).css('opacity', 'initial');
      }
    } else {
      var affixOffset = $affix.offset();
      if (affixOffset.top <= scrollTop && !$affix.data('affix-clone')) {
        $affix.data('original-top', affixOffset.top);
        var outerWidth = $affix.outerWidth();
        var $clone = $affix.clone().addClass('affix-clone').css({
          right: $(window).width() - outerWidth - affixOffset.left,
          width: outerWidth,
          position: 'fixed',
          top: '0',
          margin: '0'
        }).insertBefore($affix);

        $affix.data('affix-clone', $clone).css('opacity', 0);
      }

    }
  });

});

$(window).resize(function(){
  $('.affix:not(.affix-clone)').each(function () {
    var $affix = $(this);
    var $clone = $affix.data('affix-clone');
    if ($clone) {
      $clone.css('width', $affix.outerWidth());
    }
  });
});