-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2017 at 12:02 AM
-- Server version: 10.0.29-MariaDB-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dime_ark_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `ark_security_account`
--

CREATE TABLE IF NOT EXISTS `ark_security_account` (
  `user` int(10) unsigned NOT NULL,
  `account` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `protocol` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refresh_token` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `ark_security_level`
--

CREATE TABLE IF NOT EXISTS `ark_security_level` (
  `level` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_security_level`
--

INSERT INTO `ark_security_level` (`level`, `enabled`) VALUES
('ROLE_ADMIN', 1),
('ROLE_ANON', 1),
('ROLE_SYSADMIN', 1),
('ROLE_USER', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_security_user`
--

CREATE TABLE IF NOT EXISTS `ark_security_user` (
`user` int(11) unsigned NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `expired` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `credentials_expired` tinyint(1) NOT NULL DEFAULT '0',
  `credentials_expire_at` timestamp NULL DEFAULT NULL,
  `verification_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_requested_at` timestamp NULL DEFAULT NULL,
  `password_request_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_requested_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_security_user`
--

INSERT INTO `ark_security_user` (`user`, `username`, `email`, `password`, `name`, `level`, `enabled`, `verified`, `locked`, `expired`, `expires_at`, `credentials_expired`, `credentials_expire_at`, `verification_token`, `verification_requested_at`, `password_request_token`, `password_requested_at`, `last_login`) VALUES
(1, NULL, 'john@layt.net', '$2y$13$5bDc.gpJTrnpJmfQt.7MZOz.QaKH/c8blMJtjJAxuoBwju.P88x2q', 'John Layt', 'ROLE_SYSADMIN', 1, 0, 0, 0, NULL, 0, NULL, '', NULL, '', NULL, NULL),
(2, NULL, 'stuarteve@gmail.com', '$2y$13$F70UAv8DPo7LFJSm4y0h.eacYGcJuubZRSSYBUqUbgwl4bBq3w.IK', 'Stuart Eve', 'ROLE_ADMIN', 1, 0, 0, 0, NULL, 0, NULL, '', NULL, '', NULL, NULL),
(3, NULL, 'm.johnson@lparchaeology.com', '$2y$13$cVYlJ12yc1dA6CTedS1HtuACE7sbD.gsc5/zHnXCk.ddDOEvRtIiK', 'Mike Johnson', 'ROLE_ADMIN', 1, 0, 0, 0, NULL, 0, NULL, '', NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_user`
--

CREATE TABLE IF NOT EXISTS `ark_user` (
`id` int(11) unsigned NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_created` int(11) unsigned NOT NULL DEFAULT '0',
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isEnabled` tinyint(1) NOT NULL DEFAULT '1',
  `confirmationToken` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timePasswordResetRequested` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_user`
--

INSERT INTO `ark_user` (`id`, `email`, `password`, `salt`, `roles`, `name`, `time_created`, `username`, `isEnabled`, `confirmationToken`, `timePasswordResetRequested`) VALUES
(1, 'john@layt.net', '$2y$13$5bDc.gpJTrnpJmfQt.7MZOz.QaKH/c8blMJtjJAxuoBwju.P88x2q', 'rq65ui5ahg0cowcgogww40ogowcw0g0', 'ROLE_ADMIN', 'John Layt', 1480940588, 'jlayt', 1, NULL, 0),
(2, 'stuarteve@gmail.com', '$2y$13$F70UAv8DPo7LFJSm4y0h.eacYGcJuubZRSSYBUqUbgwl4bBq3w.IK', 'nkqf6zxm3sgossoc00wggg4cowgwwwc', 'ROLE_ADMIN', 'Stuart Eve', 1484040483, 'stuarteve', 1, NULL, 0),
(3, 'm.johnson@lparchaeology.com', '$2y$13$cVYlJ12yc1dA6CTedS1HtuACE7sbD.gsc5/zHnXCk.ddDOEvRtIiK', 'if1c0lxgm5koo4sg8g8c0kgscgogg08', 'ROLE_ADMIN', 'Mike Johnson', 1484140132, 'mjohnson', 1, NULL, 0),
(9, 'ahavfrue@lparchaeology.com', '$2y$13$VF7niHDAlU4.oUgUIJsx6erd5Esou.yrGq/oJa41giIqex0m8kxSS', 'mb2py4as4vkos40kccgkwwo8wowgssc', 'ROLE_USER', 'Ariel Havfrue', 1494433223, 'ahavfrue', 1, NULL, 0),
(10, 'bnchristensen@lparchaeology.com', '$2y$13$i3xBdnXPm8GVmpguVzD40uinba3vje5Q4UXKBYxPLs6ElABOe.1h6', 'huz56i073vccg0wos8g40k8o48c8ws8', 'ROLE_USER', 'Birgitte Nyborg Christensen', 1494433350, 'bnchristensen', 1, NULL, 0),
(11, 'dsvendson@lparchaeology.com', '$2y$13$Bthazyrmo3QlEAeKmHYDk.rA011tJgHjul9zcMLCv6a5w7yaFwa52', 'ftyo3cak2t4wsw8k08c0ocoscgswoo0', 'ROLE_USER', 'Dicte Svendsen', 1494433428, 'dsvendson', 1, NULL, 0),
(12, 'slund@lparchaeology.com', '$2y$13$NLYpJb9o.dG0ipj6sfzArO4IvWPfWETHymxBsi5un8Y97i2sy9PYW', 'nngs4gzif5coco048884s08sw00ww8w', 'ROLE_USER', 'Sarah Lund', 1494433621, 'slund', 1, NULL, 0),
(13, 'osød@lparchaeology.com', '$2y$13$GZV5ZEIMWEZeYyNlYrWv7OvPxeTwFNE8uu6rRwUtgg5eZzA119H2q', 'dgejnsy5ju0osgsk044cggwswwcgkck', 'ROLE_USER', 'Ophelia Sød', 1494434650, 'osød', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_user_field`
--

CREATE TABLE IF NOT EXISTS `ark_user_field` (
  `user_id` int(11) unsigned NOT NULL,
  `attribute` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_security_account`
--
ALTER TABLE `ark_security_account`
 ADD PRIMARY KEY (`user`,`account`);

--
-- Indexes for table `ark_security_level`
--
ALTER TABLE `ark_security_level`
 ADD PRIMARY KEY (`level`);

--
-- Indexes for table `ark_security_user`
--
ALTER TABLE `ark_security_user`
 ADD PRIMARY KEY (`user`), ADD UNIQUE KEY `unique_email` (`email`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ark_user`
--
ALTER TABLE `ark_user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `unique_email` (`email`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ark_user_field`
--
ALTER TABLE `ark_user_field`
 ADD PRIMARY KEY (`user_id`,`attribute`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ark_security_user`
--
ALTER TABLE `ark_security_user`
MODIFY `user` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ark_user`
--
ALTER TABLE `ark_user`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ark_security_account`
--
ALTER TABLE `ark_security_account`
ADD CONSTRAINT `ark_security_account_ibfk_1` FOREIGN KEY (`user`) REFERENCES `ark_security_user` (`user`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
