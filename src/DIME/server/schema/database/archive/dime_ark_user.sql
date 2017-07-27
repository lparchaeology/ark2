-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2017 at 11:46 AM
-- Server version: 10.2.6-MariaDB
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dime_ark_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `ark_security_account`
--

CREATE TABLE `ark_security_account` (
  `user` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `protocol` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refresh_token` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `ark_security_level`
--

CREATE TABLE `ark_security_level` (
  `level` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1
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

CREATE TABLE `ark_security_user` (
  `user` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `locked` tinyint(1) NOT NULL DEFAULT 0,
  `expired` tinyint(1) NOT NULL DEFAULT 0,
  `expires_at` timestamp NULL DEFAULT NULL,
  `credentials_expired` tinyint(1) NOT NULL DEFAULT 0,
  `credentials_expire_at` timestamp NULL DEFAULT NULL,
  `verification_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_requested_at` timestamp NULL DEFAULT NULL,
  `password_request_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_security_user`
--

INSERT INTO `ark_security_user` (`user`, `username`, `email`, `password`, `name`, `level`, `enabled`, `verified`, `locked`, `expired`, `expires_at`, `credentials_expired`, `credentials_expire_at`, `verification_token`, `verification_requested_at`, `password_request_token`, `password_requested_at`, `last_login`) VALUES
('ahavfrue', 'ahavfrue', 'ahavfrue@lparchaeology.com', '$2y$13$VF7niHDAlU4.oUgUIJsx6erd5Esou.yrGq/oJa41giIqex0m8kxSS', 'Ariel Havfrue', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('bnchristensen', 'bnchristensen', 'bnchristensen@lparchaeology.com', '$2y$13$i3xBdnXPm8GVmpguVzD40uinba3vje5Q4UXKBYxPLs6ElABOe.1h6', 'Birgitte Nyborg Christensen', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('dsvendson', 'dsvendson', 'dsvendson@lparchaeology.com', '$2y$13$Bthazyrmo3QlEAeKmHYDk.rA011tJgHjul9zcMLCv6a5w7yaFwa52', 'Dicte Svendsen', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('jlayt', 'jlayt', 'john@layt.net', '$2y$13$5bDc.gpJTrnpJmfQt.7MZOz.QaKH/c8blMJtjJAxuoBwju.P88x2q', 'John Layt', 'ROLE_SYSADMIN', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('mjohnson', 'mjohnson', 'm.johnson@lparchaeology.com', '$2y$13$cVYlJ12yc1dA6CTedS1HtuACE7sbD.gsc5/zHnXCk.ddDOEvRtIiK', 'Mike Johnson', 'ROLE_ADMIN', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('osød', 'osød', 'osød@lparchaeology.com', '$2y$13$GZV5ZEIMWEZeYyNlYrWv7OvPxeTwFNE8uu6rRwUtgg5eZzA119H2q', 'Ophelia Sød', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('slund', 'slund', 'slund@lparchaeology.com', '$2y$13$NLYpJb9o.dG0ipj6sfzArO4IvWPfWETHymxBsi5un8Y97i2sy9PYW', 'Sarah Lund', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('stuarteve', 'stuarteve', 'stuarteve@gmail.com', '$2y$13$F70UAv8DPo7LFJSm4y0h.eacYGcJuubZRSSYBUqUbgwl4bBq3w.IK', 'Stuart Eve', 'ROLE_ADMIN', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);

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
  ADD PRIMARY KEY (`user`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ark_security_account`
--
ALTER TABLE `ark_security_account`
  ADD CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `ark_security_user` (`user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
