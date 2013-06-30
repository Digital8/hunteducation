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
 * Intake admin controller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Adminhtml_Enrollments_IntakeController extends Digital8_Enrollments_Controller_Adminhtml_Enrollments{
	/**
	 * init the intake
	 * @access protected
	 * @return Digital8_Enrollments_Model_Intake
	 */
	protected function _initIntake(){
		$intakeId  = (int) $this->getRequest()->getParam('id');
		$intake	= Mage::getModel('enrollments/intake');
		if ($intakeId) {
			$intake->load($intakeId);
		}
		Mage::register('current_intake', $intake);
		return $intake;
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
			 ->_title(Mage::helper('enrollments')->__('Intakes'));
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
	 * edit intake - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$intakeId	= $this->getRequest()->getParam('id');
		$intake  	= $this->_initIntake();
		if ($intakeId && !$intake->getId()) {
			$this->_getSession()->addError(Mage::helper('enrollments')->__('This intake no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$intake->setData($data);
		}
		Mage::register('intake_data', $intake);
		$this->loadLayout();
		$this->_title(Mage::helper('enrollments')->__('Enrollments'))
			 ->_title(Mage::helper('enrollments')->__('Intakes'));
		if ($intake->getId()){
			$this->_title($intake->getName());
		}
		else{
			$this->_title(Mage::helper('enrollments')->__('Add intake'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new intake action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save intake - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('intake')) {
			try {
				$intake = $this->_initIntake();
				$intake->addData($data);
				$intake->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments')->__('Intake was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $intake->getId()));
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
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was a problem saving the intake.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Unable to find intake to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete intake - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$intake = Mage::getModel('enrollments/intake');
				$intake->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments')->__('Intake was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error deleteing intake.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Could not find intake to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete intake - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$intakeIds = $this->getRequest()->getParam('intake');
		if(!is_array($intakeIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Please select intakes to delete.'));
		}
		else {
			try {
				foreach ($intakeIds as $intakeId) {
					$intake = Mage::getModel('enrollments/intake');
					$intake->setId($intakeId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments')->__('Total of %d intakes were successfully deleted.', count($intakeIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error deleteing intakes.'));
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
		$intakeIds = $this->getRequest()->getParam('intake');
		if(!is_array($intakeIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Please select intakes.'));
		} 
		else {
			try {
				foreach ($intakeIds as $intakeId) {
				$intake = Mage::getSingleton('enrollments/intake')->load($intakeId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d intakes were successfully updated.', count($intakeIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error updating intakes.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass location change - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massLocationIdAction(){
		$intakeIds = $this->getRequest()->getParam('intake');
		if(!is_array($intakeIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('Please select intakes.'));
		} 
		else {
			try {
				foreach ($intakeIds as $intakeId) {
				$intake = Mage::getSingleton('enrollments/intake')->load($intakeId)
							->setLocationId($this->getRequest()->getParam('flag_location_id'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d intakes were successfully updated.', count($intakeIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments')->__('There was an error updating intakes.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * export as csv - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportCsvAction(){
		$fileName   = 'intake.csv';
		$content	= $this->getLayout()->createBlock('enrollments/adminhtml_intake_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'intake.xls';
		$content	= $this->getLayout()->createBlock('enrollments/adminhtml_intake_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'intake.xml';
		$content	= $this->getLayout()->createBlock('enrollments/adminhtml_intake_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}