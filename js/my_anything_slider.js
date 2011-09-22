$(function(){
   $('#slider1').anythingSlider({
	  resizeContents: true,
	  buildArrows: false,
	  buildNavigation: false,
	  delay: 13000,
	  animation: 600,
	  easing: "swing",
	  buildStartStop: false
   });
   
   $('#slider1').data('AnythingSlider').startStop(true);
});