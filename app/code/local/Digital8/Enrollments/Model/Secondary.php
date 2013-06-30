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
 * Secondary model
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Model_Secondary extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'enrollments_secondary';
	const CACHE_TAG = 'enrollments_secondary';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'enrollments_secondary';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'secondary';
	protected $_productInstance = null;
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('enrollments/secondary');
	}
	/**
	 * before save secondary
	 * @access protected
	 * @return Digital8_Enrollments_Model_Secondary
	 * @author Ultimate Module Creator
	 */
	protected function _beforeSave(){
		parent::_beforeSave();
		$now = Mage::getSingleton('core/date')->gmtDate();
		if ($this->isObjectNew()){
			$this->setCreatedAt($now);
		}
		$this->setUpdatedAt($now);
		return $this;
	}
	/**
	 * get the url to the secondary details page
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getSecondaryUrl(){
		if ($this->getUrlKey()){
			return Mage::getUrl('', array('_direct'=>$this->getUrlKey()));
		}
		return Mage::getUrl('enrollments/secondary/view', array('id'=>$this->getId()));
	}
	/**
	 * check URL key
	 * @access public
	 * @param string $urlKey
	 * @param bool $active
	 * @return mixed
	 * @author Ultimate Module Creator
	 */
	public function checkUrlKey($urlKey, $active = true){
		return $this->_getResource()->checkUrlKey($urlKey, $active);
	}
	/**
	 * save secondary relation
	 * @access public
	 * @return Digital8_Enrollments_Model_Secondary
	 * @author Ultimate Module Creator
	 */
	protected function _afterSave() {
		$this->getProductInstance()->saveSecondaryRelation($this);
		return parent::_afterSave();
	}
	/**
	 * get product relation model
	 * @access public
	 * @return Digital8_Enrollments_Model_Secondary_Product
	 * @author Ultimate Module Creator
	 */
	public function getProductInstance(){
		if (!$this->_productInstance) {
			$this->_productInstance = Mage::getSingleton('enrollments/secondary_product');
		}
		return $this->_productInstance;
	}
	/**
	 * get selected products array
	 * @access public
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function getSelectedProducts(){
		if (!$this->hasSelectedProducts()) {
			$products = array();
			foreach ($this->getSelectedProductsCollection() as $product) {
				$products[] = $product;
			}
			$this->setSelectedProducts($products);
		}
		return $this->getData('selected_products');
	}
	/**
	 * Retrieve collection selected products
	 * @access public
	 * @return Digital8_Enrollments_Resource_Secondary_Product_Collection
	 * @author Ultimate Module Creator
	 */
	public function getSelectedProductsCollection(){
		$collection = $this->getProductInstance()->getProductCollection($this);
		return $collection;
	}
}