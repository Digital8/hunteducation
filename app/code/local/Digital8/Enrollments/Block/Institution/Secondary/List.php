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
 * Institution Secondary list block 
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Institution_Secondary_List extends Digital8_Enrollments_Block_Secondary_List{
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
 	public function __construct(){
		parent::__construct();
		$institution = $this->getInstitution();
		if ($institution){
			$this->getSecondarys()->addFilter('institution_id', $institution->getId());
		}
	}
	/**
	 * prepare the layout - actually do nothing
	 * @access protected
	 * @return Digital8_Enrollments_Block_Institution_Secondary_List
	 * @author Ultimate Module Creator
	 */
	protected function _prepareLayout(){
		return $this;
	}
	/**
	 * get the current institution
	 * @access public
	 * @return Digital8_Enrollments_Model_Institution
	 * @author Ultimate Module Creator
	 */
	public function getInstitution(){
		return Mage::registry('current_enrollments_institution');
	}
}
