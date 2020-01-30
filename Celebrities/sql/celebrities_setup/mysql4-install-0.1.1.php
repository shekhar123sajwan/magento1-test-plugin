<?php
$installer = $this;
$installer->startSetup();
$installer->run("
CREATE TABLE `{$installer->getTable('celebrities')}` (
  `celebrity_id` int(11) NOT NULL AUTO_INCREMENT,
  `celebrity_name` varchar(100) NOT NULL,
  `short_description` varchar(256) NOT NULL,
  `celebrity_image` varchar(128) NOT NULL,
  `celebrity_banner` varchar(128) NOT NULL,
  `celebrity_type` varchar(64) NOT NULL,
  `celebrity_status` tinyint NOT NULL,
  `create_date` datetime DEFAULT NULL,
  `celebrity_slug` varchar(128) NOT NULL,
  PRIMARY KEY (`celebrity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Celebrities'
");

$installer->run("
CREATE TABLE `{$installer->getTable('celebrity_product')}` (
  `celebrity_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `create_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Celebrity Product'
");


$installer->run("
CREATE TABLE `{$installer->getTable('celebrity_data')}` (
   `id` INT NOT NULL AUTO_INCREMENT,
   `celebrity_id` INT NOT NULL,
   `celebrity_name` VARCHAR(255) NULL,
   `short_description` VARCHAR(45) NULL,
   `store_id` INT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Celebrity Data'
");

$installer->endSetup();