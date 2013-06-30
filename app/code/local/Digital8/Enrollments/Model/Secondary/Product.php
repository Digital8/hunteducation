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
 * Secondary product model
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Model_Secondary_Product extends Mage_Core_Model_Abstract{
	/**
	 * Initialize resource
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		$this->_init('enrollments/secondary_product');
	}
	/**
	 * Save data for secondary-product relation
	 * @access public
	 * @param  Digital8_Enrollments_Model_Secondary $secondary
	 * @return Digital8_Enrollments_Model_Secondary_Product
	 * @author Ultimate Module Creator
	 */
	public function saveSecondaryRelation($secondary){
		$data = $secondary->getProductsData();
		if (!is_null($data)) {
			$this->_getResource()->saveSecondaryRelation($secondary, $data);
		}
		return $this;
	}
	/**
	 * get products for secondary
	 * @access public
	 * @param Digital8_Enrollments_Model_Secondary $secondary
	 * @return Digital8_Enrollments_Model_Resource_Secondary_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function getProductCollection($secondary){
		$collection = Mage::getResourceModel('enrollments/secondary_product_collection')
			->addSecondaryFilter($secondary);
		return $collection;
	}
}