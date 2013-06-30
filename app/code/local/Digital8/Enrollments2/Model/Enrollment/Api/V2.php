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
class Digital8_Enrollments2_Model_Enrollment_Api_V2 extends Digital8_Enrollments2_Model_Enrollment_Api{
	/**
	 * Enrollment info
	 * @access public
	 * @param int $enrollmentId
	 * @return object
	 * @author Ultimate Module Creator
	 */
	public function info($enrollmentId){
		$result = parent::info($enrollmentId);
		$result = Mage::helper('api')->wsiArrayPacker($result);
		return $result;
	}
}
