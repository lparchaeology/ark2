-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2017 at 07:44 PM
-- Server version: 10.2.10-MariaDB
-- PHP Version: 7.1.11

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
-- Database: `avalon_ark_user`
--

--
-- Dumping data for table `ark_security_level`
--

INSERT INTO `ark_security_level` (`level`, `description`, `enabled`) VALUES
('ROLE_ADMIN', 'A user with administration level privileges.', 1),
('ROLE_ANON', 'A user with no privileges.', 1),
('ROLE_SUPER_ADMIN', 'A user with system administration level privileges', 1),
('ROLE_USER', 'A user with registered user level privileges.', 1);

--
-- Dumping data for table `ark_security_user`
--

INSERT INTO `ark_security_user` (`user`, `level`, `username`, `email`, `password`, `name`, `activated`, `enabled`, `verified`, `locked`, `expired`, `expires_at`, `credentials_expired`, `credentials_expire_at`, `verification_token`, `verification_requested_at`, `password_request_token`, `password_requested_at`, `last_login`) VALUES
('core', 'ROLE_ANON', 'core', 'core@localhost', NULL, 'Core System', 0, 0, 0, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
('sysadmin', 'ROLE_SUPER_ADMIN', 'sysadmin', 'sys@admin', '$2y$13$fWkkWzbzuN37ktBQumn/v.KBtWb/IE5fHZMc4dLOhUNg3N/xHX472', 'sysadmin', 1, 1, 1, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
