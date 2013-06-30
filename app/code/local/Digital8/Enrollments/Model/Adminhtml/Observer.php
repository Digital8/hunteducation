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
 * Adminhtml observer
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Model_Adminhtml_Observer{
	/**
	 * check if tab can be added
	 * @access protected
	 * @param Mage_Catalog_Model_Product $product
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	protected function _canAddTab($product){
		if ($product->getId()){
			return true;
		}
		if (!$product->getAttributeSetId()){
			return false;
		}
		$request = Mage::app()->getRequest();
		if ($request->getParam('type') == 'configurable'){
			if ($request->getParam('attribtues')){
				return true;
			}
		}
		return false;
	}
	/**
	 * add the institution tab to products
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return Digital8_Enrollments_Model_Adminhtml_Observer
	 * @author Ultimate Module Creator
	 */
	public function addInstitutionBlock($observer){
		$block = $observer->getEvent()->getBlock();
		$product = Mage::registry('product');
		if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $this->_canAddTab($product)){
			$block->addTab('institutions', array(
				'label' => Mage::helper('enrollments')->__('Institutions'),
				'url'   => Mage::helper('adminhtml')->getUrl('adminhtml/enrollments_institution_catalog_product/institutions', array('_current' => true)),
				'class' => 'ajax',
			));
		}
		return $this;
	}
	/**
	 * add the secondary tab to products
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return Digital8_Enrollments_Model_Adminhtml_Observer
	 * @author Ultimate Module Creator
	 */
	public function addSecondaryBlock($observer){
		$block = $observer->getEvent()->getBlock();
		$product = Mage::registry('product');
		if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $this->_canAddTab($product)){
			$block->addTab('secondarys', array(
				'label' => Mage::helper('enrollments')->__('Secondarys'),
				'url'   => Mage::helper('adminhtml')->getUrl('adminhtml/enrollments_secondary_catalog_product/secondarys', array('_current' => true)),
				'class' => 'ajax',
			));
		}
		return $this;
	}
	/**
	 * save institution - product relation
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return Digital8_Enrollments_Model_Adminhtml_Observer
	 * @author Ultimate Module Creator
	 */
	public function saveInstitutionData($observer){
		$post = Mage::app()->getRequest()->getPost('institutions', -1);
		if ($post != '-1') {
			$post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
			$product = Mage::registry('product');
			$institutionProduct = Mage::getResourceSingleton('enrollments/institution_product')->saveProductRelation($product, $post);
		}
		return $this;
	}	/**
	 * save secondary - product relation
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return Digital8_Enrollments_Model_Adminhtml_Observer
	 * @author Ultimate Module Creator
	 */
	public function saveSecondaryData($observer){
		$post = Mage::app()->getRequest()->getPost('secondarys', -1);
		if ($post != '-1') {
			$post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
			$product = Mage::registry('product');
			$secondaryProduct = Mage::getResourceSingleton('enrollments/secondary_product')->saveProductRelation($product, $post);
		}
		return $this;
	}}