// Author of parallax.js Kevin Powell
$(document).ready(function() {
  if($(window).width() >= "955") {
    $(window).scroll(function() {
      parallax();
    })
  }
  function parallax() {
    var wScroll = $(window).scrollTop()
    $('.parallax--bg').css('background-position', 'center ' + (wScroll*0.75)+'px');
    $('.parallax--box').css('top', -5 + (wScroll*.005)+'em')
  }
});
