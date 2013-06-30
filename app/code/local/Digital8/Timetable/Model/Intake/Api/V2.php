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
class Digital8_Timetable_Model_Intake_Api_V2 extends Digital8_Timetable_Model_Intake_Api{
	/**
	 * Intake info
	 * @access public
	 * @param int $intakeId
	 * @return object
	 * @author Ultimate Module Creator
	 */
	public function info($intakeId){
		$result = parent::info($intakeId);
		$result = Mage::helper('api')->wsiArrayPacker($result);
		return $result;
	}
}
