SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Rename tables
--
RENAME TABLE `dime_ark_data`.`ark_fragment_object` TO `dime_ark_data`.`ark_fragment_structure`;
ALTER TABLE `dime_ark_data`.`ark_fragment_structure` CHANGE `datatype` `datatype` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'structure';
ALTER TABLE `dime_ark_data`.`ark_fragment_blob` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_boolean` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_date` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_datetime` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_decimal` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_float` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_integer` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_item` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_spatial` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_string` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_structure` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_text` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
ALTER TABLE `dime_ark_data`.`ark_fragment_time` CHANGE `object` `structure` INT(11) NULL DEFAULT NULL;
UPDATE `dime_ark_data`.`ark_fragment_structure` SET `datatype`= 'structure';
UPDATE `dime_ark_data`.`ark_sequence` SET `module`= 'structure' WHERE `module`= 'object';

COMMIT;
