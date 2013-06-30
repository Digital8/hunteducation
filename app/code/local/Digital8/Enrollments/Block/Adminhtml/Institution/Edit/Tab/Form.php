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
 * Institution edit form tab
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Adminhtml_Institution_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Enrollments_Institution_Block_Adminhtml_Institution_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('institution_');
		$form->setFieldNameSuffix('institution');
		$this->setForm($form);
		$fieldset = $form->addFieldset('institution_form', array('legend'=>Mage::helper('enrollments')->__('Institution')));

		$fieldset->addField('name', 'text', array(
			'label' => Mage::helper('enrollments')->__('Name'),
			'name'  => 'name',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('course', 'text', array(
			'label' => Mage::helper('enrollments')->__('Course'),
			'name'  => 'course',
			'required'  => true,
			'class' => 'required-entry',

		));
		$fieldset->addField('url_key', 'text', array(
			'label' => Mage::helper('enrollments')->__('Url key'),
			'name'  => 'url_key',
			'required'  => true,
			'class' => 'required-entry',
			'note'	=> Mage::helper('enrollments')->__('Relative to Website Base URL')
		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('enrollments')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('enrollments')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('enrollments')->__('Disabled'),
				),
			),
		));
		$fieldset->addField('in_rss', 'select', array(
			'label' => Mage::helper('enrollments')->__('Show in rss'),
			'name'  => 'in_rss',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('enrollments')->__('Yes'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('enrollments')->__('No'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_institution')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getInstitutionData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getInstitutionData());
			Mage::getSingleton('adminhtml/session')->setInstitutionData(null);
		}
		elseif (Mage::registry('current_institution')){
			$form->setValues(Mage::registry('current_institution')->getData());
		}
		return parent::_prepareForm();
	}
}