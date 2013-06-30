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
 * Secondary view block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Secondary_View extends Mage_Core_Block_Template{
	/**
	 * get the current secondary
	 * @access public
	 * @return mixed (Digital8_Enrollments_Model_Secondary|null)
	 * @author Ultimate Module Creator
	 */
	public function getCurrentSecondary(){
		return Mage::registry('current_enrollments_secondary');
	}
} 