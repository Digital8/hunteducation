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
class Digital8_Enrollments_Model_Secondary_Api_V2 extends Digital8_Enrollments_Model_Secondary_Api{
	/**
	 * Secondary info
	 * @access public
	 * @param int $secondaryId
	 * @return object
	 * @author Ultimate Module Creator
	 */
	public function info($secondaryId){
		$result = parent::info($secondaryId);
		$result = Mage::helper('api')->wsiArrayPacker($result);
		foreach ($result->products as $key => $value) {
			$result->products[$key] = array('key' => $key, 'value' => $value);
		}
		return $result;
	}
}
