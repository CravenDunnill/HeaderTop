<?php
/**
 * @package     CravenDunnill_HeaderTop
 * @author      Custom Extension
 * @copyright   Copyright (c) 2025
 */
namespace CravenDunnill\HeaderTop\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use CravenDunnill\HeaderTop\Helper\Data;

class HeaderTop extends Template
{
	/**
	 * @var Data
	 */
	protected $helper;
	
	/**
	 * @param Context $context
	 * @param Data $helper
	 * @param array $data
	 */
	public function __construct(
		Context $context,
		Data $helper,
		array $data = []
	) {
		$this->helper = $helper;
		parent::__construct($context, $data);
	}
	
	/**
	 * Get helper
	 *
	 * @return Data
	 */
	public function getHelper()
	{
		return $this->helper;
	}
	
	/**
	 * Check if header top is enabled
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		return $this->helper->isEnabled();
	}
	
	/**
	 * Get background color
	 *
	 * @return string
	 */
	public function getBackgroundColor()
	{
		return $this->helper->getBackgroundColor();
	}
	
	/**
	 * Get text color
	 *
	 * @return string
	 */
	public function getTextColor()
	{
		return $this->helper->getTextColor();
	}
	
	/**
	 * Get link color
	 *
	 * @return string
	 */
	public function getLinkColor()
	{
		return $this->helper->getLinkColor();
	}
	
	/**
	 * Get link hover color
	 *
	 * @return string
	 */
	public function getLinkHoverColor()
	{
		return $this->helper->getLinkHoverColor();
	}
	
	/**
	 * Get phone number
	 *
	 * @return string
	 */
	public function getPhoneNumber()
	{
		return $this->helper->getPhoneNumber();
	}
	
	/**
	 * Get contact information message
	 *
	 * @return string
	 */
	public function getContactInfo()
	{
		return $this->helper->getContactInfoMessage();
	}
	
	/**
	 * Get custom links
	 *
	 * @return array
	 */
	public function getCustomLinks()
	{
		return $this->helper->getCustomLinks();
	}
	
	/**
	 * Get custom CSS styles
	 *
	 * @return string
	 */
	public function getCustomStyles()
	{
		$styles = '';
		$bgColor = $this->getBackgroundColor();
		$textColor = $this->getTextColor();
		$linkColor = $this->getLinkColor();
		$linkHoverColor = $this->getLinkHoverColor();
		
		if ($bgColor) {
			$styles .= "background-color: $bgColor;";
		}
		
		if ($textColor) {
			$styles .= "color: $textColor;";
		}
		
		return $styles;
	}
	
	/**
	 * Get custom link styles
	 *
	 * @return string
	 */
	public function getLinkStyles()
	{
		$styles = '';
		$linkColor = $this->getLinkColor();
		
		if ($linkColor) {
			$styles .= "color: $linkColor;";
		}
		
		return $styles;
	}
	
	/**
	 * Get custom link hover styles
	 *
	 * @return string
	 */
	public function getLinkHoverStyles()
	{
		$styles = '';
		$linkHoverColor = $this->getLinkHoverColor();
		
		if ($linkHoverColor) {
			$styles .= "color: $linkHoverColor;";
		}
		
		return $styles;
	}
}