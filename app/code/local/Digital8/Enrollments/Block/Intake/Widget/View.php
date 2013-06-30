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
 * Intake widget block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Intake_Widget_View extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface{
	protected $_htmlTemplate = 'digital8_enrollments/intake/widget/view.phtml';
	/**
	 * Prepare a for widget
	 * @access protected
	 * @return Digital8_Enrollments_Block_Intake_Widget_View
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml() {
		parent::_beforeToHtml();
		$intakeId = $this->getData('intake_id');
		if ($intakeId) {
			$intake = Mage::getModel('enrollments/intake')
				->setStoreId(Mage::app()->getStore()->getId())
				->load($intakeId);
		if ($intake->getStatus()) {
					$this->setCurrentIntake($intake);
				$this->setTemplate($this->_htmlTemplate);
				}
		}
		return $this;
	}
}