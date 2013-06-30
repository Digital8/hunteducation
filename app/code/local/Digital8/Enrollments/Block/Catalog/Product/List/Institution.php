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
 * Institution list on product page block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Catalog_Product_List_Institution extends Mage_Catalog_Block_Product_Abstract{
	/**
	 * get the list of institutions
	 * @access protected
	 * @return Digital8_Enrollments_Model_Resource_Institution_Collection 
	 * @author Ultimate Module Creator
	 */
	public function getInstitutionCollection(){
		if (!$this->hasData('institution_collection')){
			$product = Mage::registry('product');
			$collection = Mage::getResourceSingleton('enrollments/institution_collection')
				->addStoreFilter(Mage::app()->getStore())

				->addFilter('status', 1)
				->addProductFilter($product);
			$collection->getSelect()->order('related_product.position', 'ASC');
			$this->setData('institution_collection', $collection);
		}
		return $this->getData('institution_collection');
	}
}