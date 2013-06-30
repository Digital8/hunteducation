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
 * Location front contrller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_LocationController extends Mage_Core_Controller_Front_Action{
	/**
 	 * default action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
 	public function indexAction(){
		$this->loadLayout();
 		if (Mage::helper('enrollments2/location')->getUseBreadcrumbs()){
			if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
				$breadcrumbBlock->addCrumb('home', array(
							'label'	=> Mage::helper('enrollments2')->__('Home'), 
							'link' 	=> Mage::getUrl(),
						)
				);
				$breadcrumbBlock->addCrumb('locations', array(
							'label'	=> Mage::helper('enrollments2')->__('Locations'), 
							'link'	=> '',
					)
				);
			}
		}
		$headBlock = $this->getLayout()->getBlock('head');
		if ($headBlock) {
			$headBlock->setTitle(Mage::getStoreConfig('enrollments2/location/meta_title'));
			$headBlock->setKeywords(Mage::getStoreConfig('enrollments2/location/meta_keywords'));
			$headBlock->setDescription(Mage::getStoreConfig('enrollments2/location/meta_description'));
		}
		$this->renderLayout();
	}
	/**
 	 * view location action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
	public function viewAction(){
		$locationId 	= $this->getRequest()->getParam('id', 0);
		$location 	= Mage::getModel('enrollments2/location')
						->setStoreId(Mage::app()->getStore()->getId())
						->load($locationId);
		if (!$location->getId()){
			$this->_forward('no-route');
		}
		elseif (!$location->getStatus()){
			$this->_forward('no-route');
		}
		else{
			Mage::register('current_enrollments2_location', $location);
			$this->loadLayout();
			if ($root = $this->getLayout()->getBlock('root')) {
				$root->addBodyClass('enrollments2-location enrollments2-location' . $location->getId());
			}
			if (Mage::helper('enrollments2/location')->getUseBreadcrumbs()){
				if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
					$breadcrumbBlock->addCrumb('home', array(
								'label'	=> Mage::helper('enrollments2')->__('Home'), 
								'link' 	=> Mage::getUrl(),
							)
					);
					$breadcrumbBlock->addCrumb('locations', array(
								'label'	=> Mage::helper('enrollments2')->__('Locations'), 
								'link'	=> Mage::helper('enrollments2')->getLocationsUrl(),
						)
					);
					$breadcrumbBlock->addCrumb('location', array(
								'label'	=> $location->getName(), 
								'link'	=> '',
						)
					);
				}
			}
			$headBlock = $this->getLayout()->getBlock('head');
			if ($headBlock) {
				if ($location->getMetaTitle()){
					$headBlock->setTitle($location->getMetaTitle());
				}
				else{
					$headBlock->setTitle($location->getName());
				}
				$headBlock->setKeywords($location->getMetaKeywords());
				$headBlock->setDescription($location->getMetaDescription());
			}
			$this->renderLayout();
		}
	}
	/**
	 * locations rss list action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function rssAction(){
		if (Mage::helper('enrollments2/location')->isRssEnabled()) {
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