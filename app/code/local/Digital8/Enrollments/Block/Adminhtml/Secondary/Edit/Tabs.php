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
 * Secondary admin edit tabs
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Adminhtml_Secondary_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('secondary_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('enrollments')->__('Secondary'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Digital8_Enrollments_Block_Adminhtml_Secondary_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_secondary', array(
			'label'		=> Mage::helper('enrollments')->__('Secondary'),
			'title'		=> Mage::helper('enrollments')->__('Secondary'),
			'content' 	=> $this->getLayout()->createBlock('enrollments/adminhtml_secondary_edit_tab_form')->toHtml(),
		));
		$this->addTab('form_meta_secondary', array(
			'label'		=> Mage::helper('enrollments')->__('Meta'),
			'title'		=> Mage::helper('enrollments')->__('Meta'),
			'content' 	=> $this->getLayout()->createBlock('enrollments/adminhtml_secondary_edit_tab_meta')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_secondary', array(
				'label'		=> Mage::helper('enrollments')->__('Store views'),
				'title'		=> Mage::helper('enrollments')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('enrollments/adminhtml_secondary_edit_tab_stores')->toHtml(),
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