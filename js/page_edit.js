/*   Copyright (c) 2011, John F. Brown  This file is
  licensed under the Affero General Public License version 3 or later.  See
   the COPYRIGHT file.
*/

$(function() {
   $('input[name=profile_photo]').click(function() {
	  $.nmManual(base_url + 'photo/select_profile_photo');
   });
   $('span#insert_photo').click(function() {
	  $.nmManual(base_url + 'photo/select_embedded_photo');
   });
});

function profile_photo(img) {
   $('input[name=profile_photo]').attr('value', img);
   var data = {'img':img};
   $.post(base_url + 'photo/ajax_image', data, function(str) {
	  $('#profile_photo_preview').attr('src', str);
   })
   //nm.close();
}

function embed_photo(img) {
   $('textarea[name=content]').insertAtCaret('<img class="float" src="' + img + '" />');
   /*var data = {'img':img};
   $.post(base_url + 'photo/ajax_image', data, function(str) {
	  $('#profile_photo_preview').attr('src', str);
   })*/
   //nm.close();
}

/**
 * Insert content at caret position (converted to jquery function)
 * @link 
http://alexking.org/blog/2003/06/02/inserting-at-the-cursor-using-javascript
 */
$.fn.insertAtCaret = function (myValue) {
   return this.each(function(){
	  //IE support
	  if (document.selection) {
		 this.focus();
		 sel = document.selection.createRange();
		 sel.text = myValue;
		 this.focus();
	  }
	  //MOZILLA/NETSCAPE support
	  else if (this.selectionStart || this.selectionStart == '0') {
		 var startPos = this.selectionStart;
		 var endPos = this.selectionEnd;
		 var scrollTop = this.scrollTop;
		 this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
		 this.focus();
		 this.selectionStart = startPos + myValue.length;
		 this.selectionEnd = startPos + myValue.length;
		 this.scrollTop = scrollTop;
	  } else {
		 this.value += myValue;
		 this.focus();
	  }
   });
};