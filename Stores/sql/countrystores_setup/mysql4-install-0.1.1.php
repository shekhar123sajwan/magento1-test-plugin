<?php
$installer = $this;
$installer->startSetup();
$installer->run("
CREATE TABLE `{$installer->getTable('country_store')}` (
  `country_store_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(100) NOT NULL,
  `store_name_ar` varchar(100) NOT NULL,
  `store_flag` varchar(128) NOT NULL,
  `store_country` varchar(25) NOT NULL,
  `store_currency` varchar(25) NOT NULL,
  `store_en` varchar(25) NOT NULL,
  `store_ar` varchar(25) NOT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `store_status` tinyint NOT NULL,
  `store_iso` varchar(25) NOT NULL,
  `store_currency_ar` varchar(25) NOT NULL,
  `store_currency_en` varchar(25) NOT NULL, 
  'shipping_rate' varchar(32) NOT NULL,
  PRIMARY KEY (`country_store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Country Stores'
");

$installer->endSetup();
