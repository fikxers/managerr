ALTER TABLE `site_settings` ADD `currently_online` INT(11) NOT NULL AFTER `checkout2_accountno`;
ALTER TABLE `site_settings` ADD `resize_avatar` INT(11) NOT NULL AFTER `currently_online`;

CREATE TABLE `user_logs` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `message` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `IP` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;