(function($) {
	"use strict";
	$(document).ready(function(){
		// Add `listeners to all dropdowns and content blocks generated by the plugin
		$('body').on('change', '.dropdowncontent-dropdown', function() {
			var blockName = $(this).attr('name');
			// Add a custom event when the selection changes for both the previous selection and the new selection
			$('[data-dropdowncontent-name="' + blockName + '"].dropdowncontent-content.dropdowncontent-content-selected').trigger('dropdown-content:unselect');
			$('[data-dropdowncontent-name="' + blockName + '"][data-dropdowncontent-value="' + $(this).val() + '"].dropdowncontent-content').trigger('dropdown-content:select');
		}).on('dropdown-content:unselect', '.dropdowncontent-content', function() {
			// This is the default action of removing the `dropdowncontent-content-selected` class from the previously selected content block
			$(this).removeClass('dropdowncontent-content-selected');
		}).on('dropdown-content:select', '.dropdowncontent-content', function() {
			// This is the default action of adding the `dropdowncontent-content-selected` class to the currently selected content block
			$(this).addClass('dropdowncontent-content-selected');
		});

		// Fire the `dropdown-content:select` on page load if any of the content areas are already visible
		$('[data-dropdowncontent-name].dropdowncontent-content-selected').trigger('dropdown-content:select');
	});
})(jQuery);
