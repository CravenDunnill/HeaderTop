<?php
/**
 * @package     CravenDunnill_HeaderTop
 * @author      Custom Extension
 * @copyright   Copyright (c) 2025
 */
namespace CravenDunnill\HeaderTop\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class AddHeaderTopConfig implements DataPatchInterface
{
	/**
	 * @var ModuleDataSetupInterface
	 */
	private $moduleDataSetup;
	
	/**
	 * @var WriterInterface
	 */
	private $configWriter;
	
	/**
	 * @param ModuleDataSetupInterface $moduleDataSetup
	 * @param WriterInterface $configWriter
	 */
	public function __construct(
		ModuleDataSetupInterface $moduleDataSetup,
		WriterInterface $configWriter
	) {
		$this->moduleDataSetup = $moduleDataSetup;
		$this->configWriter = $configWriter;
	}
	
	/**
	 * @inheritdoc
	 */
	public function apply()
	{
		$this->moduleDataSetup->startSetup();
		
		// Set default values
		$this->configWriter->save(
			'cravendunnill_headertop/general/enabled',
			1,
			ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
			0
		);
		
		$this->configWriter->save(
			'cravendunnill_headertop/styles/background_color',
			'#333333',
			ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
			0
		);
		
		$this->configWriter->save(
			'cravendunnill_headertop/styles/text_color',
			'#FFFFFF',
			ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
			0
		);
		
		$this->configWriter->save(
			'cravendunnill_headertop/styles/link_color',
			'#FFFFFF',
			ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
			0
		);
		
		$this->configWriter->save(
			'cravendunnill_headertop/styles/link_hover_color',
			'#CCCCCC',
			ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
			0
		);
		
		$this->configWriter->save(
			'cravendunnill_headertop/contact/phone_number',
			'01746 761611',
			ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
			0
		);
		
		$this->configWriter->save(
			'cravendunnill_headertop/contact/opening_days',
			'Mon-Fri',
			ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
			0
		);
		
		$this->configWriter->save(
			'cravendunnill_headertop/contact/opening_hours',
			'8am-5pm',
			ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
			0
		);
		
		$this->moduleDataSetup->endSetup();
	}
	
	/**
	 * @inheritdoc
	 */
	public static function getDependencies()
	{
		return [];
	}
	
	/**
	 * @inheritdoc
	 */
	public function getAliases()
	{
		return [];
	}
}