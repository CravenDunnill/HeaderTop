<?php
/**
 * @package     CravenDunnill_HeaderTop
 * @author      Custom Extension
 * @copyright   Copyright (c) 2025
 */
namespace CravenDunnill\HeaderTop\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Serialize\Serializer\Json;
use CravenDunnill\HeaderTop\Model\Config\Source\TimeOptions;

class Data extends AbstractHelper
{
	const CONFIG_PATH = 'cravendunnill_headertop/';
	
	/**
	 * London timezone
	 */
	const LONDON_TIMEZONE = 'Europe/London';
	
	/**
	 * Day codes
	 */
	const DAYS = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
	
	/**
	 * Day names
	 */
	const DAY_NAMES = [
		'mon' => 'Monday',
		'tue' => 'Tuesday',
		'wed' => 'Wednesday',
		'thu' => 'Thursday',
		'fri' => 'Friday',
		'sat' => 'Saturday',
		'sun' => 'Sunday'
	];
	
	/**
	 * @var Json
	 */
	protected $serializer;
	
	/**
	 * @var TimeOptions
	 */
	protected $timeOptions;
	
	/**
	 * @param Context $context
	 * @param Json $serializer
	 * @param TimeOptions $timeOptions
	 */
	public function __construct(
		Context $context,
		Json $serializer,
		TimeOptions $timeOptions
	) {
		$this->serializer = $serializer;
		$this->timeOptions = $timeOptions;
		parent::__construct($context);
	}
	
	/**
	 * Check if extension is enabled
	 *
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return bool
	 */
	public function isEnabled($scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		return $this->scopeConfig->isSetFlag(
			self::CONFIG_PATH . 'general/enabled',
			$scopeType,
			$scopeCode
		);
	}
	
	/**
	 * Get config value
	 *
	 * @param string $path
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return mixed
	 */
	public function getConfig($path, $scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		return $this->scopeConfig->getValue(
			self::CONFIG_PATH . $path,
			$scopeType,
			$scopeCode
		);
	}
	
	/**
	 * Get background color
	 *
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string
	 */
	public function getBackgroundColor($scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		return $this->getConfig('styles/background_color', $scopeType, $scopeCode);
	}
	
	/**
	 * Get text color
	 *
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string
	 */
	public function getTextColor($scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		return $this->getConfig('styles/text_color', $scopeType, $scopeCode);
	}
	
	/**
	 * Get link color
	 *
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string
	 */
	public function getLinkColor($scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		return $this->getConfig('styles/link_color', $scopeType, $scopeCode);
	}
	
	/**
	 * Get link hover color
	 *
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string
	 */
	public function getLinkHoverColor($scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		return $this->getConfig('styles/link_hover_color', $scopeType, $scopeCode);
	}
	
	/**
	 * Get phone number
	 *
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string
	 */
	public function getPhoneNumber($scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		return $this->getConfig('contact/phone_number', $scopeType, $scopeCode);
	}
	
	/**
	 * Get the open message format
	 *
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string
	 */
	public function getOpenMessageFormat($scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		$format = $this->getConfig('contact/open_message', $scopeType, $scopeCode);
		return !empty($format) ? $format : '<strong>Open until %close_time%</strong>:  %phone%';
	}
	
	/**
	 * Get the closed message format
	 *
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string
	 */
	public function getClosedMessageFormat($scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		$format = $this->getConfig('contact/closed_message', $scopeType, $scopeCode);
		return !empty($format) ? $format : '<strong>Open %next_day% from %open_time%</strong>:  %phone%';
	}
	
	/**
	 * Check if a specific day is enabled
	 *
	 * @param string $day Three letter day code (mon, tue, wed, etc.)
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return bool
	 */
	public function isDayEnabled($day, $scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		return $this->scopeConfig->isSetFlag(
			self::CONFIG_PATH . 'contact/' . $day . '_enabled',
			$scopeType,
			$scopeCode
		);
	}
	
	/**
	 * Get open time for a specific day
	 *
	 * @param string $day Three letter day code (mon, tue, wed, etc.)
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string Time in format HH:MM
	 */
	public function getDayOpenTime($day, $scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		return $this->getConfig('contact/' . $day . '_open_time', $scopeType, $scopeCode);
	}
	
	/**
	 * Get close time for a specific day
	 *
	 * @param string $day Three letter day code (mon, tue, wed, etc.)
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string Time in format HH:MM
	 */
	public function getDayCloseTime($day, $scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		return $this->getConfig('contact/' . $day . '_close_time', $scopeType, $scopeCode);
	}
	
	/**
	 * Get formatted open time for a specific day
	 *
	 * @param string $day Three letter day code (mon, tue, wed, etc.)
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string Formatted time (e.g., 8am)
	 */
	public function getFormattedDayOpenTime($day, $scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		$time = $this->getDayOpenTime($day, $scopeType, $scopeCode);
		return TimeOptions::getFormattedTime($time);
	}
	
	/**
	 * Get formatted close time for a specific day
	 *
	 * @param string $day Three letter day code (mon, tue, wed, etc.)
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return string Formatted time (e.g., 5pm)
	 */
	public function getFormattedDayCloseTime($day, $scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		$time = $this->getDayCloseTime($day, $scopeType, $scopeCode);
		return TimeOptions::getFormattedTime($time);
	}
	
	/**
	 * Get current day code using London time
	 *
	 * @return string Three letter day code (mon, tue, wed, etc.)
	 */
	public function getCurrentDayCode()
	{
		$datetime = new \DateTime('now', new \DateTimeZone(self::LONDON_TIMEZONE));
		return strtolower($datetime->format('D'));
	}
	
	/**
	 * Convert PHP date 3-letter day code to our internal day code
	 *
	 * @param string $phpDayCode PHP date format day code (mon, tue, wed, etc.)
	 * @return string Internal day code (mon, tue, wed, etc.)
	 */
	protected function convertPhpDayCodeToInternal($phpDayCode)
	{
		$map = [
			'mon' => 'mon',
			'tue' => 'tue',
			'wed' => 'wed',
			'thu' => 'thu',
			'fri' => 'fri',
			'sat' => 'sat',
			'sun' => 'sun'
		];
		
		return isset($map[strtolower($phpDayCode)]) ? $map[strtolower($phpDayCode)] : '';
	}
	
	/**
	 * Check if the phone line is currently open using London time
	 *
	 * @return bool
	 */
	public function isPhoneLineOpen()
	{
		$currentDayCode = $this->convertPhpDayCodeToInternal($this->getCurrentDayCode());
		
		// If current day is not enabled, return false
		if (!$this->isDayEnabled($currentDayCode)) {
			return false;
		}
		
		// Get current time in London timezone
		$datetime = new \DateTime('now', new \DateTimeZone(self::LONDON_TIMEZONE));
		$currentHour = (int)$datetime->format('G');
		$currentMinute = (int)$datetime->format('i');
		$currentTimeInMinutes = $currentHour * 60 + $currentMinute;
		
		// Get open and close times for current day
		$openTime = $this->getDayOpenTime($currentDayCode);
		$closeTime = $this->getDayCloseTime($currentDayCode);
		
		if (empty($openTime) || empty($closeTime)) {
			return false;
		}
		
		// Convert open time to minutes
		list($openHour, $openMinute) = explode(':', $openTime);
		$openTimeInMinutes = (int)$openHour * 60 + (int)$openMinute;
		
		// Convert close time to minutes
		list($closeHour, $closeMinute) = explode(':', $closeTime);
		$closeTimeInMinutes = (int)$closeHour * 60 + (int)$closeMinute;
		
		// Check if current time is within open hours
		return $currentTimeInMinutes >= $openTimeInMinutes && $currentTimeInMinutes < $closeTimeInMinutes;
	}
	
	/**
	 * Get the next open day information using London time
	 *
	 * @return array|null [day_code, day_name, open_time, close_time, formatted_open_time, formatted_close_time]
	 */
	public function getNextOpenDay()
	{
		$currentDayCode = $this->convertPhpDayCodeToInternal($this->getCurrentDayCode());
		$currentDayIndex = array_search($currentDayCode, self::DAYS);
		
		if ($currentDayIndex === false) {
			return null;
		}
		
		$daysChecked = 0;
		$dayIndex = $currentDayIndex;
		
		// Get current London time
		$datetime = new \DateTime('now', new \DateTimeZone(self::LONDON_TIMEZONE));
		$currentHour = (int)$datetime->format('G');
		$currentMinute = (int)$datetime->format('i');
		$currentTimeInMinutes = $currentHour * 60 + $currentMinute;
		
		// First, check if the current day is enabled but we're before opening time
		if ($this->isDayEnabled($currentDayCode)) {
			$openTime = $this->getDayOpenTime($currentDayCode);
			if (!empty($openTime)) {
				list($openHour, $openMinute) = explode(':', $openTime);
				$openTimeInMinutes = (int)$openHour * 60 + (int)$openMinute;
				
				if ($currentTimeInMinutes < $openTimeInMinutes) {
					// Current day, but before opening time
					return [
						'day_code' => $currentDayCode,
						'day_name' => 'Today',
						'open_time' => $openTime,
						'close_time' => $this->getDayCloseTime($currentDayCode),
						'formatted_open_time' => $this->getFormattedDayOpenTime($currentDayCode),
						'formatted_close_time' => $this->getFormattedDayCloseTime($currentDayCode)
					];
				}
			}
		}
		
		// Look for the next enabled day
		do {
			$dayIndex = ($dayIndex + 1) % 7; // Move to next day, wrapping around to Sunday
			$daysChecked++;
			
			$dayCode = self::DAYS[$dayIndex];
			if ($this->isDayEnabled($dayCode)) {
				$dayName = ($daysChecked === 1) ? 'Tomorrow' : self::DAY_NAMES[$dayCode];
				
				return [
					'day_code' => $dayCode,
					'day_name' => $dayName,
					'open_time' => $this->getDayOpenTime($dayCode),
					'close_time' => $this->getDayCloseTime($dayCode),
					'formatted_open_time' => $this->getFormattedDayOpenTime($dayCode),
					'formatted_close_time' => $this->getFormattedDayCloseTime($dayCode)
				];
			}
		} while ($daysChecked < 7); // Check all days of the week
		
		return null; // No open days found
	}
	
	/**
	 * Get the contact information message based on current time in London timezone
	 *
	 * @return string
	 */
	public function getContactInfoMessage()
	{
		$phoneNumber = $this->getPhoneNumber();
		$phoneLink = '<a href="tel:' . $phoneNumber . '">' . $phoneNumber . '</a>';
		
		if ($this->isPhoneLineOpen()) {
			// Phone line is currently open
			$currentDayCode = $this->convertPhpDayCodeToInternal($this->getCurrentDayCode());
			$closeTime = $this->getFormattedDayCloseTime($currentDayCode);
			
			$message = $this->getOpenMessageFormat();
			$message = str_replace('%close_time%', $closeTime, $message);
			$message = str_replace('%phone%', $phoneLink, $message);
			
			return $message;
		} else {
			// Phone line is currently closed
			$nextOpenDay = $this->getNextOpenDay();
			
			if ($nextOpenDay) {
				$message = $this->getClosedMessageFormat();
				$message = str_replace('%next_day%', $nextOpenDay['day_name'], $message);
				$message = str_replace('%open_time%', $nextOpenDay['formatted_open_time'], $message);
				$message = str_replace('%phone%', $phoneLink, $message);
				
				return $message;
			} else {
				// Fallback if no open days are configured
				return '<strong>Currently closed</strong>:  ' . $phoneLink;
			}
		}
	}
	
	/**
	 * Get custom links
	 *
	 * @param string $scopeType
	 * @param null|string $scopeCode
	 * @return array
	 */
	public function getCustomLinks($scopeType = ScopeInterface::SCOPE_STORE, $scopeCode = null)
	{
		$links = $this->getConfig('links/links_config', $scopeType, $scopeCode);
		
		if ($links) {
			try {
				$links = $this->serializer->unserialize($links);
			} catch (\Exception $e) {
				$links = [];
			}
			
			// Sort links by sort_order
			if (is_array($links)) {
				usort($links, function ($a, $b) {
					return (int)$a['sort_order'] <=> (int)$b['sort_order'];
				});
			}
		} else {
			$links = [];
		}
		
		return $links;
	}
}