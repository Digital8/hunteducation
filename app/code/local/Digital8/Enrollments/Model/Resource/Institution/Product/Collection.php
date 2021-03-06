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
 * Institution - product relation resource model collection
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Model_Resource_Institution_Product_Collection extends Mage_Catalog_Model_Resource_Product_Collection{
	/**
	 * remember if fields have been joined
	 * @var bool
	 */
	protected $_joinedFields = false;
	/**
	 * join the link table
	 * @access public
	 * @return Digital8_Enrollments_Model_Resource_Institution_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function joinFields(){
		if (!$this->_joinedFields){
			$this->getSelect()->join(
				array('related' => $this->getTable('enrollments/institution_product')),
				'related.product_id = e.entity_id',
				array('position')
			);
			$this->_joinedFields = true;
		}
		return $this;
	}
	/**
	 * add institution filter
	 * @access public
	 * @param Digital8_Enrollments_Model_Institution | int $institution
	 * @return Digital8_Enrollments_Model_Resource_Institution_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function addInstitutionFilter($institution){
		if ($institution instanceof Digital8_Enrollments_Model_Institution){
			$institution = $institution->getId();
		}
		if (!$this->_joinedFields){
			$this->joinFields();
		}
		$this->getSelect()->where('related.institution_id = ?', $institution);
		return $this;
	}
}