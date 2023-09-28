CREATE TABLE `user_role_permissions` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `classname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hook` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_role_permissions`
--

INSERT INTO `user_role_permissions` (`ID`, `name`, `description`, `classname`, `hook`) VALUES
(1, 'ctn_308', 'ctn_308', 'admin', 'admin'),
(2, 'ctn_309', 'ctn_309', 'admin', 'admin_settings'),
(3, 'ctn_310', 'ctn_310', 'admin', 'admin_members'),
(4, 'ctn_311', 'ctn_311', 'admin', 'admin_payment'),
(5, 'ctn_33', 'ctn_33', 'banned', 'banned');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_role_permissions`
--
ALTER TABLE `user_role_permissions`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_role_permissions`
--
ALTER TABLE `user_role_permissions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

DROP TABLE `site_layouts`;

CREATE TABLE `site_layouts` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `layout_path` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `site_layouts`
--

INSERT INTO `site_layouts` (`ID`, `name`, `layout_path`) VALUES
(1, 'Basic', 'layout/themes/layout.php'),
(2, 'Titan', 'layout/themes/titan_layout.php'),
(3, 'Dark Fire', 'layout/themes/dark_fire_layout.php'),
(4, 'Light Blue', 'layout/themes/light_blue_layout.php');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `site_layouts`
--
ALTER TABLE `site_layouts`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `site_layouts`
--
ALTER TABLE `site_layouts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

DROP TABLE `email_templates`;

CREATE TABLE `email_templates` (
  `ID` int(11) NOT NULL,
  `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `hook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`ID`, `title`, `message`, `hook`, `language`) VALUES
(1, 'Forgot Your Password', '<p>Dear [NAME],<br />\r\n<br />\r\nSomeone (hopefully you) requested a password reset at [SITE_URL].<br />\r\n<br />\r\nTo reset your password, please follow the following link: [EMAIL_LINK]<br />\r\n<br />\r\nIf you did not reset your password, please kindly ignore this email.<br />\r\n<br />\r\nYours,<br />\r\n[SITE_NAME]</p>\r\n', 'forgot_password', 'english'),
(2, 'Email Activation', '<p>Dear [NAME],<br />\r\n<br />\r\nSomeone (hopefully you) has registered an account on [SITE_NAME] using this email address.<br />\r\n<br />\r\nPlease activate the account by following this link: [EMAIL_LINK]<br />\r\n<br />\r\nIf you did not register an account, please kindly ignore this email.<br />\r\n<br />\r\nYours,<br />\r\n[SITE_NAME]</p>\r\n', 'email_activation', 'english');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

  CREATE TABLE `user_data` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `twitter` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `google` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

  CREATE TABLE `profile_comments` (
  `ID` int(11) NOT NULL,
  `profileid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profile_comments`
--
ALTER TABLE `profile_comments`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profile_comments`
--
ALTER TABLE `profile_comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

  CREATE TABLE `user_notifications` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `url` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `message` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `fromid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

  ALTER TABLE `site_settings` ADD `profile_comments` INT(11) NOT NULL AFTER `layout`;

ALTER TABLE `users` ADD `profile_comments` INT(11) NOT NULL DEFAULT '1' AFTER `activate_code`;

ALTER TABLE `users` ADD `profile_views` INT(11) NOT NULL AFTER `profile_comments`;

ALTER TABLE `users` ADD `address_1` VARCHAR(255) NOT NULL AFTER `profile_views`, ADD `address_2` VARCHAR(255) NOT NULL AFTER `address_1`, ADD `city` VARCHAR(255) NOT NULL AFTER `address_2`, ADD `state` VARCHAR(255) NOT NULL AFTER `city`;

ALTER TABLE `users` ADD `zipcode` VARCHAR(255) NOT NULL AFTER `state`, ADD `country` VARCHAR(255) NOT NULL AFTER `zipcode`;

ALTER TABLE `users` ADD `noti_count` INT(11) NOT NULL AFTER `country`;

UPDATE `site_settings` SET layout = 'layout/themes/titan_layout.php';

ALTER TABLE `site_settings` ADD `avatar_width` INT(11) NOT NULL AFTER `profile_comments`, ADD `avatar_height` INT(11) NOT NULL AFTER `avatar_width`, ADD `cache_time` INT(11) NOT NULL AFTER `avatar_height`;

ALTER TABLE `site_settings` ADD `checkout2_secret` VARCHAR(255) NOT NULL AFTER `cache_time`, ADD `checkout2_accountno` VARCHAR(255) NOT NULL AFTER `checkout2_secret`;

ALTER TABLE `payment_logs` ADD `hash` VARCHAR(500) NOT NULL AFTER `processor`;

CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);