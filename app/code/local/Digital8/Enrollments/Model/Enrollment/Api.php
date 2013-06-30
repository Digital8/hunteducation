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
class Digital8_Enrollments_Model_Enrollment_Api extends Mage_Api_Model_Resource_Abstract{
	/**
	 * init enrollment
	 * @access protected
	 * @param $enrollmentId
	 * @return Digital8_Enrollments_Model_Enrollment
	 * @author Ultimate Module Creator
	 */
	protected function _initEnrollment($enrollmentId){
		$enrollment = Mage::getModel('enrollments/enrollment')->load($enrollmentId);
		if (!$enrollment->getId()) {
			$this->_fault('enrollment_not_exists');
		}
		return $enrollment;
	}
	/**
	 * get enrollments
	 * @access public
	 * @param mixed $filters
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function items($filters = null){
		$collection = Mage::getModel('enrollments/enrollment')->getCollection();
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
		foreach ($collection as $enrollment) {
			$result[] = $enrollment->getData();
		}
		return $result;
	}
	/**
	 * Add enrollment
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
			$enrollment = Mage::getModel('enrollments/enrollment')
				->setData((array)$data)
				->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		} 
		catch (Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		}
		return $enrollment->getId();
	}

	/**
	 * Change existing enrollment information
	 * @access public
	 * @param int $enrollmentId
	 * @param array $data
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function update($enrollmentId, $data){
		$enrollment = $this->_initEnrollment($enrollmentId);
		try {
			$enrollment->addData((array)$data);
			$enrollment->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('save_error', $e->getMessage());
		}
		
		return true;
	}
	/**
	 * remove enrollment
	 * @access public
	 * @param int $enrollmentId
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function remove($enrollmentId){
		$enrollment = $this->_initEnrollment($enrollmentId);
		try {
			$enrollment->delete();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('remove_error', $e->getMessage());
		}
		return true;
	}
	/**
	 * get info
	 * @access public
	 * @param int $enrollmentId
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function info($enrollmentId){
		$result = array();
		$enrollment = $this->_initEnrollment($enrollmentId);
		$result = $enrollment->getData();
			return $result;
	}
}