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
class Digital8_Enrollments_Model_Institution_Api extends Mage_Api_Model_Resource_Abstract{
	/**
	 * init institution
	 * @access protected
	 * @param $institutionId
	 * @return Digital8_Enrollments_Model_Institution
	 * @author Ultimate Module Creator
	 */
	protected function _initInstitution($institutionId){
		$institution = Mage::getModel('enrollments/institution')->load($institutionId);
		if (!$institution->getId()) {
			$this->_fault('institution_not_exists');
		}
		return $institution;
	}
	/**
	 * get institutions
	 * @access public
	 * @param mixed $filters
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function items($filters = null){
		$collection = Mage::getModel('enrollments/institution')->getCollection();
		$apiHelper = Mage::helper('api');
		$filters = $apiHelper->parseFilters($filters);
		try {
			foreach ($filters as $field => $value) {
				$collection->addFieldToFilter($field, $value);
			}
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('filters_invalid', $e->getMessage());
		}
		$result = array();
		foreach ($collection as $institution) {
			$result[] = $institution->getData();
		}
		return $result;
	}
	/**
	 * Add institution
	 * @access public
	 * @param array $data
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function add($data){
		try {
			if (is_null($data)){
				throw new Exception(Mage::helper('enrollments')->__("Data cannot be null"));
			}
			$institution = Mage::getModel('enrollments/institution')
				->setData((array)$data)
				->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		} 
		catch (Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		}
		return $institution->getId();
	}

	/**
	 * Change existing institution information
	 * @access public
	 * @param int $institutionId
	 * @param array $data
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function update($institutionId, $data){
		$institution = $this->_initInstitution($institutionId);
		try {
			$institution->addData((array)$data);
			$institution->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('save_error', $e->getMessage());
		}
		
		return true;
	}
	/**
	 * remove institution
	 * @access public
	 * @param int $institutionId
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function remove($institutionId){
		$institution = $this->_initInstitution($institutionId);
		try {
			$institution->delete();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('remove_error', $e->getMessage());
		}
		return true;
	}
	/**
	 * get info
	 * @access public
	 * @param int $institutionId
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function info($institutionId){
		$result = array();
		$institution = $this->_initInstitution($institutionId);
		$result = $institution->getData();
			//related products
		$result['products'] = array();
		$relatedProductsCollection = $institution->getSelectedProductsCollection();
		foreach ($relatedProductsCollection as $product) {
			$result['products'][$product->getId()] = $product->getPosition();
		}
		return $result;
	}
	/**
	 * Assign product to institution
	 * @access public
	 * @param int $institutionId
	 * @param int $institutionId
	 * @param int $position
	 * @return boolean
	 * @author Ultimate Module Creator
	 */
	public function assignProduct($institutionId, $productId, $position = null){
		$institution = $this->_initInstitution($institutionId);
		$positions	= array();
		$products 	= $institution->getSelectedProducts();
		foreach ($products as $product){
			$positions[$product->getId()] = array('position'=>$product->getPosition());
		}
		$product = Mage::getModel('catalog/product')->load($productId);
		if (!$product->getId()){
			$this->_fault('product_not_exists'); 
		}
		$positions[$productId]['position'] = $position;
		$institution->setProductsData($positions);
		try {
			$institution->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		}
		return true;
	}
	/**
	 * remove product from institution
	 * @access public
	 * @param int $institutionId
	 * @param int $productId
	 * @return boolean
	 * @author Ultimate Module Creator
	 */
	public function unassignProduct($institutionId, $productId){
		$institution = $this->_initInstitution($institutionId);
		$positions	= array();
		$products 	= $institution->getSelectedProducts();
		foreach ($products as $product){
			$positions[$product->getId()] = array('position'=>$product->getPosition());
		}
		unset($positions[$productId]);
		$institution->setProductsData($positions);
		try {
			$institution->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		}
		return true;
	}
}