//Function from https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_menu_icon_js
function hamburger(x) {
  x.classList.toggle("change");
}

$(document).ready(function() {
  $('.menu-toggle').click(function() {
    $('.site-nav').toggleClass('site-nav--open', 500);
  })
  // Script from: https://jsfiddle.net/srd76/36/
  // Images:
  // hero.jpg image from https://www.pexels.com/photo/midsection-of-woman-making-heart-shape-with-hands-256737/ */
  // hero2.jpg Author: Min An from https://www.pexels.com/photo/woman-in-white-wedding-dress-holding-hand-to-man-in-black-suit-752842/
  // hero3.jpg Author: Scott Webb from https://www.pexels.com/photo/man-couple-love-people-137576/
  var images = Array(
    "images/hero.jpg",
    "images/hero2.jpg",
    "images/hero3.jpg",
    "images/hero-s.jpg",
    "images/hero2-s.jpg",
    "images/hero3-s.jpg");
    var currimg = 0;


    function loadimg(){
      $('.hero').animate({ opacity: 1 }, 500, function(){
        $('.hero').animate({ opacity: 0.9 }, 100, function(){
          currimg++;
          if(currimg > images.length-4){
            currimg=0;
          }
          var newimage = images[currimg];
          var newimages = images[currimg+3];
          $('.hero').css("background-image", "linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5)), url("+newimage+")");
          $('.hero-s').css("background-image", "linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5)), url("+newimages+")");
          $('.hero').animate({ opacity: 1 }, 400,function(){
            setTimeout(loadimg,5000);
          });
        });
      });
    }
    setTimeout(loadimg,5000);
  });
