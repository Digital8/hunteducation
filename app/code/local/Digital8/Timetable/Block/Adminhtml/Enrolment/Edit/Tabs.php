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
 * Enrolment admin edit tabs
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Block_Adminhtml_Enrolment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('enrolment_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('timetable')->__('Enrolment'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Digital8_Timetable_Block_Adminhtml_Enrolment_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_enrolment', array(
			'label'		=> Mage::helper('timetable')->__('Enrolment'),
			'title'		=> Mage::helper('timetable')->__('Enrolment'),
			'content' 	=> $this->getLayout()->createBlock('timetable/adminhtml_enrolment_edit_tab_form')->toHtml(),
		));
		$this->addTab('form_meta_enrolment', array(
			'label'		=> Mage::helper('timetable')->__('Meta'),
			'title'		=> Mage::helper('timetable')->__('Meta'),
			'content' 	=> $this->getLayout()->createBlock('timetable/adminhtml_enrolment_edit_tab_meta')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_enrolment', array(
				'label'		=> Mage::helper('timetable')->__('Store views'),
				'title'		=> Mage::helper('timetable')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('timetable/adminhtml_enrolment_edit_tab_stores')->toHtml(),
			));
		}
		return parent::_beforeToHtml();
	}
}