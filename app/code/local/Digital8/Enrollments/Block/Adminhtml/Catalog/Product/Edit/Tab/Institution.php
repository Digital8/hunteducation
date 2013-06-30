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
 * Institution tab on product edit form
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Adminhtml_Catalog_Product_Edit_Tab_Institution extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * Set grid params
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('institution_grid');
		$this->setDefaultSort('position');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		if ($this->getProduct()->getId()) {
			$this->setDefaultFilter(array('in_institutions'=>1));
		}
	}
	/**
	 * prepare the institution collection
	 * @access protected 
	 * @return Digital8_Enrollments_Block_Adminhtml_Catalog_Product_Edit_Tab_Institution
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('enrollments/institution_collection');
		if ($this->getProduct()->getId()){
			$constraint = 'related.product_id='.$this->getProduct()->getId();
			}
			else{
				$constraint = 'related.product_id=0';
			}
		$collection->getSelect()->joinLeft(
			array('related'=>$collection->getTable('enrollments/institution_product')),
			'related.institution_id=main_table.entity_id AND '.$constraint,
			array('position')
		);
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}
	/**
	 * prepare mass action grid
	 * @access protected
	 * @return Digital8_Enrollments_Block_Adminhtml_Catalog_Product_Edit_Tab_Institution
	 * @author Ultimate Module Creator
	 */ 
	protected function _prepareMassaction(){
		return $this;
	}
	/**
	 * prepare the grid columns
	 * @access protected
	 * @return Digital8_Enrollments_Block_Adminhtml_Catalog_Product_Edit_Tab_Institution
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		$this->addColumn('in_institutions', array(
			'header_css_class'  => 'a-center',
			'type'  => 'checkbox',
			'name'  => 'in_institutions',
			'values'=> $this->_getSelectedInstitutions(),
			'align' => 'center',
			'index' => 'entity_id'
		));
		$this->addColumn('name', array(
			'header'=> Mage::helper('enrollments')->__('Name'),
			'align' => 'left',
			'index' => 'name',
		));
		$this->addColumn('position', array(
			'header'		=> Mage::helper('enrollments')->__('Position'),
			'name'  		=> 'position',
			'width' 		=> 60,
			'type'		=> 'number',
			'validate_class'=> 'validate-number',
			'index' 		=> 'position',
			'editable'  	=> true,
		));
	}
	/**
	 * Retrieve selected institutions
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	protected function _getSelectedInstitutions(){
		$institutions = $this->getProductInstitutions();
		if (!is_array($institutions)) {
			$institutions = array_keys($this->getSelectedInstitutions());
		}
		return $institutions;
	}
 	/**
	 * Retrieve selected institutions
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function getSelectedInstitutions() {
		$institutions = array();
		//used helper here in order not to override the product model
		$selected = Mage::helper('enrollments/product')->getSelectedInstitutions(Mage::registry('current_product'));
		if (!is_array($selected)){
			$selected = array();
		}
		foreach ($selected as $institution) {
			$institutions[$institution->getId()] = array('position' => $institution->getPosition());
		}
		return $institutions;
	}
	/**
	 * get row url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRowUrl($item){
		return '#';
	}
	/**
	 * get grid url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/institutionsGrid', array(
			'id'=>$this->getProduct()->getId()
		));
	}
	/**
	 * get the current product
	 * @access public
	 * @return Mage_Catalog_Model_Product
	 * @author Ultimate Module Creator
	 */
	public function getProduct(){
		return Mage::registry('current_product');
	}
	/**
	 * Add filter
	 * @access protected
	 * @param object $column
	 * @return Digital8_Enrollments_Block_Adminhtml_Catalog_Product_Edit_Tab_Institution
	 * @author Ultimate Module Creator
	 */
	protected function _addColumnFilterToCollection($column){
		if ($column->getId() == 'in_institutions') {
			$institutionIds = $this->_getSelectedInstitutions();
			if (empty($institutionIds)) {
				$institutionIds = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$institutionIds));
			} 
			else {
				if($institutionIds) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$institutionIds));
				}
			}
		} 
		else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}
}