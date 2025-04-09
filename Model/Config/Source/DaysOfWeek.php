<?php
/**
 * @package     CravenDunnill_HeaderTop
 * @author      Custom Extension
 * @copyright   Copyright (c) 2025
 */
namespace CravenDunnill\HeaderTop\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class DaysOfWeek implements ArrayInterface
{
	/**
	 * Options getter
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		return [
			['value' => 'Mon', 'label' => __('Monday')],
			['value' => 'Tue', 'label' => __('Tuesday')],
			['value' => 'Wed', 'label' => __('Wednesday')],
			['value' => 'Thu', 'label' => __('Thursday')],
			['value' => 'Fri', 'label' => __('Friday')],
			['value' => 'Sat', 'label' => __('Saturday')],
			['value' => 'Sun', 'label' => __('Sunday')]
		];
	}

	/**
	 * Get options in "key-value" format
	 *
	 * @return array
	 */
	public function toArray()
	{
		return [
			'Mon' => __('Monday'),
			'Tue' => __('Tuesday'),
			'Wed' => __('Wednesday'),
			'Thu' => __('Thursday'),
			'Fri' => __('Friday'),
			'Sat' => __('Saturday'),
			'Sun' => __('Sunday')
		];
	}
}