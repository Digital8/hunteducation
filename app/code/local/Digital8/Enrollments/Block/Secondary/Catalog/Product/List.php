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
 * Secondary product list
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Secondary_Catalog_Product_List extends Mage_Core_Block_Template{
	/**
	 * get the list of products
	 * @access public
	 * @return Mage_Catalog_Model_Resource_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function getProductCollection(){
		$collection = $this->getSecondary()->getSelectedProductsCollection();
		$collection->addAttributeToSelect('name');
		$collection->addUrlRewrite();
		$collection->getSelect()->order('related.position');
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
		return $collection;
	}
	/**
	 * get current secondary
	 * @access public
	 * @return Digital8_Enrollments_Model_Secondary
	 * @author Ultimate Module Creator
	 */
	public function getSecondary(){
		return Mage::registry('current_enrollments_secondary');
	}
}