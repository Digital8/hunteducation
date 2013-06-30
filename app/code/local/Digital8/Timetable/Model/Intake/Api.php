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
class Digital8_Timetable_Model_Intake_Api extends Mage_Api_Model_Resource_Abstract{
	/**
	 * init intake
	 * @access protected
	 * @param $intakeId
	 * @return Digital8_Timetable_Model_Intake
	 * @author Ultimate Module Creator
	 */
	protected function _initIntake($intakeId){
		$intake = Mage::getModel('timetable/intake')->load($intakeId);
		if (!$intake->getId()) {
			$this->_fault('intake_not_exists');
		}
		return $intake;
	}
	/**
	 * get intakes
	 * @access public
	 * @param mixed $filters
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function items($filters = null){
		$collection = Mage::getModel('timetable/intake')->getCollection();
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
		foreach ($collection as $intake) {
			$result[] = $intake->getData();
		}
		return $result;
	}
	/**
	 * Add intake
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
			$intake = Mage::getModel('timetable/intake')
				->setData((array)$data)
				->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		} 
		catch (Exception $e) {
			$this->_fault('data_invalid', $e->getMessage());
		}
		return $intake->getId();
	}

	/**
	 * Change existing intake information
	 * @access public
	 * @param int $intakeId
	 * @param array $data
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function update($intakeId, $data){
		$intake = $this->_initIntake($intakeId);
		try {
			$intake->addData((array)$data);
			$intake->save();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('save_error', $e->getMessage());
		}
		
		return true;
	}
	/**
	 * remove intake
	 * @access public
	 * @param int $intakeId
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function remove($intakeId){
		$intake = $this->_initIntake($intakeId);
		try {
			$intake->delete();
		} 
		catch (Mage_Core_Exception $e) {
			$this->_fault('remove_error', $e->getMessage());
		}
		return true;
	}
	/**
	 * get info
	 * @access public
	 * @param int $intakeId
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function info($intakeId){
		$result = array();
		$intake = $this->_initIntake($intakeId);
		$result = $intake->getData();
			return $result;
	}
}