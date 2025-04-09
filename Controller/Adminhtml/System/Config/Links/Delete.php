<?php
/**
 * @package     CravenDunnill_HeaderTop
 * @author      Custom Extension
 * @copyright   Copyright (c) 2025
 */
namespace CravenDunnill\HeaderTop\Controller\Adminhtml\System\Config\Links;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Delete extends Action
{
	/**
	 * @var JsonFactory
	 */
	protected $resultJsonFactory;
	
	/**
	 * @param Context $context
	 * @param JsonFactory $resultJsonFactory
	 */
	public function __construct(
		Context $context,
		JsonFactory $resultJsonFactory
	) {
		parent::__construct($context);
		$this->resultJsonFactory = $resultJsonFactory;
	}
	
	/**
	 * Check if user has enough privileges
	 *
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('CravenDunnill_HeaderTop::config');
	}
	
	/**
	 * Execute action
	 *
	 * @return \Magento\Framework\Controller\Result\Json
	 */
	public function execute()
	{
		$id = $this->getRequest()->getParam('id');
		$resultJson = $this->resultJsonFactory->create();
		
		if (!$id) {
			return $resultJson->setData([
				'success' => false,
				'message' => __('Invalid link ID.')
			]);
		}
		
		return $resultJson->setData([
			'success' => true
		]);
	}
}