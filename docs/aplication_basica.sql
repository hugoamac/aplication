-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.28-0ubuntu0.12.04.2 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2012-11-25 22:51:51
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for view paulo.aux_acl
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `aux_acl` (
	`id_role` INT(10) NOT NULL DEFAULT '0',
	`role` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`id_resource` INT(10) NOT NULL DEFAULT '0',
	`resource` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`id_privileges` INT(10) NOT NULL DEFAULT '0',
	`privileges` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


-- Dumping structure for table paulo.log_operacao
CREATE TABLE IF NOT EXISTS `log_operacao` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table paulo.log_transacao
CREATE TABLE IF NOT EXISTS `log_transacao` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_log_operacao` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `tabela` varchar(50) DEFAULT NULL,
  `descricao` mediumtext,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_log_operacao` (`id_log_operacao`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table paulo.usu_grupo
CREATE TABLE IF NOT EXISTS `usu_grupo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table paulo.usu_privilegio
CREATE TABLE IF NOT EXISTS `usu_privilegio` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(10) DEFAULT NULL,
  `id_transacao` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_grupo` (`id_grupo`),
  KEY `id_transacao` (`id_transacao`),
  CONSTRAINT `FK1_usu_grupo_usu_privilegio` FOREIGN KEY (`id_grupo`) REFERENCES `usu_grupo` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK2_usu_recurso_transacao_usu_privilegio` FOREIGN KEY (`id_transacao`) REFERENCES `usu_recurso_transacao` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table paulo.usu_recurso
CREATE TABLE IF NOT EXISTS `usu_recurso` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `recurso` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table paulo.usu_recurso_transacao
CREATE TABLE IF NOT EXISTS `usu_recurso_transacao` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_recurso` int(10) DEFAULT NULL,
  `transacao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_recurso` (`id_recurso`),
  CONSTRAINT `FK1_usu_recurso_usu_recurso_transacao` FOREIGN KEY (`id_recurso`) REFERENCES `usu_recurso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table paulo.usu_usuario
CREATE TABLE IF NOT EXISTS `usu_usuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(10) DEFAULT '0',
  `nome` varchar(70) DEFAULT NULL,
  `login` varchar(40) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_inativacao` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_grupo` (`id_grupo`),
  CONSTRAINT `FK1_usu_grupo_usu_usuario` FOREIGN KEY (`id_grupo`) REFERENCES `usu_grupo` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for view paulo.aux_acl
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `aux_acl`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aux_acl` AS select `g`.`id` AS `id_role`,`g`.`nome` AS `role`,`r`.`id` AS `id_resource`,`r`.`recurso` AS `resource`,`t`.`id` AS `id_privileges`,`t`.`transacao` AS `privileges` from (((`usu_privilegio` `p` join `usu_recurso_transacao` `t` on((`p`.`id_transacao` = `t`.`id`))) join `usu_grupo` `g` on((`g`.`id` = `p`.`id_grupo`))) join `usu_recurso` `r` on((`r`.`id` = `t`.`id_recurso`))) order by `g`.`nome`;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
