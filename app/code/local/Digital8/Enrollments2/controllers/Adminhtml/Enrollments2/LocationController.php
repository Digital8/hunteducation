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
 * Location admin controller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_Adminhtml_Enrollments2_LocationController extends Digital8_Enrollments2_Controller_Adminhtml_Enrollments2{
	/**
	 * init the location
	 * @access protected
	 * @return Digital8_Enrollments2_Model_Location
	 */
	protected function _initLocation(){
		$locationId  = (int) $this->getRequest()->getParam('id');
		$location	= Mage::getModel('enrollments2/location');
		if ($locationId) {
			$location->load($locationId);
		}
		Mage::register('current_location', $location);
		return $location;
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
			 ->_title(Mage::helper('enrollments2')->__('Locations'));
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
	 * edit location - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function editAction() {
		$locationId	= $this->getRequest()->getParam('id');
		$location  	= $this->_initLocation();
		if ($locationId && !$location->getId()) {
			$this->_getSession()->addError(Mage::helper('enrollments2')->__('This location no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$location->setData($data);
		}
		Mage::register('location_data', $location);
		$this->loadLayout();
		$this->_title(Mage::helper('enrollments2')->__('Enrollments2'))
			 ->_title(Mage::helper('enrollments2')->__('Locations'));
		if ($location->getId()){
			$this->_title($location->getName());
		}
		else{
			$this->_title(Mage::helper('enrollments2')->__('Add location'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new location action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save location - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('location')) {
			try {
				$location = $this->_initLocation();
				$location->addData($data);
				$location->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments2')->__('Location was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $location->getId()));
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
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('There was a problem saving the location.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('Unable to find location to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete location - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$location = Mage::getModel('enrollments2/location');
				$location->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments2')->__('Location was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('There was an error deleteing location.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('Could not find location to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete location - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function massDeleteAction() {
		$locationIds = $this->getRequest()->getParam('location');
		if(!is_array($locationIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('Please select locations to delete.'));
		}
		else {
			try {
				foreach ($locationIds as $locationId) {
					$location = Mage::getModel('enrollments2/location');
					$location->setId($locationId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enrollments2')->__('Total of %d locations were successfully deleted.', count($locationIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('There was an error deleteing locations.'));
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
		$locationIds = $this->getRequest()->getParam('location');
		if(!is_array($locationIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('Please select locations.'));
		} 
		else {
			try {
				foreach ($locationIds as $locationId) {
				$location = Mage::getSingleton('enrollments2/location')->load($locationId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d locations were successfully updated.', count($locationIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enrollments2')->__('There was an error updating locations.'));
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
		$fileName   = 'location.csv';
		$content	= $this->getLayout()->createBlock('enrollments2/adminhtml_location_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportExcelAction(){
		$fileName   = 'location.xls';
		$content	= $this->getLayout()->createBlock('enrollments2/adminhtml_location_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function exportXmlAction(){
		$fileName   = 'location.xml';
		$content	= $this->getLayout()->createBlock('enrollments2/adminhtml_location_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}