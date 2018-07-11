--liquibase formatted sql logicalFilePath:changeLog.sql
--changeset installer:init_database
CREATE TABLE IF NOT EXISTS `configurations` (
  `key` varchar(150) NOT NULL,
  `value` text NOT NULL,
  `description` text,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--changeset module:install_flashmessages_0_init
CREATE TABLE IF NOT EXISTS `flash_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(45) NOT NULL DEFAULT 'info',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--changeset module:install_memberspace_0_init
-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'root');

-- --------------------------------------------------------

--
-- Structure de la table `links_groups_rights`
--

CREATE TABLE IF NOT EXISTS `links_groups_rights` (
  `group_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`right_id`),
  KEY `right_id` (`right_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `links_groups_rights`
--

INSERT INTO `links_groups_rights` (`group_id`, `right_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `links_users_groups`
--

CREATE TABLE IF NOT EXISTS `links_users_groups` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `links_users_groups`
--

INSERT INTO `links_users_groups` (`user_id`, `group_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `links_users_rights`
--

CREATE TABLE IF NOT EXISTS `links_users_rights` (
  `user_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT 'the group by which this right was obtained 0 if not obtained by any group',
  PRIMARY KEY (`user_id`,`right_id`,`group_id`),
  KEY `right_id` (`right_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `type` varchar(150) DEFAULT '*',
  `object_key` varchar(150) DEFAULT '*',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_type` (`name`(1),`type`,`object_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `rights`
--

INSERT INTO `rights` (`id`, `name`, `type`, `object_key`) VALUES
(1, '*', '*', '*');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_email` (`email`),
  UNIQUE KEY `uniq_login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`) VALUES
(1, 'root', '$2y$10$37DKwcBVUHOUUvohiWMAJegw4sTBtS5veTrRlVJpmobpsNgLbigJW', 'admin@noreply.com');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table 
--
ALTER TABLE `links_groups_rights`
  ADD CONSTRAINT `links_groups_rights_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `links_groups_rights_ibfk_2` FOREIGN KEY (`right_id`) REFERENCES `rights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `links_users_groups`
--
ALTER TABLE `links_users_groups`
  ADD CONSTRAINT `links_users_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `links_users_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `links_users_rights`
--
ALTER TABLE `links_users_rights`
  ADD CONSTRAINT `links_users_rights_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `links_users_rights_ibfk_2` FOREIGN KEY (`right_id`) REFERENCES `rights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--changeset module:install_memberspace_1_add_posts
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `creation_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
--changeset module:install_memberspace_2_add_confirmed_to_users
ALTER TABLE `users` ADD `confirmed` TINYINT NOT NULL DEFAULT '0';
--changeset module:install_memberspace_3_remove_group_id_from_link_users_rights
ALTER TABLE `links_users_rights` DROP `group_id`;
--changeset module:install_memberspace_4_change_password_length_for_users
ALTER TABLE `users` CHANGE `password` `password` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
--changeset module:install_memberspace_5_change_index_size_for_right_name_type
ALTER TABLE `rights` DROP INDEX `name_type`, ADD UNIQUE `name_type` (`name`, `type`, `object_key`) USING BTREE;

--changeset module:install_filebrowser_0_init
CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_folder` tinyint(4) NOT NULL DEFAULT '0',
  `file` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `infos` text,
  `hierarchy` text NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `type` (`type`);

ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--changeset thibault:install_filebrowser_token

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


CREATE TABLE `phed_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(250) NOT NULL,
  `creation_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



ALTER TABLE `phed_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`token`);


ALTER TABLE `phed_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `phed_token`
  ADD CONSTRAINT `phed_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
--changeset module:install_bo_0_init
--
-- Structure de la table `users_admin`
--

CREATE TABLE IF NOT EXISTS `users_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `forname` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users_admin`
--

INSERT INTO `users_admin` (`id`, `name`, `forname`) VALUES
(1, 'Admin', 'Admin');

--
-- Contraintes pour la table `users_admin`
--
ALTER TABLE `users_admin`
  ADD CONSTRAINT `users_admin_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


--changeset module:create_table_users_phed
CREATE TABLE `users_phed` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `users_phed`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users_phed`
  ADD CONSTRAINT `users_phed_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--changeset thibault:add_fullpath_to_files
ALTER TABLE `files` ADD `fullpath` VARCHAR(255) NOT NULL AFTER `hierarchy`, ADD INDEX (`fullpath`);

--changeset thibault:add_domain_to_phed_users
ALTER TABLE `users_phed` ADD `domain` VARCHAR(50) NOT NULL AFTER `id`;