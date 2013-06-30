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
 * Enrollment admin edit tabs
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_Block_Adminhtml_Enrollment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('enrollment_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('enrollments2')->__('Enrollment'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Digital8_Enrollments2_Block_Adminhtml_Enrollment_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_enrollment', array(
			'label'		=> Mage::helper('enrollments2')->__('Enrollment'),
			'title'		=> Mage::helper('enrollments2')->__('Enrollment'),
			'content' 	=> $this->getLayout()->createBlock('enrollments2/adminhtml_enrollment_edit_tab_form')->toHtml(),
		));
		$this->addTab('form_meta_enrollment', array(
			'label'		=> Mage::helper('enrollments2')->__('Meta'),
			'title'		=> Mage::helper('enrollments2')->__('Meta'),
			'content' 	=> $this->getLayout()->createBlock('enrollments2/adminhtml_enrollment_edit_tab_meta')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_enrollment', array(
				'label'		=> Mage::helper('enrollments2')->__('Store views'),
				'title'		=> Mage::helper('enrollments2')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('enrollments2/adminhtml_enrollment_edit_tab_stores')->toHtml(),
			));
		}
		return parent::_beforeToHtml();
	}
}