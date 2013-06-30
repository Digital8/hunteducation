<?php 
/**
 * Digital8_Enrollments extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Digital8
 * @package		Digital8_Enrollments
 * @copyright  	Copyright (c) 2013
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Intake list block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Intake_List extends Mage_Core_Block_Template{
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
 	public function __construct(){
		parent::__construct();
 		$intakes = Mage::getResourceModel('enrollments/intake_collection')
 						->addStoreFilter(Mage::app()->getStore())
				->addFilter('status', 1)
		;
		$intakes->setOrder('name', 'asc');
		$this->setIntakes($intakes);
	}
	/**
	 * prepare the layout
	 * @access protected
	 * @return Digital8_Enrollments_Block_Intake_List
	 * @author Ultimate Module Creator
	 */
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'enrollments.intake.html.pager')
			->setCollection($this->getIntakes());
		$this->setChild('pager', $pager);
		$this->getIntakes()->load();
		return $this;
	}
	/**
	 * get the pager html
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
}