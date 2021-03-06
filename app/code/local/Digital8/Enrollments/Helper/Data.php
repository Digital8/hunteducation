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
/**
 * Enrollments default helper
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Helper_Data extends Mage_Core_Helper_Abstract{
	/**
	 * get the url to the intakes list page
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getIntakesUrl(){
		return Mage::getUrl('enrollments/intake/index');
	}
	/**
	 * get the url to the locations list page
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getLocationsUrl(){
		return Mage::getUrl('enrollments/location/index');
	}
	/**
	 * get the url to the enrollments list page
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getEnrollmentsUrl(){
		return Mage::getUrl('enrollments/enrollment/index');
	}
}