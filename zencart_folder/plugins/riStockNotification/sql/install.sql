CREATE TABLE IF NOT EXISTS `stock_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL,
  `objects_id` int(11) NOT NULL,
  `notifications_type` int(11) NOT NULL,
  `conditions_type` int(11) NOT NULL,
  `conditions_value` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_id` (`customers_id`,`objects_id`,`notifications_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;