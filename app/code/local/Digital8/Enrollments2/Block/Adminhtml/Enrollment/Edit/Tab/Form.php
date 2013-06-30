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
 * Enrollment edit form tab
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_Block_Adminhtml_Enrollment_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Enrollments2_Enrollment_Block_Adminhtml_Enrollment_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('enrollment_');
		$form->setFieldNameSuffix('enrollment');
		$this->setForm($form);
		$fieldset = $form->addFieldset('enrollment_form', array('legend'=>Mage::helper('enrollments2')->__('Enrollment')));
		$values = Mage::getResourceModel('enrollments2/intake_collection')->toOptionArray();
		array_unshift($values, array('label'=>'', 'value'=>''));		
		$fieldset->addField('intake_id', 'select', array(
			'label' 	=> Mage::helper('enrollments2')->__('Intake'),
			'name'  	=> 'intake_id',
			'required'  => false,
			'values'	=> $values
		));

		$fieldset->addField('uuid', 'text', array(
			'label' => Mage::helper('enrollments2')->__('uuid'),
			'name'  => 'uuid',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('xml', 'textarea', array(
			'label' => Mage::helper('enrollments2')->__('xml'),
			'name'  => 'xml',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('approved', 'select', array(
			'label' => Mage::helper('enrollments2')->__('approved'),
			'name'  => 'approved',
			'required'  => true,
			'class' => 'required-entry',

			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('enrollments2')->__('Yes'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('enrollments2')->__('No'),
				),
			),
		));

		$fieldset->addField('email', 'text', array(
			'label' => Mage::helper('enrollments2')->__('email'),
			'name'  => 'email',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('name', 'text', array(
			'label' => Mage::helper('enrollments2')->__('name'),
			'name'  => 'name',
			'required'  => true,
			'class' => 'required-entry',

		));
		$fieldset->addField('url_key', 'text', array(
			'label' => Mage::helper('enrollments2')->__('Url key'),
			'name'  => 'url_key',
			'required'  => true,
			'class' => 'required-entry',
			'note'	=> Mage::helper('enrollments2')->__('Relative to Website Base URL')
		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('enrollments2')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('enrollments2')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('enrollments2')->__('Disabled'),
				),
			),
		));
		$fieldset->addField('in_rss', 'select', array(
			'label' => Mage::helper('enrollments2')->__('Show in rss'),
			'name'  => 'in_rss',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('enrollments2')->__('Yes'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('enrollments2')->__('No'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_enrollment')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getEnrollmentData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getEnrollmentData());
			Mage::getSingleton('adminhtml/session')->setEnrollmentData(null);
		}
		elseif (Mage::registry('current_enrollment')){
			$form->setValues(Mage::registry('current_enrollment')->getData());
		}
		return parent::_prepareForm();
	}
}