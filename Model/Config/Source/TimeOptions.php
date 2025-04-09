<?php
/**
 * @package     CravenDunnill_HeaderTop
 * @author      Custom Extension
 * @copyright   Copyright (c) 2025
 */
namespace CravenDunnill\HeaderTop\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class TimeOptions implements ArrayInterface
{
	/**
	 * Options getter
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		$options = [];
		
		// Add options from 6am to 10pm in 30 minute increments
		for ($hour = 6; $hour <= 22; $hour++) {
			$hourStr = ($hour <= 12) ? $hour : ($hour - 12);
			$amPm = ($hour < 12) ? 'am' : 'pm';
			
			// Full hour
			$value = sprintf('%02d:00', $hour);
			$label = $hourStr . ':00' . $amPm;
			$options[] = ['value' => $value, 'label' => $label];
			
			// Half hour
			$value = sprintf('%02d:30', $hour);
			$label = $hourStr . ':30' . $amPm;
			$options[] = ['value' => $value, 'label' => $label];
		}
		
		return $options;
	}

	/**
	 * Get options in "key-value" format
	 *
	 * @return array
	 */
	public function toArray()
	{
		$array = [];
		foreach ($this->toOptionArray() as $option) {
			$array[$option['value']] = $option['label'];
		}
		return $array;
	}
	
	/**
	 * Get formatted time string
	 *
	 * @param string $time Format: HH:MM
	 * @return string Formatted time (e.g., 8am, 2:30pm)
	 */
	public static function getFormattedTime($time)
	{
		if (empty($time)) {
			return '';
		}
		
		list($hour, $minute) = explode(':', $time);
		$hour = (int)$hour;
		$minute = (int)$minute;
		
		$amPm = ($hour < 12) ? 'am' : 'pm';
		$hourFormatted = ($hour <= 12) ? $hour : ($hour - 12);
		
		if ($minute === 0) {
			return $hourFormatted . $amPm;
		} else {
			return $hourFormatted . ':' . sprintf('%02d', $minute) . $amPm;
		}
	}
}