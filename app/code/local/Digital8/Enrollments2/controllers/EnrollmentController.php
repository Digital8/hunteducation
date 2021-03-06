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
 * Enrollment front contrller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_EnrollmentController extends Mage_Core_Controller_Front_Action{
	/**
 	 * default action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
 	public function indexAction(){
		$this->loadLayout();
 		if (Mage::helper('enrollments2/enrollment')->getUseBreadcrumbs()){
			if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
				$breadcrumbBlock->addCrumb('home', array(
							'label'	=> Mage::helper('enrollments2')->__('Home'), 
							'link' 	=> Mage::getUrl(),
						)
				);
				$breadcrumbBlock->addCrumb('enrollments', array(
							'label'	=> Mage::helper('enrollments2')->__('Enrollments'), 
							'link'	=> '',
					)
				);
			}
		}
		$headBlock = $this->getLayout()->getBlock('head');
		if ($headBlock) {
			$headBlock->setTitle(Mage::getStoreConfig('enrollments2/enrollment/meta_title'));
			$headBlock->setKeywords(Mage::getStoreConfig('enrollments2/enrollment/meta_keywords'));
			$headBlock->setDescription(Mage::getStoreConfig('enrollments2/enrollment/meta_description'));
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
		$enrollment 	= Mage::getModel('enrollments2/enrollment')
						->setStoreId(Mage::app()->getStore()->getId())
						->load($enrollmentId);
		if (!$enrollment->getId()){
			$this->_forward('no-route');
		}
		elseif (!$enrollment->getStatus()){
			$this->_forward('no-route');
		}
		else{
			Mage::register('current_enrollments2_enrollment', $enrollment);
			$this->loadLayout();
			if ($root = $this->getLayout()->getBlock('root')) {
				$root->addBodyClass('enrollments2-enrollment enrollments2-enrollment' . $enrollment->getId());
			}
			if (Mage::helper('enrollments2/enrollment')->getUseBreadcrumbs()){
				if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
					$breadcrumbBlock->addCrumb('home', array(
								'label'	=> Mage::helper('enrollments2')->__('Home'), 
								'link' 	=> Mage::getUrl(),
							)
					);
					$breadcrumbBlock->addCrumb('enrollments', array(
								'label'	=> Mage::helper('enrollments2')->__('Enrollments'), 
								'link'	=> Mage::helper('enrollments2')->getEnrollmentsUrl(),
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
		if (Mage::helper('enrollments2/enrollment')->isRssEnabled()) {
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