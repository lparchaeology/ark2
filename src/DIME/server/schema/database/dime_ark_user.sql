-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 12, 2018 at 12:17 PM
-- Server version: 10.2.11-MariaDB
-- PHP Version: 7.1.12

SET FOREIGN_KEY_CHECKS=0;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_security_level`
--

CREATE TABLE `ark_security_level` (
  `level` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_security_level`
--

INSERT INTO `ark_security_level` (`level`, `description`, `enabled`) VALUES
('ROLE_ADMIN', 'A user with administration level privileges.', 1),
('ROLE_ANON', 'A user with no privileges.', 1),
('ROLE_SUPER_ADMIN', 'A user with system administration level privileges', 1),
('ROLE_USER', 'A user with registered user level privileges.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_security_user`
--

CREATE TABLE `ark_security_user` (
  `user` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `locked` tinyint(1) NOT NULL DEFAULT 0,
  `expired` tinyint(1) NOT NULL DEFAULT 0,
  `expires_at` datetime DEFAULT NULL,
  `credentials_expired` tinyint(1) NOT NULL DEFAULT 0,
  `credentials_expire_at` datetime DEFAULT NULL,
  `verification_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_requested_at` datetime DEFAULT NULL,
  `password_request_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_security_user`
--

INSERT INTO `ark_security_user` (`user`, `level`, `username`, `email`, `password`, `name`, `activated`, `enabled`, `verified`, `locked`, `expired`, `expires_at`, `credentials_expired`, `credentials_expire_at`, `verification_token`, `verification_requested_at`, `password_request_token`, `password_requested_at`, `last_login`) VALUES
('admin', 'ROLE_ADMIN', 'admin', 'admin@localhost', '$2y$13$JSrPi1knmwXhjy.tUk1Gqu2TUm4X09gozDgu7U2g8Dl84c5XvOuiO', 'Administrator', 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('anonymous', 'ROLE_ANON', 'anonymous', 'anonymous@localhost', NULL, 'Anonymous', 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('detectorist', 'ROLE_USER', 'detectorist', 'detectorist@danefae.dk', '$2y$13$YsXKdXFZ1eDYie89Dc7UuOaGsd/YL20naptV6w4IYQgdRDvclRezO', 'A Detectorist', 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('registrar', 'ROLE_USER', 'registrar', 'registrar@danefae.dk', '$2y$13$jpYnIsvnFJu0H5RVx1kX8OSb6zEIVIOjOr4YsDBnNRsIPCnOWO0.2', 'Registrar NJM', 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('researcher', 'ROLE_USER', 'researcher', 'researcher@danefae.dk', '$2y$13$Y70d/.wdA1o1sNkQ9cutJ.N6HJkCRC.0kdFc1c0AK3cMCJKHdlcDa', 'A Researcher', 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('sysadmin', 'ROLE_SUPER_ADMIN', 'sysadmin', 'sysadmin@localhost', '$2y$13$JSrPi1knmwXhjy.tUk1Gqu2TUm4X09gozDgu7U2g8Dl84c5XvOuiO', 'System Administrator', 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_security_account`
--
ALTER TABLE `ark_security_account`
  ADD PRIMARY KEY (`user`,`account`),
  ADD KEY `user_foreign` (`user`);

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
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD UNIQUE KEY `username_unique` (`username`),
  ADD KEY `level_foreign` (`level`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ark_security_account`
--
ALTER TABLE `ark_security_account`
  ADD CONSTRAINT `security_user_account_constraint` FOREIGN KEY (`user`) REFERENCES `ark_security_user` (`user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_security_user`
--
ALTER TABLE `ark_security_user`
  ADD CONSTRAINT `security_user_level_constraint` FOREIGN KEY (`level`) REFERENCES `ark_security_level` (`level`) ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
