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
 * Intake edit form tab
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_Block_Adminhtml_Intake_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Enrollments2_Intake_Block_Adminhtml_Intake_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('intake_');
		$form->setFieldNameSuffix('intake');
		$this->setForm($form);
		$fieldset = $form->addFieldset('intake_form', array('legend'=>Mage::helper('enrollments2')->__('Intake')));
		$values = Mage::getResourceModel('enrollments2/location_collection')->toOptionArray();
		array_unshift($values, array('label'=>'', 'value'=>''));		
		$fieldset->addField('location_id', 'select', array(
			'label' 	=> Mage::helper('enrollments2')->__('Location'),
			'name'  	=> 'location_id',
			'required'  => false,
			'values'	=> $values
		));
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
			Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
		);

		$fieldset->addField('date', 'date', array(
			'label' => Mage::helper('enrollments2')->__('Date'),
			'name'  => 'date',
			'required'  => true,
			'class' => 'required-entry',

		'image'	 => $this->getSkinUrl('images/grid-cal.gif'),
		'format'	=> $dateFormatIso,
		));

		$fieldset->addField('enrolled', 'text', array(
			'label' => Mage::helper('enrollments2')->__('Enrolled'),
			'name'  => 'enrolled',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('name', 'text', array(
			'label' => Mage::helper('enrollments2')->__('Name'),
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