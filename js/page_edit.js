/*   Copyright (c) 2011, John F. Brown  This file is
  licensed under the Affero General Public License version 3 or later.  See
   the COPYRIGHT file.
*/

$(function() {
   $('input[name=profile_photo]').click(function() {
	  $.nmManual(base_url + 'photo/select_photo');
   });
});

function pick_photo(img) {
   $('input[name=profile_photo]').attr('value', img);
   var data = {'img':img};
   $.post(base_url + 'photo/ajax_image', data, function(str) {
	  $('#profile_photo_preview').attr('src', str);
   })
   //nm.close();
}