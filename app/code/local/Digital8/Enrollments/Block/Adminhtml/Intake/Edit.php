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
 * Intake admin edit block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Adminhtml_Intake_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'enrollments';
		$this->_controller = 'adminhtml_intake';
		$this->_updateButton('save', 'label', Mage::helper('enrollments')->__('Save Intake'));
		$this->_updateButton('delete', 'label', Mage::helper('enrollments')->__('Delete Intake'));
		$this->_addButton('saveandcontinue', array(
			'label'		=> Mage::helper('enrollments')->__('Save And Continue Edit'),
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
		if( Mage::registry('intake_data') && Mage::registry('intake_data')->getId() ) {
			return Mage::helper('enrollments')->__("Edit Intake '%s'", $this->htmlEscape(Mage::registry('intake_data')->getName()));
		} 
		else {
			return Mage::helper('enrollments')->__('Add Intake');
		}
	}
}