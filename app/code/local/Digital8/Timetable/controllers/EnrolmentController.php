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
 * Enrolment front contrller
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_EnrolmentController extends Mage_Core_Controller_Front_Action{
	/**
 	 * default action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
 	public function indexAction(){
		$this->loadLayout();
 		if (Mage::helper('timetable/enrolment')->getUseBreadcrumbs()){
			if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
				$breadcrumbBlock->addCrumb('home', array(
							'label'	=> Mage::helper('timetable')->__('Home'), 
							'link' 	=> Mage::getUrl(),
						)
				);
				$breadcrumbBlock->addCrumb('enrolments', array(
							'label'	=> Mage::helper('timetable')->__('Enrolments'), 
							'link'	=> '',
					)
				);
			}
		}
		$headBlock = $this->getLayout()->getBlock('head');
		if ($headBlock) {
			$headBlock->setTitle(Mage::getStoreConfig('timetable/enrolment/meta_title'));
			$headBlock->setKeywords(Mage::getStoreConfig('timetable/enrolment/meta_keywords'));
			$headBlock->setDescription(Mage::getStoreConfig('timetable/enrolment/meta_description'));
		}
		$this->renderLayout();
	}
	/**
 	 * view enrolment action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
	public function viewAction(){
		$enrolmentId 	= $this->getRequest()->getParam('id', 0);
		$enrolment 	= Mage::getModel('timetable/enrolment')
						->setStoreId(Mage::app()->getStore()->getId())
						->load($enrolmentId);
		if (!$enrolment->getId()){
			$this->_forward('no-route');
		}
		elseif (!$enrolment->getStatus()){
			$this->_forward('no-route');
		}
		else{
			Mage::register('current_timetable_enrolment', $enrolment);
			$this->loadLayout();
			if ($root = $this->getLayout()->getBlock('root')) {
				$root->addBodyClass('timetable-enrolment timetable-enrolment' . $enrolment->getId());
			}
			if (Mage::helper('timetable/enrolment')->getUseBreadcrumbs()){
				if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
					$breadcrumbBlock->addCrumb('home', array(
								'label'	=> Mage::helper('timetable')->__('Home'), 
								'link' 	=> Mage::getUrl(),
							)
					);
					$breadcrumbBlock->addCrumb('enrolments', array(
								'label'	=> Mage::helper('timetable')->__('Enrolments'), 
								'link'	=> Mage::helper('timetable')->getEnrolmentsUrl(),
						)
					);
					$breadcrumbBlock->addCrumb('enrolment', array(
								'label'	=> $enrolment->getName(), 
								'link'	=> '',
						)
					);
				}
			}
			$headBlock = $this->getLayout()->getBlock('head');
			if ($headBlock) {
				if ($enrolment->getMetaTitle()){
					$headBlock->setTitle($enrolment->getMetaTitle());
				}
				else{
					$headBlock->setTitle($enrolment->getName());
				}
				$headBlock->setKeywords($enrolment->getMetaKeywords());
				$headBlock->setDescription($enrolment->getMetaDescription());
			}
			$this->renderLayout();
		}
	}
	/**
	 * enrolments rss list action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function rssAction(){
		if (Mage::helper('timetable/enrolment')->isRssEnabled()) {
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