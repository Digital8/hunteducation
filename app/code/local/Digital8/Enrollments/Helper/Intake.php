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
 * Intake helper
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Helper_Intake extends Mage_Core_Helper_Abstract{
	/**
	 * check if the rss for intake is enabled
	 * @access public
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function isRssEnabled(){
		return  Mage::getStoreConfigFlag('rss/config/active') && Mage::getStoreConfigFlag('enrollments/intake/rss');
	}
	/**
	 * get the link to the intake rss list
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRssUrl(){
		return Mage::getUrl('enrollments/intake/rss');
	}
	/**
	 * check if breadcrumbs can be used
	 * @access public
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function getUseBreadcrumbs(){
		return Mage::getStoreConfigFlag('enrollments/intake/breadcrumbs');
	}
}