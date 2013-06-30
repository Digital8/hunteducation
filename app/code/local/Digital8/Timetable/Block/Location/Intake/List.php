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
 * Location Intakes list block 
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Block_Location_Intake_List extends Digital8_Timetable_Block_Intake_List{
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
 	public function __construct(){
		parent::__construct();
		$location = $this->getLocation();
		if ($location){
			$this->getIntakes()->addFilter('location_id', $location->getId());
		}
	}
	/**
	 * prepare the layout - actually do nothing
	 * @access protected
	 * @return Digital8_Timetable_Block_Location_Intake_List
	 * @author Ultimate Module Creator
	 */
	protected function _prepareLayout(){
		return $this;
	}
	/**
	 * get the current location
	 * @access public
	 * @return Digital8_Timetable_Model_Location
	 * @author Ultimate Module Creator
	 */
	public function getLocation(){
		return Mage::registry('current_timetable_location');
	}
}
