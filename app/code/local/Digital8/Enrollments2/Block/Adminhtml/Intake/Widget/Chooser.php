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
 * Intake admin widget chooser
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_Block_Adminhtml_Intake_Widget_Chooser extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * Block construction, prepare grid params
	 * @access public
	 * @param array $arguments Object data
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct($arguments=array()){
		parent::__construct($arguments);
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		$this->setDefaultFilter(array('chooser_status' => '1'));
	}
	/**
	 * Prepare chooser element HTML
	 * @access public
	 * @param Varien_Data_Form_Element_Abstract $element Form Element
	 * @return Varien_Data_Form_Element_Abstract
	 * @author Ultimate Module Creator
	 */
	public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element){
		$uniqId = Mage::helper('core')->uniqHash($element->getId());
		$sourceUrl = $this->getUrl('enrollments2/adminhtml_enrollments2_intake_widget/chooser', array('uniq_id' => $uniqId));
		$chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
				->setElement($element)
				->setTranslationHelper($this->getTranslationHelper())
				->setConfig($this->getConfig())
				->setFieldsetId($this->getFieldsetId())
				->setSourceUrl($sourceUrl)
				->setUniqId($uniqId);
		if ($element->getValue()) {
			$intake = Mage::getModel('enrollments2/intake')->load($element->getValue());
			if ($intake->getId()) {
				$chooser->setLabel($intake->getName());
			}
		}
		$element->setData('after_element_html', $chooser->toHtml());
		return $element;
	}
	/**
	 * Grid Row JS Callback
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRowClickCallback(){
		$chooserJsObject = $this->getId();
		$js = '
			function (grid, event) {
				var trElement = Event.findElement(event, "tr");
				var intakeId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
				var intakeTitle = trElement.down("td").next().innerHTML;
				'.$chooserJsObject.'.setElementValue(intakeId);
				'.$chooserJsObject.'.setElementLabel(intakeTitle);
				'.$chooserJsObject.'.close();
			}
		';
		return $js;
	}
	/**
	 * Prepare a static blocks collection
	 * @access protected
	 * @return Digital8_Enrollments2_Block_Adminhtml_Intake_Widget_Chooser
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection(){
		$collection = Mage::getModel('enrollments2/intake')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * Prepare columns for the a grid
	 * @access protected 
	 * @return Digital8_Enrollments2_Block_Adminhtml_Intake_Widget_Chooser
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		$this->addColumn('chooser_id', array(
			'header'	=> Mage::helper('enrollments2')->__('Id'),
			'align' 	=> 'right',
			'index' 	=> 'entity_id',
			'type'		=> 'number',
			'width' 	=> 50
		));
		
		$this->addColumn('chooser_name', array(
			'header'=> Mage::helper('enrollments2')->__('Name'),
			'align' => 'left',
			'index' => 'name',
		));
		if (!Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header'=> Mage::helper('enrollments2')->__('Store Views'),
				'index' => 'store_id',
				'type'  => 'store',
				'store_all' => true,
				'store_view'=> true,
				'sortable'  => false,
			));
		}
		$this->addColumn('chooser_status', array(
			'header'=> Mage::helper('enrollments2')->__('Status'),
			'index' => 'status',
			'type'  => 'options',
			'options'   => array(
				0 => Mage::helper('enrollments2')->__('Disabled'),
				1 => Mage::helper('enrollments2')->__('Enabled')
			),
		));
		return parent::_prepareColumns();
	}
	/**
	 * get url for grid
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getGridUrl(){
		return $this->getUrl('adminhtml/enrollments2_intake_widget/chooser', array('_current' => true));
	}
	/**
	 * after collection load
	 * @access protected
	 * @return Digital8_Enrollments2_Block_Adminhtml_Intake_Widget_Chooser
	 * @author Ultimate Module Creator
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
}