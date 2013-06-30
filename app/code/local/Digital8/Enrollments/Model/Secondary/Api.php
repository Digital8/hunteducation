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
class Digital8_Enrollments_Model_Secondary_Api extends Mage_Api_Model_Resource_Abstract{
	/**
	 * init secondary
	 * @access protected
	 * @param $secondaryId
	 * @return Digital8_Enrollments_Model_Secondary
	 * @author Ultimate Module Creator
	 */
	protected function _initSecondary($secondaryId){
		$secondary = Mage::getModel('enrollments/secondary')->load($secondaryId);
		if (!$secondary->getId()) {
			$this->_fault('secondary_not_exists');
		}
		return $secondary;
	}
	/**
	 * get secondarys
	 * @access public
	 * @param mixed $filters
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function items($filters = null){
		$collection = Mage::getModel('enrollments/secondary')->getCollection();
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
		foreach ($collection as $secondary) {
			$result[] = $secondary->getData();
		}
		return $result;
	}
	/**
	 * Add secondary
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
			$secondary = Mage::getModel('enrollments/secondary')
				->setData((array)$data)
				->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		} 
		catch (Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		}
		return $secondary->getId();
	}

	/**
	 * Change existing secondary information
	 * @access public
	 * @param int $secondaryId
	 * @param array $data
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function update($secondaryId, $data){
		$secondary = $this->_initSecondary($secondaryId);
		try {
			$secondary->addData((array)$data);
			$secondary->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('save_error', $e->getMessage());
		}
		
		return true;
	}
	/**
	 * remove secondary
	 * @access public
	 * @param int $secondaryId
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function remove($secondaryId){
		$secondary = $this->_initSecondary($secondaryId);
		try {
			$secondary->delete();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('remove_error', $e->getMessage());
		}
		return true;
	}
	/**
	 * get info
	 * @access public
	 * @param int $secondaryId
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function info($secondaryId){
		$result = array();
		$secondary = $this->_initSecondary($secondaryId);
		$result = $secondary->getData();
			//related products
		$result['products'] = array();
		$relatedProductsCollection = $secondary->getSelectedProductsCollection();
		foreach ($relatedProductsCollection as $product) {
			$result['products'][$product->getId()] = $product->getPosition();
		}
		return $result;
	}
	/**
	 * Assign product to secondary
	 * @access public
	 * @param int $secondaryId
	 * @param int $secondaryId
	 * @param int $position
	 * @return boolean
	 * @author Ultimate Module Creator
	 */
	public function assignProduct($secondaryId, $productId, $position = null){
		$secondary = $this->_initSecondary($secondaryId);
		$positions	= array();
		$products 	= $secondary->getSelectedProducts();
		foreach ($products as $product){
			$positions[$product->getId()] = array('position'=>$product->getPosition());
		}
		$product = Mage::getModel('catalog/product')->load($productId);
		if (!$product->getId()){
			$this->_fault('product_not_exists'); 
		}
		$positions[$productId]['position'] = $position;
		$secondary->setProductsData($positions);
		try {
			$secondary->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		}
		return true;
	}
	/**
	 * remove product from secondary
	 * @access public
	 * @param int $secondaryId
	 * @param int $productId
	 * @return boolean
	 * @author Ultimate Module Creator
	 */
	public function unassignProduct($secondaryId, $productId){
		$secondary = $this->_initSecondary($secondaryId);
		$positions	= array();
		$products 	= $secondary->getSelectedProducts();
		foreach ($products as $product){
			$positions[$product->getId()] = array('position'=>$product->getPosition());
		}
		unset($positions[$productId]);
		$secondary->setProductsData($positions);
		try {
			$secondary->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		}
		return true;
	}
}