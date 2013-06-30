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
 * Secondary edit form tab
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Adminhtml_Secondary_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Enrollments_Secondary_Block_Adminhtml_Secondary_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('secondary_');
		$form->setFieldNameSuffix('secondary');
		$this->setForm($form);
		$fieldset = $form->addFieldset('secondary_form', array('legend'=>Mage::helper('enrollments')->__('Secondary')));
		$values = Mage::getResourceModel('enrollments/institution_collection')->toOptionArray();
		array_unshift($values, array('label'=>'', 'value'=>''));		
		$fieldset->addField('institution_id', 'select', array(
			'label' 	=> Mage::helper('enrollments')->__('Institution'),
			'name'  	=> 'institution_id',
			'required'  => false,
			'values'	=> $values
		));

		$fieldset->addField('name', 'text', array(
			'label' => Mage::helper('enrollments')->__('Name'),
			'name'  => 'name',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('type', 'text', array(
			'label' => Mage::helper('enrollments')->__('Type'),
			'name'  => 'type',
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
            Mage::registry('current_secondary')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getSecondaryData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getSecondaryData());
			Mage::getSingleton('adminhtml/session')->setSecondaryData(null);
		}
		elseif (Mage::registry('current_secondary')){
			$form->setValues(Mage::registry('current_secondary')->getData());
		}
		return parent::_prepareForm();
	}
}