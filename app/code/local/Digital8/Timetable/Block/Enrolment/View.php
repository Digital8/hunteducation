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
/**
 * Enrolment view block
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Block_Enrolment_View extends Mage_Core_Block_Template{
	/**
	 * get the current enrolment
	 * @access public
	 * @return mixed (Digital8_Timetable_Model_Enrolment|null)
	 * @author Ultimate Module Creator
	 */
	public function getCurrentEnrolment(){
		return Mage::registry('current_timetable_enrolment');
	}
} 