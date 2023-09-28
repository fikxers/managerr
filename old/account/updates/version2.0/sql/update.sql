
ALTER TABLE `email_templates` ADD `name` VARCHAR(255) NOT NULL AFTER `language`;
INSERT INTO `email_templates` (`ID`, `title`, `message`, `hook`, `language`, `name`) VALUES (NULL, 'Thanks for registering!', 'Dear [NAME], Thank you for registering at [SITE_URL]. You can now login with your username: [USERNAME] or Email: [EMAIL] and the password you created at registration. Thank you, [SITE_NAME]', 'welcome_email', 'english', 'Welcome Email');
ALTER TABLE `site_settings` ADD `cookie_option` INT(11) NOT NULL AFTER `resize_avatar`;