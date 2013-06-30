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
 * Enrollment front contrller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_EnrollmentController extends Mage_Core_Controller_Front_Action{
	/**
 	 * default action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
 	public function indexAction(){
		$this->loadLayout();
 		if (Mage::helper('enrollments/enrollment')->getUseBreadcrumbs()){
			if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
				$breadcrumbBlock->addCrumb('home', array(
							'label'	=> Mage::helper('enrollments')->__('Home'), 
							'link' 	=> Mage::getUrl(),
						)
				);
				$breadcrumbBlock->addCrumb('enrollments', array(
							'label'	=> Mage::helper('enrollments')->__('Enrollments'), 
							'link'	=> '',
					)
				);
			}
		}
		$headBlock = $this->getLayout()->getBlock('head');
		if ($headBlock) {
			$headBlock->setTitle(Mage::getStoreConfig('enrollments/enrollment/meta_title'));
			$headBlock->setKeywords(Mage::getStoreConfig('enrollments/enrollment/meta_keywords'));
			$headBlock->setDescription(Mage::getStoreConfig('enrollments/enrollment/meta_description'));
		}
		$this->renderLayout();
	}
	/**
 	 * view enrollment action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
	public function viewAction(){
		$enrollmentId 	= $this->getRequest()->getParam('id', 0);
		$enrollment 	= Mage::getModel('enrollments/enrollment')
						->setStoreId(Mage::app()->getStore()->getId())
						->load($enrollmentId);
		if (!$enrollment->getId()){
			$this->_forward('no-route');
		}
		elseif (!$enrollment->getStatus()){
			$this->_forward('no-route');
		}
		else{
			Mage::register('current_enrollments_enrollment', $enrollment);
			$this->loadLayout();
			if ($root = $this->getLayout()->getBlock('root')) {
				$root->addBodyClass('enrollments-enrollment enrollments-enrollment' . $enrollment->getId());
			}
			if (Mage::helper('enrollments/enrollment')->getUseBreadcrumbs()){
				if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
					$breadcrumbBlock->addCrumb('home', array(
								'label'	=> Mage::helper('enrollments')->__('Home'), 
								'link' 	=> Mage::getUrl(),
							)
					);
					$breadcrumbBlock->addCrumb('enrollments', array(
								'label'	=> Mage::helper('enrollments')->__('Enrollments'), 
								'link'	=> Mage::helper('enrollments')->getEnrollmentsUrl(),
						)
					);
					$breadcrumbBlock->addCrumb('enrollment', array(
								'label'	=> $enrollment->getName(), 
								'link'	=> '',
						)
					);
				}
			}
			$headBlock = $this->getLayout()->getBlock('head');
			if ($headBlock) {
				if ($enrollment->getMetaTitle()){
					$headBlock->setTitle($enrollment->getMetaTitle());
				}
				else{
					$headBlock->setTitle($enrollment->getName());
				}
				$headBlock->setKeywords($enrollment->getMetaKeywords());
				$headBlock->setDescription($enrollment->getMetaDescription());
			}
			$this->renderLayout();
		}
	}
	/**
	 * enrollments rss list action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function rssAction(){
		if (Mage::helper('enrollments/enrollment')->isRssEnabled()) {
			$this->getResponse()->setHeader('Content-type', 'text/xml; charset=UTF-8');
			$this->loadLayout(false);
			$this->renderLayout();
		}
		else {
			$this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
			$this->getResponse()->setHeader('Status','404 File not found');
			$this->_forward('nofeed','index','rss');
		}
	} 
}