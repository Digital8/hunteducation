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
 * Router
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract{
	/**
	 * init routes
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return Digital8_Enrollments_Controller_Router
	 * @author Ultimate Module Creator
	 */
	public function initControllerRouters($observer){
		$front = $observer->getEvent()->getFront();
		$front->addRouter('enrollments', $this);
		return $this;
	}
	/**
	 * Validate and match entities and modify request
	 * @access public
	 * @param Zend_Controller_Request_Http $request
	 * @return bool
	 * @author Ultimate Module Creator
	 */
	public function match(Zend_Controller_Request_Http $request){
		if (!Mage::isInstalled()) {
			Mage::app()->getFrontController()->getResponse()
				->setRedirect(Mage::getUrl('install'))
				->sendResponse();
			exit;
		}
		$urlKey = trim($request->getPathInfo(), '/');
		$check = array();
		$check['intake'] = new Varien_Object(array(
			'model' =>'enrollments/intake',
			'controller' => 'intake',
			'action' => 'view',
			'param'	=> 'id',
		));
		$check['location'] = new Varien_Object(array(
			'model' =>'enrollments/location',
			'controller' => 'location',
			'action' => 'view',
			'param'	=> 'id',
		));
		$check['enrollment'] = new Varien_Object(array(
			'model' =>'enrollments/enrollment',
			'controller' => 'enrollment',
			'action' => 'view',
			'param'	=> 'id',
		));
		foreach ($check as $key=>$settings){
			$model = Mage::getModel($settings->getModel());
			$id = $model->checkUrlKey($urlKey, Mage::app()->getStore()->getId());
			if ($id){
				$request->setModuleName('enrollments')
					->setControllerName($settings->getController())
					->setActionName($settings->getAction())
					->setParam($settings->getParam(), $id);
				$request->setAlias(
					Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
					$urlKey
				);
				return true;
			}
		}
		return false;
	}
}