var base_url = 'http://alpha.pcsenegal.org/';
var upload_dir = 'uploads/';

$(document).ready(function() {
   
   $('.notification').show().delay(10000).slideUp(1000);
   var $url = $.url();
   var $current = 'a[href="' + $url.attr('source') + '"]';
   var name = 'a[name="' + $url.segment(1) + '"]';
   $("#leftbar " + $current).css('background-color', '#cae1ff');
   $("#main_menu " + name).css('color', '#fff');
   $(".feed_block .body .message " + $current).css('color', 'red');
   $(".controls").hide();
   $(".left_menu ul li, .feed_block, #page_view, #page_form, #photo_form, #gallery_view, #user_form").hover(
	  function() {
		 $(this).find(".controls").show();
	  },
	  function() {
		 $(this).find(".controls").hide();
	  }
   );
   $("a.edit img").hover(
	  function() {
		 $(this).attr('src', 'http://localhost/dev1/img/edit_icon.png');
	  },
	  function() {
		 $(this).attr('src', 'http://localhost/dev1/img/edit_icon_black.png');
	  }
   );
   $("a.create img").hover(
	  function() {
		 $(this).attr('src', 'http://localhost/dev1/img/create_icon.png');
	  },
	  function() {
		 $(this).attr('src', 'http://localhost/dev1/img/create_icon_black.png');
	  }
   );
   $("a.delete img").hover(
	  function() {
		 $(this).attr('src', 'http://localhost/dev1/img/delete_icon.png');
	  },
	  function() {
		 $(this).attr('src', 'http://localhost/dev1/img/delete_icon_black.png');
	  }
   );
   $("a.cancel img").hover(
	  function() {
		 $(this).attr('src', 'http://localhost/dev1/img/cancel_icon.png');
	  },
	  function() {
		 $(this).attr('src', 'http://localhost/dev1/img/cancel_icon_black.png');
	  }
   );
   $("a.upload img").hover(
	  function() {
		 $(this).attr('src', 'http://localhost/dev1/img/upload_icon.png');
	  },
	  function() {
		 $(this).attr('src', 'http://localhost/dev1/img/upload_icon_black.png');
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
   
   $('.module_resources li ul').hide();
   $('.module_resources li').css('color', '#red').click(function() {
	  $('.module_resources li ul').slideUp();
	  $(this).find('ul').slideDown();
   });
   $('div.lesson_plan, div.resources, div.network').hide();
   
   $('h2.lesson_plan').click(function() {
	  $('div.resources, div.network').slideUp();
	  $('div.lesson_plan').slideDown();
   });
   $('h2.resources').click(function() {
	  $('div.lesson_plan, div.network').slideUp();
	  $('div.resources').slideDown();
   });
   $('h2.network').click(function() {
	  $('div.resources, div.lesson_plan').slideUp();
	  $('div.network').slideDown();
   });
   //alert($current);
});