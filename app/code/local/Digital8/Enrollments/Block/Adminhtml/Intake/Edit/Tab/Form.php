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
 * Intake edit form tab
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Adminhtml_Intake_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Enrollments_Intake_Block_Adminhtml_Intake_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('intake_');
		$form->setFieldNameSuffix('intake');
		$this->setForm($form);
		$fieldset = $form->addFieldset('intake_form', array('legend'=>Mage::helper('enrollments')->__('Intake')));
		$values = Mage::getResourceModel('enrollments/location_collection')->toOptionArray();
		array_unshift($values, array('label'=>'', 'value'=>''));		
		$fieldset->addField('location_id', 'select', array(
			'label' 	=> Mage::helper('enrollments')->__('Location'),
			'name'  	=> 'location_id',
			'required'  => false,
			'values'	=> $values
		));
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
			Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
		);

		$fieldset->addField('date', 'date', array(
			'label' => Mage::helper('enrollments')->__('Date'),
			'name'  => 'date',
			'required'  => true,
			'class' => 'required-entry',

		'image'	 => $this->getSkinUrl('images/grid-cal.gif'),
		'format'	=> $dateFormatIso,
		));

		$fieldset->addField('enrolled', 'text', array(
			'label' => Mage::helper('enrollments')->__('Enrolled'),
			'name'  => 'enrolled',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('name', 'text', array(
			'label' => Mage::helper('enrollments')->__('Name'),
			'name'  => 'name',
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
            Mage::registry('current_intake')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getIntakeData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getIntakeData());
			Mage::getSingleton('adminhtml/session')->setIntakeData(null);
		}
		elseif (Mage::registry('current_intake')){
			$form->setValues(Mage::registry('current_intake')->getData());
		}
		return parent::_prepareForm();
	}
}