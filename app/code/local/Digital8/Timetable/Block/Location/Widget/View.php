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
 * Location widget block
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Block_Location_Widget_View extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface{
	protected $_htmlTemplate = 'digital8_timetable/location/widget/view.phtml';
	/**
	 * Prepare a for widget
	 * @access protected
	 * @return Digital8_Timetable_Block_Location_Widget_View
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml() {
		parent::_beforeToHtml();
		$locationId = $this->getData('location_id');
		if ($locationId) {
			$location = Mage::getModel('timetable/location')
				->setStoreId(Mage::app()->getStore()->getId())
				->load($locationId);
		if ($location->getStatus()) {
					$this->setCurrentLocation($location);
				$this->setTemplate($this->_htmlTemplate);
				}
		}
		return $this;
	}
}