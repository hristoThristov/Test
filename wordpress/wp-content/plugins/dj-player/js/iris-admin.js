jQuery(function($) {
	// Colorpicker
	if(djpr_custom_color === null){
		$('#djpr_colorpicker').attr('value', '#7220fd');
	}
    $('#djpr_colorpicker').wpColorPicker();
});
