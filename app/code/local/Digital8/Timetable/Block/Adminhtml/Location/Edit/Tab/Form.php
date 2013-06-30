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
 * Location edit form tab
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Block_Adminhtml_Location_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Timetable_Location_Block_Adminhtml_Location_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('location_');
		$form->setFieldNameSuffix('location');
		$this->setForm($form);
		$fieldset = $form->addFieldset('location_form', array('legend'=>Mage::helper('timetable')->__('Location')));

		$fieldset->addField('suburb', 'text', array(
			'label' => Mage::helper('timetable')->__('Suburb'),
			'name'  => 'suburb',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('state', 'text', array(
			'label' => Mage::helper('timetable')->__('State'),
			'name'  => 'state',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('address', 'text', array(
			'label' => Mage::helper('timetable')->__('Address'),
			'name'  => 'address',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('googlemaps', 'text', array(
			'label' => Mage::helper('timetable')->__('Google Maps'),
			'name'  => 'googlemaps',
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('name', 'text', array(
			'label' => Mage::helper('timetable')->__('Name'),
			'name'  => 'name',
			'required'  => true,
			'class' => 'required-entry',

		));
		$fieldset->addField('url_key', 'text', array(
			'label' => Mage::helper('timetable')->__('Url key'),
			'name'  => 'url_key',
			'required'  => true,
			'class' => 'required-entry',
			'note'	=> Mage::helper('timetable')->__('Relative to Website Base URL')
		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('timetable')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('timetable')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('timetable')->__('Disabled'),
				),
			),
		));
		$fieldset->addField('in_rss', 'select', array(
			'label' => Mage::helper('timetable')->__('Show in rss'),
			'name'  => 'in_rss',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('timetable')->__('Yes'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('timetable')->__('No'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_location')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getLocationData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getLocationData());
			Mage::getSingleton('adminhtml/session')->setLocationData(null);
		}
		elseif (Mage::registry('current_location')){
			$form->setValues(Mage::registry('current_location')->getData());
		}
		return parent::_prepareForm();
	}
}