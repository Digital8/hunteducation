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
 * Intake admin widget controller
 * 
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Adminhtml_Enrollments_Intake_WidgetController extends Mage_Adminhtml_Controller_Action{
	/**
	 * Chooser Source action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function chooserAction(){
		$uniqId = $this->getRequest()->getParam('uniq_id');
		$grid = $this->getLayout()->createBlock('enrollments/adminhtml_intake_widget_chooser', '', array(
			'id' => $uniqId,
		));
		$this->getResponse()->setBody($grid->toHtml());
	}
}