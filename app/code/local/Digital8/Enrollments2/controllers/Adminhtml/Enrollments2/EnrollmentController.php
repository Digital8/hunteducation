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
 * Enrollment admin controller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_Adminhtml_Enrollments2_EnrollmentController extends Digital8_Enrollments2_Controller_Adminhtml_Enrollments2{
	/**
	 * init the enrollment
	 * @access protected
	 * @return Digital8_Enrollments2_Model_Enrollment
	 */
	protected function _initEnrollment(){
		$enrollmentId  = (int) $this->getRequest()->getParam('id');
		$enrollment	= Mage::getModel('enrollments2/enrollment');
		if ($enrollmentId) {
			$enrollment->load($enrollmentId);
		}
		Mage::register('current_enrollment', $enrollment);
		return $enrollment;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('enrollments2')->__('Enrollments2'))
			 ->_title(Mage::helper('enrollments2')->__('Enrollments'));
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
	 * edit enrollment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$enrollmentId	= $this->getRequest()->getParam('id');
		$enrollment  	= $this->_initEnrollment();
		if ($enrollmentId && !$enrollment->getId()) {
			$this->_getSession()->addError(Mage::helper('enrollments2')->__('This enrollment no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$enrollment->setData($data);
		}
		Mage::register('enrollment_data', $enrollment);
		$this->loadLayout();
		$this->_title(Mage::helper('enrollments2')->__('Enrollments2'))
			 ->_title(Mage::helper('enrollments2')->__('Enrollments'));
		if ($enrollment->getId()){
			$this->_title($enrollment->getName());
		}
		else{
			$this->_title(Mage::helper('enrollments2')->__('Add enrollment'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new enrollment action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save enrollment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('enrollment')) {
			try {
				$enrollment = $this->_initEnrollment();
				$enrollment->addData($data);
				$enrollment->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments2')->__('Enrollment was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $enrollment->getId()));
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
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('There was a problem saving the enrollment.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('Unable to find enrollment to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete enrollment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$enrollment = Mage::getModel('enrollments2/enrollment');
				$enrollment->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments2')->__('Enrollment was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('There was an error deleteing enrollment.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('Could not find enrollment to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete enrollment - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$enrollmentIds = $this->getRequest()->getParam('enrollment');
		if(!is_array($enrollmentIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('Please select enrollments to delete.'));
		}
		else {
			try {
				foreach ($enrollmentIds as $enrollmentId) {
					$enrollment = Mage::getModel('enrollments2/enrollment');
					$enrollment->setId($enrollmentId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments2')->__('Total of %d enrollments were successfully deleted.', count($enrollmentIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('There was an error deleteing enrollments.'));
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
		$enrollmentIds = $this->getRequest()->getParam('enrollment');
		if(!is_array($enrollmentIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('Please select enrollments.'));
		} 
		else {
			try {
				foreach ($enrollmentIds as $enrollmentId) {
				$enrollment = Mage::getSingleton('enrollments2/enrollment')->load($enrollmentId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d enrollments were successfully updated.', count($enrollmentIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('There was an error updating enrollments.'));
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
		$enrollmentIds = $this->getRequest()->getParam('enrollment');
		if(!is_array($enrollmentIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('Please select enrollments.'));
		} 
		else {
			try {
				foreach ($enrollmentIds as $enrollmentId) {
				$enrollment = Mage::getSingleton('enrollments2/enrollment')->load($enrollmentId)
							->setApproved($this->getRequest()->getParam('flag_approved'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d enrollments were successfully updated.', count($enrollmentIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('There was an error updating enrollments.'));
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
		$enrollmentIds = $this->getRequest()->getParam('enrollment');
		if(!is_array($enrollmentIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('Please select enrollments.'));
		} 
		else {
			try {
				foreach ($enrollmentIds as $enrollmentId) {
				$enrollment = Mage::getSingleton('enrollments2/enrollment')->load($enrollmentId)
							->setIntakeId($this->getRequest()->getParam('flag_intake_id'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d enrollments were successfully updated.', count($enrollmentIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('There was an error updating enrollments.'));
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
		$fileName   = 'enrollment.csv';
		$content	= $this->getLayout()->createBlock('enrollments2/adminhtml_enrollment_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'enrollment.xls';
		$content	= $this->getLayout()->createBlock('enrollments2/adminhtml_enrollment_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'enrollment.xml';
		$content	= $this->getLayout()->createBlock('enrollments2/adminhtml_enrollment_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}