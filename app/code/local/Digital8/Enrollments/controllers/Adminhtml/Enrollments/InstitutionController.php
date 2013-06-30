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
 * Institution admin controller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Adminhtml_Enrollments_InstitutionController extends Digital8_Enrollments_Controller_Adminhtml_Enrollments{
	/**
	 * init the institution
	 * @access protected
	 * @return Digital8_Enrollments_Model_Institution
	 */
	protected function _initInstitution(){
		$institutionId  = (int) $this->getRequest()->getParam('id');
		$institution	= Mage::getModel('enrollments/institution');
		if ($institutionId) {
			$institution->load($institutionId);
		}
		Mage::register('current_institution', $institution);
		return $institution;
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
			 ->_title(Mage::helper('enrollments')->__('Institutions'));
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
	 * edit institution - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$institutionId	= $this->getRequest()->getParam('id');
		$institution  	= $this->_initInstitution();
		if ($institutionId && !$institution->getId()) {
			$this->_getSession()->addError(Mage::helper('enrollments')->__('This institution no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$institution->setData($data);
		}
		Mage::register('institution_data', $institution);
		$this->loadLayout();
		$this->_title(Mage::helper('enrollments')->__('Enrollments'))
			 ->_title(Mage::helper('enrollments')->__('Institutions'));
		if ($institution->getId()){
			$this->_title($institution->getName());
		}
		else{
			$this->_title(Mage::helper('enrollments')->__('Add institution'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new institution action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save institution - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('institution')) {
			try {
				$institution = $this->_initInstitution();
				$institution->addData($data);
				$products = $this->getRequest()->getPost('products', -1);
				if ($products != -1) {
					$institution->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($products));
				}
				$institution->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments')->__('Institution was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $institution->getId()));
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
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was a problem saving the institution.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Unable to find institution to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete institution - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$institution = Mage::getModel('enrollments/institution');
				$institution->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments')->__('Institution was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error deleteing institution.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Could not find institution to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete institution - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$institutionIds = $this->getRequest()->getParam('institution');
		if(!is_array($institutionIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Please select institutions to delete.'));
		}
		else {
			try {
				foreach ($institutionIds as $institutionId) {
					$institution = Mage::getModel('enrollments/institution');
					$institution->setId($institutionId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments')->__('Total of %d institutions were successfully deleted.', count($institutionIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error deleteing institutions.'));
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
		$institutionIds = $this->getRequest()->getParam('institution');
		if(!is_array($institutionIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Please select institutions.'));
		} 
		else {
			try {
				foreach ($institutionIds as $institutionId) {
				$institution = Mage::getSingleton('enrollments/institution')->load($institutionId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d institutions were successfully updated.', count($institutionIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error updating institutions.'));
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
		$this->_initInstitution();
		$this->loadLayout();
		$this->getLayout()->getBlock('institution.edit.tab.product')
			->setInstitutionProducts($this->getRequest()->getPost('institution_products', null));
		$this->renderLayout();
	}
	/**
	 * get grid of products action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function productsgridAction(){
		$this->_initInstitution();
		$this->loadLayout();
		$this->getLayout()->getBlock('institution.edit.tab.product')
			->setInstitutionProducts($this->getRequest()->getPost('institution_products', null));
		$this->renderLayout();
	}
	/**
	 * export as csv - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportCsvAction(){
		$fileName   = 'institution.csv';
		$content	= $this->getLayout()->createBlock('enrollments/adminhtml_institution_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'institution.xls';
		$content	= $this->getLayout()->createBlock('enrollments/adminhtml_institution_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'institution.xml';
		$content	= $this->getLayout()->createBlock('enrollments/adminhtml_institution_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}