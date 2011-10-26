/*   Copyright (c) 2011, John F. Brown  This file is
  licensed under the Affero General Public License version 3 or later.  See
   the COPYRIGHT file.
*/
$(document).ready(function() {
   
   $('.notification').show().delay(10000).slideUp(1000);
   var $url = $.url();
   var current = 'a[href="' + $url.attr('source') + '"]';
   var name = 'a[name="' + $url.segment(1) + '"]';
   $('#leftbar ul a.invisible').parent('li').remove();
   $('#leftbar ul:empty').remove();
   $('#leftbar ul.leftmenu > li ul').hide();
   $("#leftbar " + current).parents('ul').show();
   $("#leftbar " + current).css('background-color', '#cae1ff').css('border', '1px solid #ccc').closest('ul.leftmenu > li').children('ul').show();
   $('#leftbar ul.leftmenu li').hoverIntent(
	  function() {
		 $(this).children('ul').first().addClass('currently_open').slideDown();
	  },
	  function() {
		 /*$(this).children('ul').first().slideUp().removeClass('currently_open');
		 $("#leftbar " + current).parents('ul').show();*/
	  }
   );
   $('.content').mouseenter(function() {
	  $('.currently_open').slideUp().removeClass('currently_open');
   })
   $("#main_menu " + name).css('color', '#fff');
   $(".feed_block .body .message " + current).css('color', 'red');
   $(".controls").hide();
   $(".feed_block, #page_view, #page_form, #photo_form, #gallery_view, #user_form").hover(
	  function() {
		 $(this).find(".controls").show();
	  },
	  function() {
		 $(this).find(".controls").hide();
	  }
   );
   $("#leftbar ul.leftmenu li").hover(
	  function() {
		 $('.controls').hide();
		 $(this).find(".controls:first").show();
	  },
	  function() {
		 $(this).find(".controls").hide();
	  }
   );
   $("a.edit img").hover(
	  function() {
		 $(this).attr('src', base_url + 'img/edit_icon.png');
	  },
	  function() {
		 $(this).attr('src', base_url + 'img/edit_icon_black.png');
	  }
   );
   $("a.create img").hover(
	  function() {
		 $(this).attr('src', base_url + 'img/create_icon.png');
	  },
	  function() {
		 $(this).attr('src', base_url + 'img/create_icon_black.png');
	  }
   );
   $("a.delete img").hover(
	  function() {
		 $(this).attr('src', base_url + 'img/delete_icon.png');
	  },
	  function() {
		 $(this).attr('src', base_url + 'img/delete_icon_black.png');
	  }
   );
   $("a.cancel img").hover(
	  function() {
		 $(this).attr('src', base_url + 'img/cancel_icon.png');
	  },
	  function() {
		 $(this).attr('src', base_url + 'img/cancel_icon_black.png');
	  }
   );
   $("a.upload img").hover(
	  function() {
		 $(this).attr('src', base_url + 'img/upload_icon.png');
	  },
	  function() {
		 $(this).attr('src', base_url + 'img/upload_icon_black.png');
	  }
   );
   $('#google_search input[type=text]').focus(
	  function() {
		 $(this).attr('value', '');
	  }
   ).blur(
	  function() {
		 $(this).attr('value', 'Search pcsenegal.org using a Google Search');
	  }
   );
});