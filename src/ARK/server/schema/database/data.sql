-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 06, 2017 at 04:55 PM
-- Server version: 10.2.8-MariaDB
-- PHP Version: 7.1.8

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `core_ark_data`
--

--
-- Truncate table before insert `ark_association`
--

TRUNCATE TABLE `ark_association`;
--
-- Truncate table before insert `ark_fragment_blob`
--

TRUNCATE TABLE `ark_fragment_blob`;
--
-- Truncate table before insert `ark_fragment_boolean`
--

TRUNCATE TABLE `ark_fragment_boolean`;
--
-- Truncate table before insert `ark_fragment_date`
--

TRUNCATE TABLE `ark_fragment_date`;
--
-- Truncate table before insert `ark_fragment_datetime`
--

TRUNCATE TABLE `ark_fragment_datetime`;
--
-- Truncate table before insert `ark_fragment_decimal`
--

TRUNCATE TABLE `ark_fragment_decimal`;
--
-- Truncate table before insert `ark_fragment_float`
--

TRUNCATE TABLE `ark_fragment_float`;
--
-- Truncate table before insert `ark_fragment_integer`
--

TRUNCATE TABLE `ark_fragment_integer`;
--
-- Truncate table before insert `ark_fragment_item`
--

TRUNCATE TABLE `ark_fragment_item`;
--
-- Truncate table before insert `ark_fragment_object`
--

TRUNCATE TABLE `ark_fragment_object`;
--
-- Truncate table before insert `ark_fragment_spatial`
--

TRUNCATE TABLE `ark_fragment_spatial`;
--
-- Truncate table before insert `ark_fragment_string`
--

TRUNCATE TABLE `ark_fragment_string`;
--
-- Dumping data for table `ark_fragment_string`
--

INSERT INTO `ark_fragment_string` (`fid`, `object`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(1, NULL, 'actor', 'anonymous', 'id', 'string', NULL, NULL, 'anonymous', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL),
(2, NULL, 'actor', 'anonymous', 'class', 'string', NULL, 'core.actor.class', 'person', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL);

--
-- Truncate table before insert `ark_fragment_text`
--

TRUNCATE TABLE `ark_fragment_text`;
--
-- Dumping data for table `ark_fragment_text`
--

INSERT INTO `ark_fragment_text` (`fid`, `object`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(1, NULL, 'actor', 'anonymous', 'fullname', 'text', 'text/plain', 'en', 'Anonymous', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL),
(2, NULL, 'actor', 'anonymous', 'shortname', 'text', 'text/plain', 'en', 'Anon', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL),
(3, NULL, 'actor', 'anonymous', 'initials', 'text', 'text/plain', 'en', 'ANO', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL),
(4, NULL, 'page', 'about', 'content', 'text', 'text/html', 'en', '<H1>Welcome to Avalon</H1>', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL);

--
-- Truncate table before insert `ark_fragment_time`
--

TRUNCATE TABLE `ark_fragment_time`;
--
-- Truncate table before insert `ark_item_actor`
--

TRUNCATE TABLE `ark_item_actor`;
--
-- Dumping data for table `ark_item_actor`
--

INSERT INTO `ark_item_actor` (`id`, `module`, `schma`, `class`, `status`, `visibility`, `parent_module`, `parent_id`, `idx`, `label`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
('anonymous', 'actor', 'core.actor', 'person', 'allocated', 'public', NULL, NULL, 'anonymous', 'anonymous', '', '2017-09-06 00:00:00', '', '2017-09-06 00:00:00', NULL);

--
-- Truncate table before insert `ark_item_event`
--

TRUNCATE TABLE `ark_item_event`;
--
-- Truncate table before insert `ark_item_file`
--

TRUNCATE TABLE `ark_item_file`;
--
-- Truncate table before insert `ark_item_message`
--

TRUNCATE TABLE `ark_item_message`;
--
-- Truncate table before insert `ark_item_page`
--

TRUNCATE TABLE `ark_item_page`;
--
-- Dumping data for table `ark_item_page`
--

INSERT INTO `ark_item_page` (`id`, `module`, `schma`, `class`, `status`, `visibility`, `parent_module`, `parent_id`, `idx`, `label`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
('about', 'page', 'core.page', NULL, 'allocated', 'public', NULL, NULL, 'about', 'about', '', '2017-09-06 00:00:00', '', '2017-09-06 00:00:00', NULL);

--
-- Truncate table before insert `ark_sequence`
--

TRUNCATE TABLE `ark_sequence`;
--
-- Truncate table before insert `ark_sequence_lock`
--

TRUNCATE TABLE `ark_sequence_lock`;
--
-- Truncate table before insert `ark_sequence_reserve`
--

TRUNCATE TABLE `ark_sequence_reserve`;
--
-- Truncate table before insert `ark_workflow_actor_role`
--

TRUNCATE TABLE `ark_workflow_actor_role`;
--
-- Dumping data for table `ark_workflow_actor_role`
--

INSERT INTO `ark_workflow_actor_role` (`actor`, `role`, `agent_for`, `enabled`, `expires_at`) VALUES
('anonymous', 'anonymous', NULL, 1, NULL);

--
-- Truncate table before insert `ark_workflow_actor_user`
--

TRUNCATE TABLE `ark_workflow_actor_user`;
--
-- Dumping data for table `ark_workflow_actor_user`
--

INSERT INTO `ark_workflow_actor_user` (`actor`, `user`, `enabled`, `expires_at`) VALUES
('anonymous', 'anonymous', 1, NULL);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
