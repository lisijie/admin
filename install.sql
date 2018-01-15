CREATE TABLE `t_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1男2女',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` char(10) NOT NULL DEFAULT '' COMMENT '密码盐',
  `power` text NOT NULL COMMENT '权限',
  `last_login` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_ip` char(15) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  PRIMARY KEY (`id`),
  KEY `uk_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `t_admin` (`id`, `email`, `nickname`, `password`, `salt`, `power`, `last_login`, `last_ip`)
VALUES
	(1,'admin@admin.com','admin','7fef6171469e80d32c0559f88b377245','','',0,'');