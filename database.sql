CREATE TABLE IF NOT EXISTS `users` (
  `number` varchar(20) NOT NULL,
  `gcm` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`number`);