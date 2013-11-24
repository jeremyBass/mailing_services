<?php

$installer = $this;
$installer->startSetup();
$table_email_log = $installer->getTable('wsu_mailingservices/log');
$installer->run("
    DROP TABLE IF EXISTS `{$table_email_log}`;
    CREATE TABLE `{$table_email_log}` (
	  `email_id` int(10) unsigned NOT NULL auto_increment,
	  `log_at` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	  `to` varchar(255) NOT NULL default '',
	  `template` varchar(255) NULL,
	  `subject` varchar(255) NULL,
	  `email_body` text NULL,
	  `headers` text NULL,
	  PRIMARY KEY  (`email_id`),
	  KEY `log_at` (`log_at`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
	$connection = $this->getConnection();
	$connection->addColumn($this->getTable('review'), "wsu_mailingservices_order_id","int(11) UNSIGNED DEFAULT 0");
	//$installer->run("ALTER TABLE {$this->getTable('review')} ADD `wsu_mailingservices_order_id` int(11) DEFAULT '0';");
$installer->endSetup();
