<?php 
/**
 * Digital8_Timetable extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Digital8
 * @package		Digital8_Timetable
 * @copyright  	Copyright (c) 2013
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Enrolment list block
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Block_Enrolment_List extends Mage_Core_Block_Template{
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
 	public function __construct(){
		parent::__construct();
 		$enrolments = Mage::getResourceModel('timetable/enrolment_collection')
 						->addStoreFilter(Mage::app()->getStore())
				->addFilter('status', 1)
		;
		$enrolments->setOrder('name', 'asc');
		$this->setEnrolments($enrolments);
	}
	/**
	 * prepare the layout
	 * @access protected
	 * @return Digital8_Timetable_Block_Enrolment_List
	 * @author Ultimate Module Creator
	 */
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'timetable.enrolment.html.pager')
			->setCollection($this->getEnrolments());
		$this->setChild('pager', $pager);
		$this->getEnrolments()->load();
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