/*   Copyright (c) 2011, John F. Brown  This file is
  licensed under the Affero General Public License version 3 or later.  See
   the COPYRIGHT file.
*/

$(function(){
   $('#slider1').anythingSlider({
	  resizeContents: true,
	  buildArrows: false,
	  buildNavigation: false,
	  delay: 9000,
	  animation: 600,
	  easing: "swing",
	  buildStartStop: false
   });
   
   $('#slider1').data('AnythingSlider').startStop(true);
});