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
 * Institution product model
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Model_Institution_Product extends Mage_Core_Model_Abstract{
	/**
	 * Initialize resource
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		$this->_init('enrollments/institution_product');
	}
	/**
	 * Save data for institution-product relation
	 * @access public
	 * @param  Digital8_Enrollments_Model_Institution $institution
	 * @return Digital8_Enrollments_Model_Institution_Product
	 * @author Ultimate Module Creator
	 */
	public function saveInstitutionRelation($institution){
		$data = $institution->getProductsData();
		if (!is_null($data)) {
			$this->_getResource()->saveInstitutionRelation($institution, $data);
		}
		return $this;
	}
	/**
	 * get products for institution
	 * @access public
	 * @param Digital8_Enrollments_Model_Institution $institution
	 * @return Digital8_Enrollments_Model_Resource_Institution_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function getProductCollection($institution){
		$collection = Mage::getResourceModel('enrollments/institution_product_collection')
			->addInstitutionFilter($institution);
		return $collection;
	}
}