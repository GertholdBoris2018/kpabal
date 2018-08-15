
CREATE TABLE `tbl_board_favorite` (
  `memberIdx` bigint(20) NOT NULL DEFAULT '0',
  `articleIdx` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`memberIdx`,`articleIdx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tbl_business_favorite` (
  `memberIdx` bigint(20) NOT NULL DEFAULT '0',
  `business_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`memberIdx`,`business_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `tbl_member`
  ADD COLUMN `email_change_code` varchar(255) NOT NULL DEFAULT '';
ALTER TABLE `tbl_member`
  ADD COLUMN `email_change_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE `tbl_member`
  ADD COLUMN `new_user_email` varchar(255) NOT NULL DEFAULT '';

INSERT INTO `tbl_site_email_template` VALUES (1,'user_activate','User Account Actiivation','<p>Hi, there.</p><p>In order to activate your account, please visit <a href=\"{activation_code}\">here</a></p>',' '),(2,'user_forgotten','User Password Recovery','<p>Hi, there.</p><p>In order to recover your account password, please visit <a href=\"{forgot_password_code}\">here</a></p>\n',NULL),(3,'email_change','Email Change Confirmation','<p>Hi, there.</p><p>In order to change  your account email address, please visit <a href=\"{email_change_code}\">here</a></p>\n\n',NULL);

INSERT INTO `tbl_site_setting` VALUES ('01','','SITE_TITLE','Site Title','KPABAL',1);