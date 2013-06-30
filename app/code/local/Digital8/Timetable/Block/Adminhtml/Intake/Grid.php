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
 * Intake admin grid block
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Block_Adminhtml_Intake_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('intakeGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return Digital8_Timetable_Block_Adminhtml_Intake_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection(){
		$collection = Mage::getModel('timetable/intake')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * prepare grid collection
	 * @access protected
	 * @return Digital8_Timetable_Block_Adminhtml_Intake_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		$this->addColumn('entity_id', array(
			'header'	=> Mage::helper('timetable')->__('Id'),
			'index'		=> 'entity_id',
			'type'		=> 'number'
		));
		$locations = Mage::getResourceModel('timetable/location_collection')->toOptionHash();
		$this->addColumn('location_id', array(
			'header'	=> Mage::helper('timetable')->__('Location'),
			'index'		=> 'location_id',
			'type'		=> 'options',
			'options'	=> $locations
		));
		$this->addColumn('date', array(
			'header'=> Mage::helper('timetable')->__('Date'),
			'index' => 'date',
			'type'	 	=> 'date',

		));
		$this->addColumn('name', array(
			'header'=> Mage::helper('timetable')->__('Name'),
			'index' => 'name',
			'type'	 	=> 'text',

		));
		$this->addColumn('url_key', array(
			'header'	=> Mage::helper('timetable')->__('URL key'),
			'index'		=> 'url_key',
		));
		$this->addColumn('status', array(
			'header'	=> Mage::helper('timetable')->__('Status'),
			'index'		=> 'status',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('timetable')->__('Enabled'),
				'0' => Mage::helper('timetable')->__('Disabled'),
			)
		));
		if (!Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header'=> Mage::helper('timetable')->__('Store Views'),
				'index' => 'store_id',
				'type'  => 'store',
				'store_all' => true,
				'store_view'=> true,
				'sortable'  => false,
				'filter_condition_callback'=> array($this, '_filterStoreCondition'),
			));
		}
		$this->addColumn('created_at', array(
			'header'	=> Mage::helper('timetable')->__('Created at'),
			'index' 	=> 'created_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));
		$this->addColumn('updated_at', array(
			'header'	=> Mage::helper('timetable')->__('Updated at'),
			'index' 	=> 'updated_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));
		$this->addColumn('action',
			array(
				'header'=>  Mage::helper('timetable')->__('Action'),
				'width' => '100',
				'type'  => 'action',
				'getter'=> 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('timetable')->__('Edit'),
						'url'   => array('base'=> '*/*/edit'),
						'field' => 'id'
					)
				),
				'filter'=> false,
				'is_system'	=> true,
				'sortable'  => false,
		));
		$this->addExportType('*/*/exportCsv', Mage::helper('timetable')->__('CSV'));
		$this->addExportType('*/*/exportExcel', Mage::helper('timetable')->__('Excel'));
		$this->addExportType('*/*/exportXml', Mage::helper('timetable')->__('XML'));
		return parent::_prepareColumns();
	}
	/**
	 * prepare mass action
	 * @access protected
	 * @return Digital8_Timetable_Block_Adminhtml_Intake_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareMassaction(){
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('intake');
		$this->getMassactionBlock()->addItem('delete', array(
			'label'=> Mage::helper('timetable')->__('Delete'),
			'url'  => $this->getUrl('*/*/massDelete'),
			'confirm'  => Mage::helper('timetable')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('timetable')->__('Change status'),
			'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'status' => array(
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('timetable')->__('Status'),
						'values' => array(
								'1' => Mage::helper('timetable')->__('Enabled'),
								'0' => Mage::helper('timetable')->__('Disabled'),
						)
				)
			)
		));
		$values = Mage::getResourceModel('timetable/location_collection')->toOptionHash();
		$values = array_reverse($values, true); 
		$values[''] = ''; 
		$values = array_reverse($values, true);
		$this->getMassactionBlock()->addItem('location_id', array(
			'label'=> Mage::helper('timetable')->__('Change Location'),
			'url'  => $this->getUrl('*/*/massLocationId', array('_current'=>true)),
			'additional' => array(
				'flag_location_id' => array(
						'name' => 'flag_location_id',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('timetable')->__('Location'),
						'values' => $values
				)
			)
		));
		return $this;
	}
	/**
	 * get the row url
	 * @access public
	 * @param Digital8_Timetable_Model_Intake
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRowUrl($row){
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
	/**
	 * get the grid url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}
	/**
	 * after collection load
	 * @access protected
	 * @return Digital8_Timetable_Block_Adminhtml_Intake_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param Digital8_Timetable_Model_Resource_Intake_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return Digital8_Timetable_Block_Adminhtml_Intake_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _filterStoreCondition($collection, $column){
		if (!$value = $column->getFilter()->getValue()) {
        	return;
		}
		$collection->addStoreFilter($value);
		return $this;
    }
}