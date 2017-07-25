-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 25, 2017 at 02:44 PM
-- Server version: 10.2.7-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

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

INSERT INTO `ark_security_user` (`user`, `username`, `email`, `password`, `name`, `level`, `enabled`, `verified`, `locked`, `expired`, `expires_at`, `credentials_expired`, `credentials_expire_at`, `verification_token`, `verification_requested_at`, `password_request_token`, `password_requested_at`, `last_login`) VALUES
('core', 'core', NULL, NULL, 'Core System', 'ROLE_ANON', 0, 0, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;
