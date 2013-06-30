<?php
/**
 * Digital8_Timetable extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Digital8
 * @package		Digital8_Timetable
 * @copyright  	Copyright (c) 2013
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
class Digital8_Timetable_Model_Enrolment_Api extends Mage_Api_Model_Resource_Abstract{
	/**
	 * init enrolment
	 * @access protected
	 * @param $enrolmentId
	 * @return Digital8_Timetable_Model_Enrolment
	 * @author Ultimate Module Creator
	 */
	protected function _initEnrolment($enrolmentId){
		$enrolment = Mage::getModel('timetable/enrolment')->load($enrolmentId);
		if (!$enrolment->getId()) {
			$this->_fault('enrolment_not_exists');
		}
		return $enrolment;
	}
	/**
	 * get enrolments
	 * @access public
	 * @param mixed $filters
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function items($filters = null){
		$collection = Mage::getModel('timetable/enrolment')->getCollection();
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
		foreach ($collection as $enrolment) {
			$result[] = $enrolment->getData();
		}
		return $result;
	}
	/**
	 * Add enrolment
	 * @access public
	 * @param array $data
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function add($data){
		try {
			if (is_null($data)){
				throw new Exception(Mage::helper('timetable')->__("Data cannot be null"));
			}
			$enrolment = Mage::getModel('timetable/enrolment')
				->setData((array)$data)
				->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		} 
		catch (Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		}
		return $enrolment->getId();
	}

	/**
	 * Change existing enrolment information
	 * @access public
	 * @param int $enrolmentId
	 * @param array $data
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function update($enrolmentId, $data){
		$enrolment = $this->_initEnrolment($enrolmentId);
		try {
			$enrolment->addData((array)$data);
			$enrolment->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('save_error', $e->getMessage());
		}
		
		return true;
	}
	/**
	 * remove enrolment
	 * @access public
	 * @param int $enrolmentId
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function remove($enrolmentId){
		$enrolment = $this->_initEnrolment($enrolmentId);
		try {
			$enrolment->delete();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('remove_error', $e->getMessage());
		}
		return true;
	}
	/**
	 * get info
	 * @access public
	 * @param int $enrolmentId
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function info($enrolmentId){
		$result = array();
		$enrolment = $this->_initEnrolment($enrolmentId);
		$result = $enrolment->getData();
			return $result;
	}
}