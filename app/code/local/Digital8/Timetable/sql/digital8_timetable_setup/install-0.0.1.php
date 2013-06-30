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
 * Timetable module install script
 *
 * @category	Digital8
 * @package		Digital8_Timetable
 * @author Ultimate Module Creator
 */
$this->startSetup();
$table = $this->getConnection()
	->newTable($this->getTable('timetable/intake'))
	->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Intake ID')
	->addColumn('location_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'unsigned'  => true,
		), 'Location')

	->addColumn('date', Varien_Db_Ddl_Table::TYPE_DATETIME, 255, array(
		'nullable'  => false,
		), 'Date')

	->addColumn('enrolled', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'nullable'  => false,
		'unsigned'  => true,
		), 'Enrolled')

	->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'Name')

	->addColumn('url_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'URL key')

	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		), 'Status')

	->addColumn('in_rss', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		), 'In RSS')

	->addColumn('meta_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Meta title')

	->addColumn('meta_keywords', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Meta keywords')

	->addColumn('meta_description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Meta description')

	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Intake Creation Time')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Intake Modification Time')
	->addIndex($this->getIdxName('timetable/location', array('location_id')), array('location_id'))
	->setComment('Intake Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
	->newTable($this->getTable('timetable/intake_store'))
	->addColumn('intake_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'nullable'  => false,
		'primary'   => true,
		), 'Intake ID')
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'unsigned'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Store ID')
	->addIndex($this->getIdxName('timetable/intake_store', array('store_id')), array('store_id'))
	->addForeignKey($this->getFkName('timetable/intake_store', 'intake_id', 'timetable/intake', 'entity_id'), 'intake_id', $this->getTable('timetable/intake'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->addForeignKey($this->getFkName('timetable/intake_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->setComment('Intakes To Store Linkage Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
	->newTable($this->getTable('timetable/location'))
	->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Location ID')
	->addColumn('suburb', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'Suburb')

	->addColumn('state', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'State')

	->addColumn('address', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'Address')

	->addColumn('googlemaps', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'Google Maps')

	->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'Name')

	->addColumn('url_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'URL key')

	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		), 'Status')

	->addColumn('in_rss', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		), 'In RSS')

	->addColumn('meta_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Meta title')

	->addColumn('meta_keywords', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Meta keywords')

	->addColumn('meta_description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Meta description')

	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Location Creation Time')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Location Modification Time')
	->setComment('Location Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
	->newTable($this->getTable('timetable/location_store'))
	->addColumn('location_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'nullable'  => false,
		'primary'   => true,
		), 'Location ID')
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'unsigned'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Store ID')
	->addIndex($this->getIdxName('timetable/location_store', array('store_id')), array('store_id'))
	->addForeignKey($this->getFkName('timetable/location_store', 'location_id', 'timetable/location', 'entity_id'), 'location_id', $this->getTable('timetable/location'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->addForeignKey($this->getFkName('timetable/location_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->setComment('Locations To Store Linkage Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
	->newTable($this->getTable('timetable/enrolment'))
	->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Enrolment ID')
	->addColumn('intake_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'unsigned'  => true,
		), 'Intake')

	->addColumn('uuid', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'uuid')

	->addColumn('xml', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		'nullable'  => false,
		), 'xml')

	->addColumn('approved', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'nullable'  => false,
		), 'approved')

	->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'email')

	->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		'nullable'  => false,
		), 'name')

	->addColumn('url_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'URL key')

	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		), 'Status')

	->addColumn('in_rss', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		), 'In RSS')

	->addColumn('meta_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Meta title')

	->addColumn('meta_keywords', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Meta keywords')

	->addColumn('meta_description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Meta description')

	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Enrolment Creation Time')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Enrolment Modification Time')
	->addIndex($this->getIdxName('timetable/intake', array('intake_id')), array('intake_id'))
	->setComment('Enrolment Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
	->newTable($this->getTable('timetable/enrolment_store'))
	->addColumn('enrolment_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'nullable'  => false,
		'primary'   => true,
		), 'Enrolment ID')
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'unsigned'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Store ID')
	->addIndex($this->getIdxName('timetable/enrolment_store', array('store_id')), array('store_id'))
	->addForeignKey($this->getFkName('timetable/enrolment_store', 'enrolment_id', 'timetable/enrolment', 'entity_id'), 'enrolment_id', $this->getTable('timetable/enrolment'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->addForeignKey($this->getFkName('timetable/enrolment_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->setComment('Enrolments To Store Linkage Table');
$this->getConnection()->createTable($table);
$this->endSetup();