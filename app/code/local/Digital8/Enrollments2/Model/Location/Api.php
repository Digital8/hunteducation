<?php
/**
 * Digital8_Enrollments2 extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Digital8
 * @package		Digital8_Enrollments2
 * @copyright  	Copyright (c) 2013
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
class Digital8_Enrollments2_Model_Location_Api extends Mage_Api_Model_Resource_Abstract{
	/**
	 * init location
	 * @access protected
	 * @param $locationId
	 * @return Digital8_Enrollments2_Model_Location
	 * @author Ultimate Module Creator
	 */
	protected function _initLocation($locationId){
		$location = Mage::getModel('enrollments2/location')->load($locationId);
		if (!$location->getId()) {
			$this->_fault('location_not_exists');
		}
		return $location;
	}
	/**
	 * get locations
	 * @access public
	 * @param mixed $filters
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function items($filters = null){
		$collection = Mage::getModel('enrollments2/location')->getCollection();
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
		foreach ($collection as $location) {
			$result[] = $location->getData();
		}
		return $result;
	}
	/**
	 * Add location
	 * @access public
	 * @param array $data
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function add($data){
		try {
			if (is_null($data)){
				throw new Exception(Mage::helper('enrollments2')->__("Data cannot be null"));
			}
			$location = Mage::getModel('enrollments2/location')
				->setData((array)$data)
				->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		} 
		catch (Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		}
		return $location->getId();
	}

	/**
	 * Change existing location information
	 * @access public
	 * @param int $locationId
	 * @param array $data
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function update($locationId, $data){
		$location = $this->_initLocation($locationId);
		try {
			$location->addData((array)$data);
			$location->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('save_error', $e->getMessage());
		}
		
		return true;
	}
	/**
	 * remove location
	 * @access public
	 * @param int $locationId
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function remove($locationId){
		$location = $this->_initLocation($locationId);
		try {
			$location->delete();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('remove_error', $e->getMessage());
		}
		return true;
	}
	/**
	 * get info
	 * @access public
	 * @param int $locationId
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function info($locationId){
		$result = array();
		$location = $this->_initLocation($locationId);
		$result = $location->getData();
			return $result;
	}
}