-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 04, 2017 at 10:12 AM
-- Server version: 10.2.8-MariaDB
-- PHP Version: 7.1.8

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

--
-- Truncate table before insert `ark_security_level`
--

TRUNCATE TABLE `ark_security_level`;
--
-- Dumping data for table `ark_security_level`
--

INSERT INTO `ark_security_level` (`level`, `description`, `enabled`) VALUES
('ROLE_ADMIN', 'A user with administration level privileges.', 1),
('ROLE_ANON', 'A user with no privileges.', 1),
('ROLE_SUPER_ADMIN', 'A user with system administration level privileges', 1),
('ROLE_USER', 'A user with registered user level privileges.', 1);

--
-- Truncate table before insert `ark_security_user`
--

TRUNCATE TABLE `ark_security_user`;
--
-- Dumping data for table `ark_security_user`
--

INSERT INTO `ark_security_user` (`user`, `username`, `email`, `password`, `name`, `level`, `enabled`, `verified`, `locked`, `expired`, `expires_at`, `credentials_expired`, `credentials_expire_at`, `verification_token`, `verification_requested_at`, `password_request_token`, `password_requested_at`, `last_login`) VALUES
('core', 'core', 'core@localhost', NULL, 'Core System', 'ROLE_ANON', 0, 0, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
