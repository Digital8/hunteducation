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
 * Enrollments RSS block
 *
 * @category	Digital8
 * @package		Digital8_Enrollments
 * @author Ultimate Module Creator
 */
class Digital8_Enrollments_Block_Rss extends Mage_Core_Block_Template{
	protected $_feeds = array();
	/**
	 * add a new feed
	 * @access public
	 * @param string $label
	 * @param string $url
	 * @param bool $prepare
	 * @return Digital8_Enrollments_Block_Rss
	 * @author Ultimate Module Creator
	 */
	public function addFeed($label, $url, $prepare = false){
		$link = ($prepare ? $this->getUrl($url) : $url);
		$feed = new Varien_Object();
		$feed->setLabel($label);
		$feed->setUrl($link);
		$this->_feeds[$link] = $feed;
		return $this;
	}
	/**
	 * get the current feeds
	 * @access public
	 * @return array()
	 * @author Ultimate Module Creator
	 */
	public function getFeeds(){
		return $this->_feeds;
	}
} 