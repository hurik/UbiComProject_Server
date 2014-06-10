CREATE TABLE IF NOT EXISTS `positions` (
  `number` varchar(20) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `positions`
 ADD PRIMARY KEY (`number`);
 