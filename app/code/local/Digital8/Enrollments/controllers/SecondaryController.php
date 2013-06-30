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
 * Secondary front contrller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_SecondaryController extends Mage_Core_Controller_Front_Action{
	/**
 	 * default action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
 	public function indexAction(){
		$this->loadLayout();
 		if (Mage::helper('enrollments/secondary')->getUseBreadcrumbs()){
			if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
				$breadcrumbBlock->addCrumb('home', array(
							'label'	=> Mage::helper('enrollments')->__('Home'), 
							'link' 	=> Mage::getUrl(),
						)
				);
				$breadcrumbBlock->addCrumb('secondarys', array(
							'label'	=> Mage::helper('enrollments')->__('Secondary'), 
							'link'	=> '',
					)
				);
			}
		}
		$headBlock = $this->getLayout()->getBlock('head');
		if ($headBlock) {
			$headBlock->setTitle(Mage::getStoreConfig('enrollments/secondary/meta_title'));
			$headBlock->setKeywords(Mage::getStoreConfig('enrollments/secondary/meta_keywords'));
			$headBlock->setDescription(Mage::getStoreConfig('enrollments/secondary/meta_description'));
		}
		$this->renderLayout();
	}
	/**
 	 * view secondary action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
	public function viewAction(){
		$secondaryId 	= $this->getRequest()->getParam('id', 0);
		$secondary 	= Mage::getModel('enrollments/secondary')
						->setStoreId(Mage::app()->getStore()->getId())
						->load($secondaryId);
		if (!$secondary->getId()){
			$this->_forward('no-route');
		}
		elseif (!$secondary->getStatus()){
			$this->_forward('no-route');
		}
		else{
			Mage::register('current_enrollments_secondary', $secondary);
			$this->loadLayout();
			if ($root = $this->getLayout()->getBlock('root')) {
				$root->addBodyClass('enrollments-secondary enrollments-secondary' . $secondary->getId());
			}
			if (Mage::helper('enrollments/secondary')->getUseBreadcrumbs()){
				if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
					$breadcrumbBlock->addCrumb('home', array(
								'label'	=> Mage::helper('enrollments')->__('Home'), 
								'link' 	=> Mage::getUrl(),
							)
					);
					$breadcrumbBlock->addCrumb('secondarys', array(
								'label'	=> Mage::helper('enrollments')->__('Secondary'), 
								'link'	=> Mage::helper('enrollments')->getSecondarysUrl(),
						)
					);
					$breadcrumbBlock->addCrumb('secondary', array(
								'label'	=> $secondary->getName(), 
								'link'	=> '',
						)
					);
				}
			}
			$headBlock = $this->getLayout()->getBlock('head');
			if ($headBlock) {
				if ($secondary->getMetaTitle()){
					$headBlock->setTitle($secondary->getMetaTitle());
				}
				else{
					$headBlock->setTitle($secondary->getName());
				}
				$headBlock->setKeywords($secondary->getMetaKeywords());
				$headBlock->setDescription($secondary->getMetaDescription());
			}
			$this->renderLayout();
		}
	}
	/**
	 * secondary rss list action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function rssAction(){
		if (Mage::helper('enrollments/secondary')->isRssEnabled()) {
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