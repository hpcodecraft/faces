SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `weight` (`weight`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE `changelog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `posted` int(10) unsigned NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posted` (`posted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE `faces` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `added` int(10) unsigned NOT NULL,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `last_view` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL,
  `category` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `category` (`category`),
  KEY `views` (`views`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE `log_api` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL,
  `ip` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `query` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE `settings` (
  `key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `has_checkbox` tinyint(1) unsigned NOT NULL,
  `description` varchar(1500) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `key` (`key`),
  KEY `has_checkbox` (`has_checkbox`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `tags` (
  `face` int(10) unsigned NOT NULL,
  `tag` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `source` enum('import','view') COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `face-tag` (`face`,`tag`),
  KEY `face` (`face`),
  KEY `tag` (`tag`),
  KEY `source` (`source`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `tag_suggestions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `from_import` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `file` (`file`,`from_import`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

INSERT INTO `categories` VALUES(1, 'other', 1);
INSERT INTO `settings` VALUES('submissions', '1', 1, 'Check if users should be able to submit faces to your site.');
INSERT INTO `settings` VALUES('maintenance', '0', 1, 'Enables maintenance mode. All access to the site will be blocked (except the administration tools, of course)');
INSERT INTO `settings` VALUES('protest', '0', 1, 'Enables protest mode. All access to the site will be blocked. You can create additional protest pages in /views/protest');
INSERT INTO `settings` VALUES('protest type', 'acta', 0, '');
INSERT INTO `settings` VALUES('imprint', '0', 1, 'Enable or disable the sites imprint.');
