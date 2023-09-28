INSERT INTO `email_templates` (`ID`, `title`, `message`, `hook`, `language`, `name`) VALUES (NULL, 'Member Invite', 'Dear [EMAIL],<br /><br /> You have been invited to register at our site: <a href="[SITE_URL]">[SITE_URl]</a>.<br /><br /> Please click the link above, or copy and paste it into your browser to register an account.<br /><br /> Thanks,<br /> [SITE_NAME]', 'member_invite', 'english', 'Member Invite');

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


ALTER TABLE `invites`
  ADD PRIMARY KEY (`ID`);


ALTER TABLE `invites`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;