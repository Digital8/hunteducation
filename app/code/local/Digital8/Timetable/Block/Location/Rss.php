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
 * Location RSS block
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
class Digital8_Timetable_Block_Location_Rss extends Mage_Rss_Block_Abstract{
	/**
	 * Cache tag constant for feed reviews
	 * @var string
	 */
	const CACHE_TAG = 'block_html_timetable_location_rss';
	/**
	 * constructor
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		$this->setCacheTags(array(self::CACHE_TAG));
		/*
		* setting cache to save the rss for 10 minutes
		*/
		$this->setCacheKey('timetable_location_rss');
		$this->setCacheLifetime(600);
	}
	/**
	 * toHtml method
	 * @access protected
	 * @return string
	 * @author Ultimate Module Creator
	 */
	protected function _toHtml(){
		$url = Mage::helper('timetable')->getLocationsUrl();
		$title = Mage::helper('timetable')->__('Locations');
		$rssObj = Mage::getModel('rss/rss');
		$data = array(
			'title' => $title,
			'description' => $title,
			'link'=> $url,
			'charset' => 'UTF-8',
		);
		$rssObj->_addHeader($data);
		$collection = Mage::getModel('timetable/location')->getCollection()
			->addStoreFilter(Mage::app()->getStore())

			->addFilter('status', 1)
			->addFilter('in_rss', 1)
			->setOrder('created_at');
		$collection->load();
		foreach ($collection as $item){
			$description = '<p>';
			$description .= '</p>';
			$data = array(
				'title'=>$item->getName(),
				'link'=>$item->getLocationUrl(),
				'description' => $description
			);
			$rssObj->_addEntry($data);
		}
		return $rssObj->createRssXml();
	}
}