jQuery(document).ready(function() {
 
 var currentButton = null;
jQuery('.upload_button').click(function() {
 currentButton = jQuery(this).attr('id').substring(0,jQuery(this).attr('id').length - 7)
 formfield = jQuery('#'+currentButton).attr('name');
 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});
 
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 imgurl = imgurl ? imgurl : jQuery(html).attr('href');
 jQuery('#'+currentButton).val(imgurl);
 tb_remove();
}
if(jQuery('.finish_date').length) {
	jQuery('.finish_date').datepicker();	
}
});
