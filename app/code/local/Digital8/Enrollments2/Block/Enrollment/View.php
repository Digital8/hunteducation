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
/**
 * Enrollment view block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_Block_Enrollment_View extends Mage_Core_Block_Template{
	/**
	 * get the current enrollment
	 * @access public
	 * @return mixed (Digital8_Enrollments2_Model_Enrollment|null)
	 * @author Ultimate Module Creator
	 */
	public function getCurrentEnrollment(){
		return Mage::registry('current_enrollments2_enrollment');
	}
} 