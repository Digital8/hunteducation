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
 * Timetable default helper
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Helper_Data extends Mage_Core_Helper_Abstract{
	/**
	 * get the url to the intakes list page
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getIntakesUrl(){
		return Mage::getUrl('timetable/intake/index');
	}
	/**
	 * get the url to the locations list page
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getLocationsUrl(){
		return Mage::getUrl('timetable/location/index');
	}
	/**
	 * get the url to the enrolments list page
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getEnrolmentsUrl(){
		return Mage::getUrl('timetable/enrolment/index');
	}
}