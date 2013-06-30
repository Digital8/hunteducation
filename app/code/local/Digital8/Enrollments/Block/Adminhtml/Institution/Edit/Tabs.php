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
 * Institution admin edit tabs
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Adminhtml_Institution_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('institution_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('enrollments')->__('Institution'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Digital8_Enrollments_Block_Adminhtml_Institution_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_institution', array(
			'label'		=> Mage::helper('enrollments')->__('Institution'),
			'title'		=> Mage::helper('enrollments')->__('Institution'),
			'content' 	=> $this->getLayout()->createBlock('enrollments/adminhtml_institution_edit_tab_form')->toHtml(),
		));
		$this->addTab('form_meta_institution', array(
			'label'		=> Mage::helper('enrollments')->__('Meta'),
			'title'		=> Mage::helper('enrollments')->__('Meta'),
			'content' 	=> $this->getLayout()->createBlock('enrollments/adminhtml_institution_edit_tab_meta')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_institution', array(
				'label'		=> Mage::helper('enrollments')->__('Store views'),
				'title'		=> Mage::helper('enrollments')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('enrollments/adminhtml_institution_edit_tab_stores')->toHtml(),
			));
		}
		$this->addTab('products', array(
			'label' => Mage::helper('enrollments')->__('Associated products'),
			'url'   => $this->getUrl('*/*/products', array('_current' => true)),
   			'class'	=> 'ajax'
		));
		return parent::_beforeToHtml();
	}
}