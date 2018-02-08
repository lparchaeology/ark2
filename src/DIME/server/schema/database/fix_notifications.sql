SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Delete all Messages and related frags
--
DELETE FROM `ark_item_message`;
DELETE FROM `ark_fragment_datetime` WHERE `module` = 'message';
DELETE FROM `ark_fragment_item` WHERE `module` = 'message';
DELETE FROM `ark_fragment_object` WHERE `module` = 'message';
DELETE FROM `ark_fragment_string` WHERE `module` = 'message';
DELETE FROM `ark_fragment_text` WHERE `module` = 'message';

--
-- Fix the Event attribute
--
UPDATE `ark_fragment_item` SET `attribute`='object' WHERE `module`='event' AND `attribute`='subject';

COMMIT;
