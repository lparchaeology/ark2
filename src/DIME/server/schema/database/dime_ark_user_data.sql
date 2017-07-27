-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 27, 2017 at 08:49 AM
-- Server version: 10.2.7-MariaDB
-- PHP Version: 7.1.7

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

--
-- Dumping data for table `ark_security_user`
--

INSERT INTO `ark_security_user` (`user`, `username`, `email`, `password`, `name`, `level`, `enabled`, `verified`, `locked`, `expired`, `expires_at`, `credentials_expired`, `credentials_expire_at`, `verification_token`, `verification_requested_at`, `password_request_token`, `password_requested_at`, `last_login`) VALUES
('ahavfrue', 'ahavfrue', 'ahavfrue@lparchaeology.com', '$2y$13$VF7niHDAlU4.oUgUIJsx6erd5Esou.yrGq/oJa41giIqex0m8kxSS', 'Ariel Havfrue', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('bnchristensen', 'bnchristensen', 'bnchristensen@lparchaeology.com', '$2y$13$i3xBdnXPm8GVmpguVzD40uinba3vje5Q4UXKBYxPLs6ElABOe.1h6', 'Birgitte Nyborg Christensen', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('dsvendson', 'dsvendson', 'dsvendson@lparchaeology.com', '$2y$13$Bthazyrmo3QlEAeKmHYDk.rA011tJgHjul9zcMLCv6a5w7yaFwa52', 'Dicte Svendsen', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('jlayt', 'jlayt', 'john@layt.net', '$2y$13$5bDc.gpJTrnpJmfQt.7MZOz.QaKH/c8blMJtjJAxuoBwju.P88x2q', 'John Layt', 'ROLE_SUPER_ADMIN', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('mjohnson', 'mjohnson', 'm.johnson@lparchaeology.com', '$2y$13$cVYlJ12yc1dA6CTedS1HtuACE7sbD.gsc5/zHnXCk.ddDOEvRtIiK', 'Mike Johnson', 'ROLE_ADMIN', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('osød', 'osød', 'osød@lparchaeology.com', '$2y$13$GZV5ZEIMWEZeYyNlYrWv7OvPxeTwFNE8uu6rRwUtgg5eZzA119H2q', 'Ophelia Sød', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('slund', 'slund', 'slund@lparchaeology.com', '$2y$13$NLYpJb9o.dG0ipj6sfzArO4IvWPfWETHymxBsi5un8Y97i2sy9PYW', 'Sarah Lund', 'ROLE_USER', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('stuarteve', 'stuarteve', 'stuarteve@gmail.com', '$2y$13$F70UAv8DPo7LFJSm4y0h.eacYGcJuubZRSSYBUqUbgwl4bBq3w.IK', 'Stuart Eve', 'ROLE_ADMIN', 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
