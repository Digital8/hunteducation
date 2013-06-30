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
 * Location admin edit block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_Block_Adminhtml_Location_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'enrollments2';
		$this->_controller = 'adminhtml_location';
		$this->_updateButton('save', 'label', Mage::helper('enrollments2')->__('Save Location'));
		$this->_updateButton('delete', 'label', Mage::helper('enrollments2')->__('Delete Location'));
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('enrollments2')->__('Save And Continue Edit'),
			'onclick'	=> 'saveAndContinueEdit()',
			'class'		=> 'save',
		), -100);
		$this->_formScripts[] = "
			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
	}
	/**
	 * get the edit form header
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getHeaderText(){
		if( Mage::registry('location_data') && Mage::registry('location_data')->getId() ) {
			return Mage::helper('enrollments2')->__("Edit Location '%s'", $this->htmlEscape(Mage::registry('location_data')->getName()));
		} 
		else {
			return Mage::helper('enrollments2')->__('Add Location');
		}
	}
}