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
 * Enrolment admin controller
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Adminhtml_Timetable_EnrolmentController extends Digital8_Timetable_Controller_Adminhtml_Timetable{
	/**
	 * init the enrolment
	 * @access protected
	 * @return Digital8_Timetable_Model_Enrolment
	 */
	protected function _initEnrolment(){
		$enrolmentId  = (int) $this->getRequest()->getParam('id');
		$enrolment	= Mage::getModel('timetable/enrolment');
		if ($enrolmentId) {
			$enrolment->load($enrolmentId);
		}
		Mage::register('current_enrolment', $enrolment);
		return $enrolment;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('timetable')->__('Timetable'))
			 ->_title(Mage::helper('timetable')->__('Enrolments'));
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
	 * edit enrolment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$enrolmentId	= $this->getRequest()->getParam('id');
		$enrolment  	= $this->_initEnrolment();
		if ($enrolmentId && !$enrolment->getId()) {
			$this->_getSession()->addError(Mage::helper('timetable')->__('This enrolment no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$enrolment->setData($data);
		}
		Mage::register('enrolment_data', $enrolment);
		$this->loadLayout();
		$this->_title(Mage::helper('timetable')->__('Timetable'))
			 ->_title(Mage::helper('timetable')->__('Enrolments'));
		if ($enrolment->getId()){
			$this->_title($enrolment->getName());
		}
		else{
			$this->_title(Mage::helper('timetable')->__('Add enrolment'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new enrolment action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save enrolment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('enrolment')) {
			try {
				$enrolment = $this->_initEnrolment();
				$enrolment->addData($data);
				$enrolment->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('timetable')->__('Enrolment was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $enrolment->getId()));
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
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('There was a problem saving the enrolment.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('Unable to find enrolment to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete enrolment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$enrolment = Mage::getModel('timetable/enrolment');
				$enrolment->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('timetable')->__('Enrolment was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('There was an error deleteing enrolment.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('Could not find enrolment to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete enrolment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$enrolmentIds = $this->getRequest()->getParam('enrolment');
		if(!is_array($enrolmentIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('Please select enrolments to delete.'));
		}
		else {
			try {
				foreach ($enrolmentIds as $enrolmentId) {
					$enrolment = Mage::getModel('timetable/enrolment');
					$enrolment->setId($enrolmentId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('timetable')->__('Total of %d enrolments were successfully deleted.', count($enrolmentIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('There was an error deleteing enrolments.'));
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
		$enrolmentIds = $this->getRequest()->getParam('enrolment');
		if(!is_array($enrolmentIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('Please select enrolments.'));
		} 
		else {
			try {
				foreach ($enrolmentIds as $enrolmentId) {
				$enrolment = Mage::getSingleton('timetable/enrolment')->load($enrolmentId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d enrolments were successfully updated.', count($enrolmentIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('There was an error updating enrolments.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass approved change - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massApprovedAction(){
		$enrolmentIds = $this->getRequest()->getParam('enrolment');
		if(!is_array($enrolmentIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('Please select enrolments.'));
		} 
		else {
			try {
				foreach ($enrolmentIds as $enrolmentId) {
				$enrolment = Mage::getSingleton('timetable/enrolment')->load($enrolmentId)
							->setApproved($this->getRequest()->getParam('flag_approved'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d enrolments were successfully updated.', count($enrolmentIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('There was an error updating enrolments.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass intake change - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massIntakeIdAction(){
		$enrolmentIds = $this->getRequest()->getParam('enrolment');
		if(!is_array($enrolmentIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('Please select enrolments.'));
		} 
		else {
			try {
				foreach ($enrolmentIds as $enrolmentId) {
				$enrolment = Mage::getSingleton('timetable/enrolment')->load($enrolmentId)
							->setIntakeId($this->getRequest()->getParam('flag_intake_id'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d enrolments were successfully updated.', count($enrolmentIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timetable')->__('There was an error updating enrolments.'));
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
		$fileName   = 'enrolment.csv';
		$content	= $this->getLayout()->createBlock('timetable/adminhtml_enrolment_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'enrolment.xls';
		$content	= $this->getLayout()->createBlock('timetable/adminhtml_enrolment_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'enrolment.xml';
		$content	= $this->getLayout()->createBlock('timetable/adminhtml_enrolment_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}