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
 * Secondary admin controller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Adminhtml_Enrollments_SecondaryController extends Digital8_Enrollments_Controller_Adminhtml_Enrollments{
	/**
	 * init the secondary
	 * @access protected
	 * @return Digital8_Enrollments_Model_Secondary
	 */
	protected function _initSecondary(){
		$secondaryId  = (int) $this->getRequest()->getParam('id');
		$secondary	= Mage::getModel('enrollments/secondary');
		if ($secondaryId) {
			$secondary->load($secondaryId);
		}
		Mage::register('current_secondary', $secondary);
		return $secondary;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('enrollments')->__('Enrollments'))
			 ->_title(Mage::helper('enrollments')->__('Secondary'));
		$this->renderLayout();
	}
	/**
	 * grid action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function gridAction() {
		$this->loadLayout()->renderLayout();
	}
	/**
	 * edit secondary - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$secondaryId	= $this->getRequest()->getParam('id');
		$secondary  	= $this->_initSecondary();
		if ($secondaryId && !$secondary->getId()) {
			$this->_getSession()->addError(Mage::helper('enrollments')->__('This secondary no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$secondary->setData($data);
		}
		Mage::register('secondary_data', $secondary);
		$this->loadLayout();
		$this->_title(Mage::helper('enrollments')->__('Enrollments'))
			 ->_title(Mage::helper('enrollments')->__('Secondary'));
		if ($secondary->getId()){
			$this->_title($secondary->getName());
		}
		else{
			$this->_title(Mage::helper('enrollments')->__('Add secondary'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new secondary action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save secondary - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('secondary')) {
			try {
				$secondary = $this->_initSecondary();
				$secondary->addData($data);
				$products = $this->getRequest()->getPost('products', -1);
				if ($products != -1) {
					$secondary->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
				}
				$secondary->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments')->__('Secondary was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $secondary->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} 
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
			catch (Exception $e) {
				Mage::logException($e);
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was a problem saving the secondary.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Unable to find secondary to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete secondary - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$secondary = Mage::getModel('enrollments/secondary');
				$secondary->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments')->__('Secondary was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error deleteing secondary.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Could not find secondary to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete secondary - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$secondaryIds = $this->getRequest()->getParam('secondary');
		if(!is_array($secondaryIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Please select secondary to delete.'));
		}
		else {
			try {
				foreach ($secondaryIds as $secondaryId) {
					$secondary = Mage::getModel('enrollments/secondary');
					$secondary->setId($secondaryId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments')->__('Total of %d secondary were successfully deleted.', count($secondaryIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error deleteing secondary.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass status change - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massStatusAction(){
		$secondaryIds = $this->getRequest()->getParam('secondary');
		if(!is_array($secondaryIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Please select secondary.'));
		} 
		else {
			try {
				foreach ($secondaryIds as $secondaryId) {
				$secondary = Mage::getSingleton('enrollments/secondary')->load($secondaryId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d secondary were successfully updated.', count($secondaryIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error updating secondary.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass institution change - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massInstitutionIdAction(){
		$secondaryIds = $this->getRequest()->getParam('secondary');
		if(!is_array($secondaryIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Please select secondary.'));
		} 
		else {
			try {
				foreach ($secondaryIds as $secondaryId) {
				$secondary = Mage::getSingleton('enrollments/secondary')->load($secondaryId)
							->setInstitutionId($this->getRequest()->getParam('flag_institution_id'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d secondary were successfully updated.', count($secondaryIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error updating secondary.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * get grid of products action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function productsAction(){
		$this->_initSecondary();
		$this->loadLayout();
		$this->getLayout()->getBlock('secondary.edit.tab.product')
			->setSecondaryProducts($this->getRequest()->getPost('secondary_products', null));
		$this->renderLayout();
	}
	/**
	 * get grid of products action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function productsgridAction(){
		$this->_initSecondary();
		$this->loadLayout();
		$this->getLayout()->getBlock('secondary.edit.tab.product')
			->setSecondaryProducts($this->getRequest()->getPost('secondary_products', null));
		$this->renderLayout();
	}
	/**
	 * export as csv - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportCsvAction(){
		$fileName   = 'secondary.csv';
		$content	= $this->getLayout()->createBlock('enrollments/adminhtml_secondary_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'secondary.xls';
		$content	= $this->getLayout()->createBlock('enrollments/adminhtml_secondary_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'secondary.xml';
		$content	= $this->getLayout()->createBlock('enrollments/adminhtml_secondary_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}