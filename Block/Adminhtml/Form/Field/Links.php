<?php
/**
 * @package     CravenDunnill_HeaderTop
 * @author      Custom Extension
 * @copyright   Copyright (c) 2025
 */
namespace CravenDunnill\HeaderTop\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class Links extends AbstractFieldArray
{
	/**
	 * @var array
	 */
	protected $_columns = [];
	
	/**
	 * Prepare to render
	 *
	 * @return void
	 */
	protected function _prepareToRender()
	{
		$this->addColumn('text', [
			'label' => __('Link Text'),
			'class' => 'required-entry'
		]);
		
		$this->addColumn('url', [
			'label' => __('URL'),
			'class' => 'required-entry'
		]);
		
		$this->addColumn('custom_color', [
			'label' => __('Custom Color (optional)'),
			'class' => 'validate-color'
		]);
		
		$this->addColumn('sort_order', [
			'label' => __('Sort Order'),
			'class' => 'required-entry validate-number'
		]);
		
		$this->_addAfter = false;
		$this->_addButtonLabel = __('Add Link');
	}
	
	/**
	 * Prepare array row
	 *
	 * @param DataObject $row
	 * @return void
	 */
	protected function _prepareArrayRow(DataObject $row)
	{
		$options = [];
		$row->setData('option_extra_attrs', $options);
	}
}