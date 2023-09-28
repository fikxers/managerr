-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 30, 2019 at 02:01 PM
-- Server version: 5.5.62-0+deb8u1
-- PHP Version: 7.0.33-1~dotdeb+8.1

--
-- Database: `dev_prologin`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `options` varchar(2000) NOT NULL,
  `required` int(11) NOT NULL,
  `profile` int(11) NOT NULL,
  `edit` int(11) NOT NULL,
  `help_text` varchar(500) NOT NULL,
  `register` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `ID` int(11) NOT NULL,
  `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `hook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`ID`, `title`, `message`, `hook`, `language`, `name`) VALUES
(1, 'Forgot Your Password', '<p>Dear [NAME],<br />\r\n<br />\r\nSomeone (hopefully you) requested a password reset at [SITE_URL].<br />\r\n<br />\r\nTo reset your password, please follow the following link: [EMAIL_LINK]<br />\r\n<br />\r\nIf you did not reset your password, please kindly ignore this email.<br />\r\n<br />\r\nYours,<br />\r\n[SITE_NAME]</p>\r\n', 'forgot_password', 'english', 'Forgot Your Password'),
(2, 'Activate Your Account!', '<p>Dear [NAME],<br />\r\n<br />\r\nSomeone (hopefully you) has registered an account on [SITE_NAME] using this email address.<br />\r\n<br />\r\nPlease activate the account by following this link: [EMAIL_LINK]<br />\r\n<br />\r\nIf you did not register an account, please kindly ignore this email.<br />\r\n<br />\r\nYours,<br />\r\n[SITE_NAME]</p>\r\n', 'email_activation', 'english', 'Activate Your Account!'),
(3, 'Thanks for registering!', 'Dear [NAME],\r\n\r\nThank you for registering at [SITE_URL]. \r\n\r\nYou can now login with your username: [USERNAME] or Email: [EMAIL] and the password you created at registration.\r\n\r\nThank you,\r\n[SITE_NAME]', 'welcome_email', 'english', 'Welcome Email'),
(4, 'Member Invite', 'Dear [EMAIL],<br /><br />\r\n\r\nYou have been invited to register at our site: <a href="[SITE_URL]">[SITE_URl]</a>.<br /><br />\r\n\r\nPlease click the link above, or copy and paste it into your browser to register an account.<br /><br />\r\n\r\nThanks,<br />\r\n[SITE_NAME]', 'member_invite', 'english', 'Member Invite');

-- --------------------------------------------------------

--
-- Table structure for table `home_stats`
--

CREATE TABLE `home_stats` (
  `ID` int(11) NOT NULL,
  `google_members` int(11) NOT NULL DEFAULT '0',
  `facebook_members` int(11) NOT NULL DEFAULT '0',
  `twitter_members` int(11) NOT NULL DEFAULT '0',
  `total_members` int(11) NOT NULL DEFAULT '0',
  `new_members` int(11) NOT NULL DEFAULT '0',
  `active_today` int(11) NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `home_stats`
--

INSERT INTO `home_stats` (`ID`, `google_members`, `facebook_members`, `twitter_members`, `total_members`, `new_members`, `active_today`, `timestamp`) VALUES
(1, 0, 0, 0, 1, 1, 1, 1556620080);

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE `invites` (
  `ID` int(11) NOT NULL,
  `email` varchar(500) NOT NULL,
  `code` varchar(255) NOT NULL,
  `expires` int(11) NOT NULL,
  `expire_upon_use` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `user_registered` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `bypass_register` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ipn_log`
--

CREATE TABLE `ipn_log` (
  `ID` int(11) NOT NULL,
  `data` text,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `IP` varchar(500) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_block`
--

CREATE TABLE `ip_block` (
  `ID` int(11) NOT NULL,
  `IP` varchar(500) NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `reason` varchar(1000) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `ID` int(11) NOT NULL,
  `IP` varchar(500) NOT NULL DEFAULT '',
  `username` varchar(500) NOT NULL DEFAULT '',
  `count` int(11) NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `IP` varchar(500) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `email` varchar(500) NOT NULL DEFAULT '',
  `processor` varchar(255) NOT NULL,
  `hash` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_plans`
--

CREATE TABLE `payment_plans` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `hexcolor` varchar(6) NOT NULL DEFAULT '',
  `fontcolor` varchar(6) NOT NULL DEFAULT '',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `days` int(11) NOT NULL DEFAULT '0',
  `sales` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_plans`
--

INSERT INTO `payment_plans` (`ID`, `name`, `hexcolor`, `fontcolor`, `cost`, `days`, `sales`, `description`, `icon`) VALUES
(2, 'BASIC', '65E0EB', 'FFFFFF', '3.00', 30, 8, 'This is the basic plan which gives you a introduction to our Premium Plans', 'glyphicon glyphicon-heart-empty'),
(3, 'Professional', '55CD7B', 'FFFFFF', '7.99', 90, 3, 'Get all the benefits of basic at a cheaper price and gain content for longer.', 'glyphicon glyphicon-piggy-bank'),
(4, 'LIFETIME', 'EE5782', 'FFFFFF', '300.00', 0, 1, 'Become a premium member for life and have access to all our premium content.', 'glyphicon glyphicon-gift');

-- --------------------------------------------------------

--
-- Table structure for table `profile_comments`
--

CREATE TABLE `profile_comments` (
  `ID` int(11) NOT NULL,
  `profileid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reset_log`
--

CREATE TABLE `reset_log` (
  `ID` int(11) NOT NULL,
  `IP` varchar(500) NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `site_layouts`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `ID` int(11) NOT NULL,
  `site_name` varchar(500) NOT NULL,
  `site_desc` varchar(500) NOT NULL,
  `upload_path` varchar(500) NOT NULL,
  `upload_path_relative` varchar(500) NOT NULL,
  `site_email` varchar(500) NOT NULL,
  `site_logo` varchar(1000) NOT NULL DEFAULT 'logo.png',
  `register` int(11) NOT NULL,
  `disable_captcha` int(11) NOT NULL,
  `date_format` varchar(25) NOT NULL,
  `avatar_upload` int(11) NOT NULL DEFAULT '1',
  `file_types` varchar(500) NOT NULL,
  `twitter_consumer_key` varchar(255) NOT NULL,
  `twitter_consumer_secret` varchar(255) NOT NULL,
  `disable_social_login` int(11) NOT NULL,
  `facebook_app_id` varchar(255) NOT NULL,
  `facebook_app_secret` varchar(255) NOT NULL,
  `google_client_id` varchar(255) NOT NULL,
  `google_client_secret` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `paypal_email` varchar(1000) NOT NULL,
  `paypal_currency` varchar(100) NOT NULL DEFAULT 'USD',
  `payment_enabled` int(11) NOT NULL,
  `payment_symbol` varchar(5) NOT NULL DEFAULT '$',
  `global_premium` int(11) NOT NULL,
  `install` int(11) NOT NULL DEFAULT '1',
  `login_protect` int(11) NOT NULL,
  `activate_account` int(11) NOT NULL,
  `default_user_role` int(11) NOT NULL,
  `secure_login` int(11) NOT NULL,
  `stripe_secret_key` varchar(1000) NOT NULL,
  `stripe_publish_key` varchar(1000) NOT NULL,
  `google_recaptcha` int(11) NOT NULL,
  `google_recaptcha_secret` varchar(255) NOT NULL,
  `google_recaptcha_key` varchar(255) NOT NULL,
  `logo_option` int(11) NOT NULL,
  `layout` varchar(500) NOT NULL,
  `profile_comments` int(11) NOT NULL,
  `avatar_width` int(11) NOT NULL,
  `avatar_height` int(11) NOT NULL,
  `cache_time` int(11) NOT NULL,
  `checkout2_secret` varchar(255) NOT NULL,
  `checkout2_accountno` varchar(255) NOT NULL,
  `currently_online` int(11) NOT NULL,
  `resize_avatar` int(11) NOT NULL,
  `cookie_option` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`ID`, `site_name`, `site_desc`, `upload_path`, `upload_path_relative`, `site_email`, `site_logo`, `register`, `disable_captcha`, `date_format`, `avatar_upload`, `file_types`, `twitter_consumer_key`, `twitter_consumer_secret`, `disable_social_login`, `facebook_app_id`, `facebook_app_secret`, `google_client_id`, `google_client_secret`, `file_size`, `paypal_email`, `paypal_currency`, `payment_enabled`, `payment_symbol`, `global_premium`, `install`, `login_protect`, `activate_account`, `default_user_role`, `secure_login`, `stripe_secret_key`, `stripe_publish_key`, `google_recaptcha`, `google_recaptcha_secret`, `google_recaptcha_key`, `logo_option`, `layout`, `profile_comments`, `avatar_width`, `avatar_height`, `cache_time`, `checkout2_secret`, `checkout2_accountno`, `currently_online`, `resize_avatar`, `cookie_option`) VALUES
(1, 'ProLogin', 'Welcome to ProLogin', '/var/www/sites/uploads', 'uploads', 'test@test.com', 'logo.png', 0, 0, 'd/m/Y', 1, 'gif|png|jpg|jpeg', '', '', 0, '', '', '', '', 1028, '', 'USD', 1, '$', 0, 0, 1, 0, 5, 1, '', '', 0, '', '', 0, 'layout/themes/titan_layout.php', 1, 80, 80, 3600, '', '', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `token` varchar(255) NOT NULL DEFAULT '',
  `IP` varchar(500) NOT NULL DEFAULT '',
  `username` varchar(25) NOT NULL DEFAULT '',
  `first_name` varchar(25) NOT NULL DEFAULT '',
  `last_name` varchar(25) NOT NULL DEFAULT '',
  `avatar` varchar(1000) NOT NULL DEFAULT 'default.png',
  `joined` int(11) NOT NULL DEFAULT '0',
  `joined_date` varchar(10) NOT NULL DEFAULT '',
  `online_timestamp` int(11) NOT NULL DEFAULT '0',
  `oauth_provider` varchar(40) NOT NULL DEFAULT '',
  `oauth_id` varchar(1000) NOT NULL DEFAULT '',
  `oauth_token` varchar(1500) NOT NULL DEFAULT '',
  `oauth_secret` varchar(500) NOT NULL DEFAULT '',
  `email_notification` int(11) NOT NULL DEFAULT '1',
  `aboutme` varchar(1000) NOT NULL DEFAULT '',
  `points` decimal(10,2) NOT NULL DEFAULT '0.00',
  `premium_time` int(11) NOT NULL DEFAULT '0',
  `user_role` int(11) NOT NULL DEFAULT '0',
  `premium_planid` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `activate_code` varchar(255) NOT NULL DEFAULT '',
  `profile_comments` int(11) NOT NULL DEFAULT '1',
  `profile_views` int(11) NOT NULL DEFAULT '0',
  `address_1` varchar(255) NOT NULL DEFAULT '',
  `address_2` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(255) NOT NULL DEFAULT '',
  `zipcode` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(255) NOT NULL DEFAULT '',
  `noti_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_custom_fields`
--

CREATE TABLE `user_custom_fields` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `fieldid` int(11) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `twitter` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `google` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_events`
--

CREATE TABLE `user_events` (
  `ID` int(11) NOT NULL,
  `IP` varchar(255) NOT NULL DEFAULT '',
  `event` varchar(255) NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `ID` int(11) NOT NULL,
  `name` varchar(40) NOT NULL DEFAULT '',
  `default` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`ID`, `name`, `default`) VALUES
(1, 'Default Group', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_group_users`
--

CREATE TABLE `user_group_users` (
  `ID` int(11) NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `message` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `IP` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `url` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `message` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `fromid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `admin` int(11) NOT NULL DEFAULT '0',
  `admin_settings` int(11) NOT NULL DEFAULT '0',
  `admin_members` int(11) NOT NULL DEFAULT '0',
  `admin_payment` int(11) NOT NULL DEFAULT '0',
  `banned` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`ID`, `name`, `admin`, `admin_settings`, `admin_members`, `admin_payment`, `banned`) VALUES
(1, 'Admin', 1, 0, 0, 0, 0),
(2, 'Member Manager', 0, 0, 1, 0, 0),
(3, 'Admin Settings', 0, 1, 0, 0, 0),
(4, 'Admin Payments', 0, 0, 0, 1, 0),
(5, 'Member', 0, 0, 0, 0, 0),
(6, 'Banned', 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role_permissions`
--

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
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `home_stats`
--
ALTER TABLE `home_stats`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `invites`
--
ALTER TABLE `invites`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ipn_log`
--
ALTER TABLE `ipn_log`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ip_block`
--
ALTER TABLE `ip_block`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `payment_plans`
--
ALTER TABLE `payment_plans`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `profile_comments`
--
ALTER TABLE `profile_comments`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `reset_log`
--
ALTER TABLE `reset_log`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `site_layouts`
--
ALTER TABLE `site_layouts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_custom_fields`
--
ALTER TABLE `user_custom_fields`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_events`
--
ALTER TABLE `user_events`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_group_users`
--
ALTER TABLE `user_group_users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_role_permissions`
--
ALTER TABLE `user_role_permissions`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `home_stats`
--
ALTER TABLE `home_stats`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `invites`
--
ALTER TABLE `invites`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ipn_log`
--
ALTER TABLE `ipn_log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ip_block`
--
ALTER TABLE `ip_block`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_plans`
--
ALTER TABLE `payment_plans`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `profile_comments`
--
ALTER TABLE `profile_comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reset_log`
--
ALTER TABLE `reset_log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `site_layouts`
--
ALTER TABLE `site_layouts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_custom_fields`
--
ALTER TABLE `user_custom_fields`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_events`
--
ALTER TABLE `user_events`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_group_users`
--
ALTER TABLE `user_group_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_role_permissions`
--
ALTER TABLE `user_role_permissions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
