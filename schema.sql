CREATE TABLE `zk_smiley` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `survey_created_at` datetime DEFAULT NULL,
  `survey_updated_at` datetime DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `survey_rating` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;