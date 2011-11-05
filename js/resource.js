/*   Copyright (c) 2011, John F. Brown  This file is
  licensed under the Affero General Public License version 3 or later.  See
   the COPYRIGHT file.
*/

$(document).ready(function() {
   $('.module_resources li ul').hide();
   $('.module_resources li').css('color', '#red').click(function() {
	  $('.module_resources li ul').slideUp();
	  $(this).find('ul').slideDown();
   });
   $('div.resources, div.network').hide();

   $('h2.lesson_plan').click(function() {
	  $('div.resources, div.network').slideUp();
	  $('div.lesson_plan').slideDown();
	  $('body').scrollTop(88);
   });
   $('h2.resources').click(function() {
	  $('div.lesson_plan, div.network').slideUp();
	  $('div.resources').slideDown();
	  $('body').scrollTop(88);
   });
   $('h2.network').click(function() {
	  $('div.resources, div.lesson_plan').slideUp();
	  $('div.network').slideDown();
	  $('body').scrollTop(88);
   });
   //alert($current);
});