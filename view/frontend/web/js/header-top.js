define([
	'jquery',
	'mage/translate',
	'domReady!'
], function ($, $t) {
	'use strict';
	
	return function (config) {
		var updateOpeningMessage = function() {
			// Get current London time
			var now = new Date();
			var londonTime = new Date(now.toLocaleString('en-US', {timeZone: 'Europe/London'}));
			var currentHour = londonTime.getHours();
			var currentMinute = londonTime.getMinutes();
			var currentDayIndex = londonTime.getDay(); // 0 = Sunday, 1 = Monday, etc.
			
			// Convert to our day format
			var dayMap = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
			var currentDay = dayMap[currentDayIndex];
			
			// Get today's settings if available
			var todayEnabled = config.days && config.days[currentDay] ? config.days[currentDay].enabled : false;
			var openTimeToday = todayEnabled ? config.days[currentDay].openTime : null;
			var closeTimeToday = todayEnabled ? config.days[currentDay].closeTime : null;
			
			// Phone formatting
			var phoneNumber = config.phoneNumber;
			var phoneLink = '<a href="tel:' + phoneNumber + '">' + phoneNumber + '</a>';
			
			// Build message
			var message = '';
			
			if (todayEnabled && openTimeToday && closeTimeToday) {
				// Parse open and close times (format: "HH:MM")
				var openParts = openTimeToday.split(':');
				var closeParts = closeTimeToday.split(':');
				
				var openHour = parseInt(openParts[0], 10);
				var openMinute = parseInt(openParts[1], 10);
				var closeHour = parseInt(closeParts[0], 10);
				var closeMinute = parseInt(closeParts[1], 10);
				
				var currentTimeInMinutes = currentHour * 60 + currentMinute;
				var openTimeInMinutes = openHour * 60 + openMinute;
				var closeTimeInMinutes = closeHour * 60 + closeMinute;
				
				// Check if we're within business hours
				if (currentTimeInMinutes >= openTimeInMinutes && currentTimeInMinutes < closeTimeInMinutes) {
					// We're open
					var formattedCloseTime = formatTime(closeHour, closeMinute);
					message = '<strong>Open until ' + formattedCloseTime + '</strong>  ' + phoneLink;
				} else if (currentTimeInMinutes < openTimeInMinutes) {
					// Today but before opening
					var formattedOpenTime = formatTime(openHour, openMinute);
					message = '<strong>Open Today from ' + formattedOpenTime + '</strong>  ' + phoneLink;
				} else {
					// After closing time, find next open day
					var nextDay = findNextOpenDay(currentDayIndex, config.days, dayMap);
					if (nextDay) {
						message = '<strong>Open ' + nextDay.label + ' from ' + nextDay.formattedOpenTime + '</strong>  ' + phoneLink;
					} else {
						message = '<strong>Currently closed</strong>  ' + phoneLink;
					}
				}
			} else {
				// Today not enabled, find next open day
				var nextDay = findNextOpenDay(currentDayIndex, config.days, dayMap);
				if (nextDay) {
					message = '<strong>Open ' + nextDay.label + ' from ' + nextDay.formattedOpenTime + '</strong>  ' + phoneLink;
				} else {
					message = '<strong>Currently closed</strong>  ' + phoneLink;
				}
			}
			
			// Update DOM
			$('.header-top__contact').html(message);
		};
		
		// Format time to 12-hour format with am/pm
		var formatTime = function(hour, minute) {
			var amPm = hour < 12 ? 'am' : 'pm';
			var hour12 = hour <= 12 ? hour : hour - 12;
			
			if (minute === 0) {
				return hour12 + amPm;
			} else {
				return hour12 + ':' + (minute < 10 ? '0' + minute : minute) + amPm;
			}
		};
		
		// Find the next day we're open
		var findNextOpenDay = function(currentDayIndex, days, dayMap) {
			var dayNames = {
				'mon': 'Monday',
				'tue': 'Tuesday',
				'wed': 'Wednesday',
				'thu': 'Thursday',
				'fri': 'Friday',
				'sat': 'Saturday',
				'sun': 'Sunday'
			};
			
			// Check the next 7 days
			for (var i = 1; i <= 7; i++) {
				var nextDayIndex = (currentDayIndex + i) % 7;
				var nextDayCode = dayMap[nextDayIndex];
				
				if (days[nextDayCode] && days[nextDayCode].enabled) {
					var openTime = days[nextDayCode].openTime;
					if (openTime) {
						var openParts = openTime.split(':');
						var openHour = parseInt(openParts[0], 10);
						var openMinute = parseInt(openParts[1], 10);
						var formattedOpenTime = formatTime(openHour, openMinute);
						
						// Set appropriate label (Tomorrow or day name)
						var label = (i === 1) ? 'Tomorrow' : dayNames[nextDayCode];
						
						return {
							dayCode: nextDayCode,
							label: label,
							formattedOpenTime: formattedOpenTime
						};
					}
				}
			}
			
			return null;
		};
		
		// Initial update
		updateOpeningMessage();
		
		// Update every minute to ensure accurate time display
		setInterval(updateOpeningMessage, 60000);
	};
});