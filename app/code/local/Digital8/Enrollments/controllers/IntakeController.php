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
 * Intake front contrller
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_IntakeController extends Mage_Core_Controller_Front_Action{
	/**
 	 * default action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
 	public function indexAction(){
		$this->loadLayout();
 		if (Mage::helper('enrollments/intake')->getUseBreadcrumbs()){
			if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
				$breadcrumbBlock->addCrumb('home', array(
							'label'	=> Mage::helper('enrollments')->__('Home'), 
							'link' 	=> Mage::getUrl(),
						)
				);
				$breadcrumbBlock->addCrumb('intakes', array(
							'label'	=> Mage::helper('enrollments')->__('Intakes'), 
							'link'	=> '',
					)
				);
			}
		}
		$headBlock = $this->getLayout()->getBlock('head');
		if ($headBlock) {
			$headBlock->setTitle(Mage::getStoreConfig('enrollments/intake/meta_title'));
			$headBlock->setKeywords(Mage::getStoreConfig('enrollments/intake/meta_keywords'));
			$headBlock->setDescription(Mage::getStoreConfig('enrollments/intake/meta_description'));
		}
		$this->renderLayout();
	}
	/**
 	 * view intake action
 	 * @access public
 	 * @return void
 	 * @author Ultimate Module Creator
 	 */
	public function viewAction(){
		$intakeId 	= $this->getRequest()->getParam('id', 0);
		$intake 	= Mage::getModel('enrollments/intake')
						->setStoreId(Mage::app()->getStore()->getId())
						->load($intakeId);
		if (!$intake->getId()){
			$this->_forward('no-route');
		}
		elseif (!$intake->getStatus()){
			$this->_forward('no-route');
		}
		else{
			Mage::register('current_enrollments_intake', $intake);
			$this->loadLayout();
			if ($root = $this->getLayout()->getBlock('root')) {
				$root->addBodyClass('enrollments-intake enrollments-intake' . $intake->getId());
			}
			if (Mage::helper('enrollments/intake')->getUseBreadcrumbs()){
				if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
					$breadcrumbBlock->addCrumb('home', array(
								'label'	=> Mage::helper('enrollments')->__('Home'), 
								'link' 	=> Mage::getUrl(),
							)
					);
					$breadcrumbBlock->addCrumb('intakes', array(
								'label'	=> Mage::helper('enrollments')->__('Intakes'), 
								'link'	=> Mage::helper('enrollments')->getIntakesUrl(),
						)
					);
					$breadcrumbBlock->addCrumb('intake', array(
								'label'	=> $intake->getName(), 
								'link'	=> '',
						)
					);
				}
			}
			$headBlock = $this->getLayout()->getBlock('head');
			if ($headBlock) {
				if ($intake->getMetaTitle()){
					$headBlock->setTitle($intake->getMetaTitle());
				}
				else{
					$headBlock->setTitle($intake->getName());
				}
				$headBlock->setKeywords($intake->getMetaKeywords());
				$headBlock->setDescription($intake->getMetaDescription());
			}
			$this->renderLayout();
		}
	}
	/**
	 * intakes rss list action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function rssAction(){
		if (Mage::helper('enrollments/intake')->isRssEnabled()) {
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