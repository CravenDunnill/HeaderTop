define([
	'jquery',
	'domReady!'
], function ($) {
	'use strict';
	
	return function (config) {
		// Handle custom link hover
		$(document).on('mouseenter', '.header-top__links a', function() {
			var customHoverColor = $(this).data('hover-color');
			if (customHoverColor) {
				$(this).css('color', customHoverColor);
			}
		});
		
		$(document).on('mouseleave', '.header-top__links a', function() {
			var customColor = $(this).data('color');
			if (customColor) {
				$(this).css('color', customColor);
			} else {
				$(this).css('color', '');
			}
		});
		
		// Update opening hours message if needed based on current time
		function updateOpeningHoursMessage() {
			if (config.isWithinOpeningHours === false) {
				$.ajax({
					url: config.ajaxUrl,
					type: 'GET',
					dataType: 'json',
					success: function(response) {
						if (response.message) {
							$('.header-top__contact .opening-message').text(response.message);
						}
					}
				});
			}
		}
		
		// Initial update and setup interval for periodic updates if needed
		if (config.enableAutoUpdate) {
			updateOpeningHoursMessage();
			setInterval(updateOpeningHoursMessage, 60000); // Update every minute
		}
	};
});