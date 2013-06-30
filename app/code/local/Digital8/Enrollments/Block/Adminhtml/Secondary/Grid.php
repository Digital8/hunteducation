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
 * Secondary admin grid block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Adminhtml_Secondary_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('secondaryGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return Digital8_Enrollments_Block_Adminhtml_Secondary_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection(){
		$collection = Mage::getModel('enrollments/secondary')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * prepare grid collection
	 * @access protected
	 * @return Digital8_Enrollments_Block_Adminhtml_Secondary_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		$this->addColumn('entity_id', array(
			'header'	=> Mage::helper('enrollments')->__('Id'),
			'index'		=> 'entity_id',
			'type'		=> 'number'
		));
		$institutions = Mage::getResourceModel('enrollments/institution_collection')->toOptionHash();
		$this->addColumn('institution_id', array(
			'header'	=> Mage::helper('enrollments')->__('Institution'),
			'index'		=> 'institution_id',
			'type'		=> 'options',
			'options'	=> $institutions
		));
		$this->addColumn('name', array(
			'header'=> Mage::helper('enrollments')->__('Name'),
			'index' => 'name',
			'type'	 	=> 'text',

		));
		$this->addColumn('type', array(
			'header'=> Mage::helper('enrollments')->__('Type'),
			'index' => 'type',
			'type'	 	=> 'text',

		));
		$this->addColumn('url_key', array(
			'header'	=> Mage::helper('enrollments')->__('URL key'),
			'index'		=> 'url_key',
		));
		$this->addColumn('status', array(
			'header'	=> Mage::helper('enrollments')->__('Status'),
			'index'		=> 'status',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('enrollments')->__('Enabled'),
				'0' => Mage::helper('enrollments')->__('Disabled'),
			)
		));
		if (!Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header'=> Mage::helper('enrollments')->__('Store Views'),
				'index' => 'store_id',
				'type'  => 'store',
				'store_all' => true,
				'store_view'=> true,
				'sortable'  => false,
				'filter_condition_callback'=> array($this, '_filterStoreCondition'),
			));
		}
		$this->addColumn('created_at', array(
			'header'	=> Mage::helper('enrollments')->__('Created at'),
			'index' 	=> 'created_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));
		$this->addColumn('updated_at', array(
			'header'	=> Mage::helper('enrollments')->__('Updated at'),
			'index' 	=> 'updated_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));
		$this->addColumn('action',
			array(
				'header'=>  Mage::helper('enrollments')->__('Action'),
				'width' => '100',
				'type'  => 'action',
				'getter'=> 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('enrollments')->__('Edit'),
						'url'   => array('base'=> '*/*/edit'),
						'field' => 'id'
					)
				),
				'filter'=> false,
				'is_system'	=> true,
				'sortable'  => false,
		));
		$this->addExportType('*/*/exportCsv', Mage::helper('enrollments')->__('CSV'));
		$this->addExportType('*/*/exportExcel', Mage::helper('enrollments')->__('Excel'));
		$this->addExportType('*/*/exportXml', Mage::helper('enrollments')->__('XML'));
		return parent::_prepareColumns();
	}
	/**
	 * prepare mass action
	 * @access protected
	 * @return Digital8_Enrollments_Block_Adminhtml_Secondary_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareMassaction(){
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('secondary');
		$this->getMassactionBlock()->addItem('delete', array(
			'label'=> Mage::helper('enrollments')->__('Delete'),
			'url'  => $this->getUrl('*/*/massDelete'),
			'confirm'  => Mage::helper('enrollments')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('enrollments')->__('Change status'),
			'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'status' => array(
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('enrollments')->__('Status'),
						'values' => array(
								'1' => Mage::helper('enrollments')->__('Enabled'),
								'0' => Mage::helper('enrollments')->__('Disabled'),
						)
				)
			)
		));
		$values = Mage::getResourceModel('enrollments/institution_collection')->toOptionHash();
		$values = array_reverse($values, true); 
		$values[''] = ''; 
		$values = array_reverse($values, true);
		$this->getMassactionBlock()->addItem('institution_id', array(
			'label'=> Mage::helper('enrollments')->__('Change Institution'),
			'url'  => $this->getUrl('*/*/massInstitutionId', array('_current'=>true)),
			'additional' => array(
				'flag_institution_id' => array(
						'name' => 'flag_institution_id',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('enrollments')->__('Institution'),
						'values' => $values
				)
			)
		));
		return $this;
	}
	/**
	 * get the row url
	 * @access public
	 * @param Digital8_Enrollments_Model_Secondary
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
	 * @return Digital8_Enrollments_Block_Adminhtml_Secondary_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param Digital8_Enrollments_Model_Resource_Secondary_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return Digital8_Enrollments_Block_Adminhtml_Secondary_Grid
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