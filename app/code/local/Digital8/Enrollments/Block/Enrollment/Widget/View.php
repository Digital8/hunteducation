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
 * Enrollment widget block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Enrollment_Widget_View extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface{
	protected $_htmlTemplate = 'digital8_enrollments/enrollment/widget/view.phtml';
	/**
	 * Prepare a for widget
	 * @access protected
	 * @return Digital8_Enrollments_Block_Enrollment_Widget_View
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml() {
		parent::_beforeToHtml();
		$enrollmentId = $this->getData('enrollment_id');
		if ($enrollmentId) {
			$enrollment = Mage::getModel('enrollments/enrollment')
				->setStoreId(Mage::app()->getStore()->getId())
				->load($enrollmentId);
		if ($enrollment->getStatus()) {
					$this->setCurrentEnrollment($enrollment);
				$this->setTemplate($this->_htmlTemplate);
				}
		}
		return $this;
	}
}