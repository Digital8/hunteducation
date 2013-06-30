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
 * Enrolment widget block
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Block_Enrolment_Widget_View extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface{
	protected $_htmlTemplate = 'digital8_timetable/enrolment/widget/view.phtml';
	/**
	 * Prepare a for widget
	 * @access protected
	 * @return Digital8_Timetable_Block_Enrolment_Widget_View
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml() {
		parent::_beforeToHtml();
		$enrolmentId = $this->getData('enrolment_id');
		if ($enrolmentId) {
			$enrolment = Mage::getModel('timetable/enrolment')
				->setStoreId(Mage::app()->getStore()->getId())
				->load($enrolmentId);
		if ($enrolment->getStatus()) {
					$this->setCurrentEnrolment($enrolment);
				$this->setTemplate($this->_htmlTemplate);
				}
		}
		return $this;
	}
}