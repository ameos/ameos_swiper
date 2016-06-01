<?php

$installer = $this;
$installer->startSetup();

$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('swiper_group')};
	CREATE TABLE {$this->getTable('swiper_group')} (
		`id` int(10) unsigned NOT NULL auto_increment,
		`title` varchar(255) NOT NULL default '',
		PRIMARY KEY  (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('swiper_slide')};
	CREATE TABLE {$this->getTable('swiper_slide')} (
		`id` int(10) unsigned NOT NULL auto_increment,
        `title` varchar(255) NOT NULL default '',
        `group_id` int(10) unsigned NOT NULL default 0,
        `image` varchar(255) NOT NULL default '',
		PRIMARY KEY  (`id`),
        KEY (`group_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();
