-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2017 at 06:05 AM
-- Server version: 10.1.22-MariaDB
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
  `enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `ark_security_level`
--

CREATE TABLE `ark_security_level` (
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

CREATE TABLE `ark_security_user` (
  `user` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `expired` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `credentials_expired` tinyint(1) NOT NULL DEFAULT '0',
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
('atest', 'atest', 't3@example.com', '$2y$13$dffjTe.b0q0g/l.HrGWgmu/6TGO8swv0ZCgs0UZ08nG0vB/pN6lh2', 'John Test', 'ROLE_USER', 0, 0, 0, 0, NULL, 0, NULL, 'KC7xz5XkgPq6p5lw8YZzNxOuXkM7QDZlW16hLedG7ck=', '2017-06-06 14:35:30', NULL, NULL, NULL),
('bnchristensen', 'bnchristensen', 'bnchristensen@lparchaeology.com', '$2y$13$i3xBdnXPm8GVmpguVzD40uinba3vje5Q4UXKBYxPLs6ElABOe.1h6', 'Birgitte Nyborg Christensen', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('dsvendson', 'dsvendson', 'dsvendson@lparchaeology.com', '$2y$13$Bthazyrmo3QlEAeKmHYDk.rA011tJgHjul9zcMLCv6a5w7yaFwa52', 'Dicte Svendsen', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('iitest', 'iitest', 't5@example.com', '$2y$13$BCxlbJQx5fwYuIBUL96ykefjn3IM63sndA2hBoCtLo.RP4ncWf28q', 'John Test', 'ROLE_USER', 0, 0, 0, 0, NULL, 0, NULL, 'DlmnKNFKZWJskYHCwbvH0TUJEs+O2UnnP1EnPRxUugg=', '2017-06-06 16:30:47', NULL, NULL, NULL),
('jlayt', 'jlayt', 'john@layt.net', '$2y$13$5bDc.gpJTrnpJmfQt.7MZOz.QaKH/c8blMJtjJAxuoBwju.P88x2q', 'John Layt', 'ROLE_SYSAD', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('jtest', 'jtest', 'test@example.com', '$2y$13$mXawNKRdBQL1yIyGvjh1bedb9MZ9bUAAnrvhyb2vWZYiD7JR0x8kC', 'John Test', 'ROLE_USER', 0, 0, 0, 0, NULL, 0, NULL, 'EVvgUgkbpU4p5xh/2Bpb8FsstAxtXrWMSBzU4NcOO/8=', '2017-06-06 14:09:11', '', NULL, NULL),
('mjohnson', 'mjohnson', 'm.johnson@lparchaeology.com', '$2y$13$cVYlJ12yc1dA6CTedS1HtuACE7sbD.gsc5/zHnXCk.ddDOEvRtIiK', 'Mike Johnson', 'ROLE_ADMIN', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('osød', 'osød', 'osød@lparchaeology.com', '$2y$13$GZV5ZEIMWEZeYyNlYrWv7OvPxeTwFNE8uu6rRwUtgg5eZzA119H2q', 'Ophelia Sød', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('qtest', 'qtest', 't4@example.com', '$2y$13$K/P8/K41d0rdxOHBQhNp4e1THCigyY.WB2DPnGwurzDSSJaKIXD4W', 'John Test', 'ROLE_USER', 0, 0, 0, 0, NULL, 0, NULL, 'oq46uygL8TYh+qhmCcbk+H3CvNALcOuFPqaHZ9putsY=', '2017-06-06 14:48:08', NULL, NULL, NULL),
('slund', 'slund', 'slund@lparchaeology.com', '$2y$13$NLYpJb9o.dG0ipj6sfzArO4IvWPfWETHymxBsi5un8Y97i2sy9PYW', 'Sarah Lund', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('stuarteve', 'stuarteve', 'stuarteve@gmail.com', '$2y$13$F70UAv8DPo7LFJSm4y0h.eacYGcJuubZRSSYBUqUbgwl4bBq3w.IK', 'Stuart Eve', 'ROLE_ADMIN', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('ttest', 'ttest', 't2@example.com', '$2y$13$/uG73iyi23sfvtY19GwdtuQtZ4jhBT/q10fGNW2odwl60MV1MHQIu', 'John Test', 'ROLE_USER', 0, 0, 0, 0, NULL, 0, NULL, 'CtWfa9vBTiFpjsElaU6a9M4jH4EDe6C2QNWOs2KNy+A=', '2017-06-06 14:15:42', NULL, NULL, NULL);

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
