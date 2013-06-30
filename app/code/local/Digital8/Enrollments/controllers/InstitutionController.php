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
 * Institution front contrller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_InstitutionController extends Mage_Core_Controller_Front_Action{
	/**
 	 * default action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
 	public function indexAction(){
		$this->loadLayout();
 		if (Mage::helper('enrollments/institution')->getUseBreadcrumbs()){
			if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
				$breadcrumbBlock->addCrumb('home', array(
							'label'	=> Mage::helper('enrollments')->__('Home'), 
							'link' 	=> Mage::getUrl(),
						)
				);
				$breadcrumbBlock->addCrumb('institutions', array(
							'label'	=> Mage::helper('enrollments')->__('Institutions'), 
							'link'	=> '',
					)
				);
			}
		}
		$headBlock = $this->getLayout()->getBlock('head');
		if ($headBlock) {
			$headBlock->setTitle(Mage::getStoreConfig('enrollments/institution/meta_title'));
			$headBlock->setKeywords(Mage::getStoreConfig('enrollments/institution/meta_keywords'));
			$headBlock->setDescription(Mage::getStoreConfig('enrollments/institution/meta_description'));
		}
		$this->renderLayout();
	}
	/**
 	 * view institution action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
	public function viewAction(){
		$institutionId 	= $this->getRequest()->getParam('id', 0);
		$institution 	= Mage::getModel('enrollments/institution')
						->setStoreId(Mage::app()->getStore()->getId())
						->load($institutionId);
		if (!$institution->getId()){
			$this->_forward('no-route');
		}
		elseif (!$institution->getStatus()){
			$this->_forward('no-route');
		}
		else{
			Mage::register('current_enrollments_institution', $institution);
			$this->loadLayout();
			if ($root = $this->getLayout()->getBlock('root')) {
				$root->addBodyClass('enrollments-institution enrollments-institution' . $institution->getId());
			}
			if (Mage::helper('enrollments/institution')->getUseBreadcrumbs()){
				if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
					$breadcrumbBlock->addCrumb('home', array(
								'label'	=> Mage::helper('enrollments')->__('Home'), 
								'link' 	=> Mage::getUrl(),
							)
					);
					$breadcrumbBlock->addCrumb('institutions', array(
								'label'	=> Mage::helper('enrollments')->__('Institutions'), 
								'link'	=> Mage::helper('enrollments')->getInstitutionsUrl(),
						)
					);
					$breadcrumbBlock->addCrumb('institution', array(
								'label'	=> $institution->getName(), 
								'link'	=> '',
						)
					);
				}
			}
			$headBlock = $this->getLayout()->getBlock('head');
			if ($headBlock) {
				if ($institution->getMetaTitle()){
					$headBlock->setTitle($institution->getMetaTitle());
				}
				else{
					$headBlock->setTitle($institution->getName());
				}
				$headBlock->setKeywords($institution->getMetaKeywords());
				$headBlock->setDescription($institution->getMetaDescription());
			}
			$this->renderLayout();
		}
	}
	/**
	 * institutions rss list action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function rssAction(){
		if (Mage::helper('enrollments/institution')->isRssEnabled()) {
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