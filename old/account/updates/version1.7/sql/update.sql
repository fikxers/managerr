ALTER TABLE `site_settings` ADD `google_recaptcha` INT(11) NOT NULL AFTER `stripe_publish_key`, ADD `google_recaptcha_secret` VARCHAR(255) NOT NULL AFTER `google_recaptcha`, ADD `google_recaptcha_key` VARCHAR(255) NOT NULL AFTER `google_recaptcha_secret`;

ALTER TABLE `site_settings` ADD `logo_option` INT(11) NOT NULL AFTER `google_recaptcha_key`;

CREATE TABLE `site_layouts` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `layout_path` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_layouts`
--

INSERT INTO `site_layouts` (`ID`, `name`, `layout_path`) VALUES
(1, 'Basic', 'layout/layout.php'),
(2, 'Titan', 'layout/titan_layout.php');

ALTER TABLE `site_layouts`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `site_settings` ADD `layout` VARCHAR(500) NOT NULL AFTER `logo_option`;

UPDATE site_settings SET layout = 'layout/layout.php' WHERE ID = 1;