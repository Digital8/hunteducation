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
 * Secondary product admin controller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class Digital8_Enrollments_Adminhtml_Enrollments_Secondary_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController{
	/**
	 * construct
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		// Define module dependent translate
		$this->setUsedModuleName('Digital8_Enrollments');
	}
	/**
	 * secondarys in the catalog page
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function secondarysAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.secondary')
			->setProductSecondarys($this->getRequest()->getPost('product_secondarys', null));
		$this->renderLayout();
	}
	/**
	 * secondarys grid in the catalog page
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function secondarysGridAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.secondary')
			->setProductSecondarys($this->getRequest()->getPost('product_secondarys', null));
		$this->renderLayout();
	}
}