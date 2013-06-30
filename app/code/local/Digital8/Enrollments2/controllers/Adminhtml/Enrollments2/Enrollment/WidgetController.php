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
 * Enrollment admin widget controller
 * 
 * @category	Digital8
 * @package		Digital8_Enrollments2
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments2_Adminhtml_Enrollments2_Enrollment_WidgetController extends Mage_Adminhtml_Controller_Action{
	/**
	 * Chooser Source action
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function chooserAction(){
		$uniqId = $this->getRequest()->getParam('uniq_id');
		$grid = $this->getLayout()->createBlock('enrollments2/adminhtml_enrollment_widget_chooser', '', array(
			'id' => $uniqId,
		));
		$this->getResponse()->setBody($grid->toHtml());
	}
}