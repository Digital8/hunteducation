<?php 
/**
 * Digital8_Enrollments2 extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Digital8
 * @package		Digital8_Enrollments2
 * @copyright  	Copyright (c) 2013
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Enrollment list block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_Block_Enrollment_List extends Mage_Core_Block_Template{
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
 	public function __construct(){
		parent::__construct();
 		$enrollments = Mage::getResourceModel('enrollments2/enrollment_collection')
 						->addStoreFilter(Mage::app()->getStore())
				->addFilter('status', 1)
		;
		$enrollments->setOrder('name', 'asc');
		$this->setEnrollments($enrollments);
	}
	/**
	 * prepare the layout
	 * @access protected
	 * @return Digital8_Enrollments2_Block_Enrollment_List
	 * @author Ultimate Module Creator
	 */
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'enrollments2.enrollment.html.pager')
			->setCollection($this->getEnrollments());
		$this->setChild('pager', $pager);
		$this->getEnrollments()->load();
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