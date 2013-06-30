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
 * Product helper
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Helper_Product extends Digital8_Enrollments_Helper_Data{
	/**
	 * get the selected institutions for a product
	 * @access public
	 * @param Mage_Catalog_Model_Product $product
	 * @return array()
	 * @author Ultimate Module Creator
	 */
	public function getSelectedInstitutions(Mage_Catalog_Model_Product $product){
		if (!$product->hasSelectedInstitutions()) {
			$institutions = array();
			foreach ($this->getSelectedInstitutionsCollection($product) as $institution) {
				$institutions[] = $institution;
			}
			$product->setSelectedInstitutions($institutions);
		}
		return $product->getData('selected_institutions');
	}
	/**
	 * get institution collection for a product
	 * @access public
	 * @param Mage_Catalog_Model_Product $product
	 * @return Digital8_Enrollments_Model_Resource_Institution_Collection
	 */
	public function getSelectedInstitutionsCollection(Mage_Catalog_Model_Product $product){
		$collection = Mage::getResourceSingleton('enrollments/institution_collection')
			->addProductFilter($product);
		return $collection;
	}
	/**
	 * get the selected secondarys for a product
	 * @access public
	 * @param Mage_Catalog_Model_Product $product
	 * @return array()
	 * @author Ultimate Module Creator
	 */
	public function getSelectedSecondarys(Mage_Catalog_Model_Product $product){
		if (!$product->hasSelectedSecondarys()) {
			$secondarys = array();
			foreach ($this->getSelectedSecondarysCollection($product) as $secondary) {
				$secondarys[] = $secondary;
			}
			$product->setSelectedSecondarys($secondarys);
		}
		return $product->getData('selected_secondarys');
	}
	/**
	 * get secondary collection for a product
	 * @access public
	 * @param Mage_Catalog_Model_Product $product
	 * @return Digital8_Enrollments_Model_Resource_Secondary_Collection
	 */
	public function getSelectedSecondarysCollection(Mage_Catalog_Model_Product $product){
		$collection = Mage::getResourceSingleton('enrollments/secondary_collection')
			->addProductFilter($product);
		return $collection;
	}
}