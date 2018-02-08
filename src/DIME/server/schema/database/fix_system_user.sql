SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Add the System User flag
--
ALTER TABLE `ark_security_user`  ADD `system` BOOLEAN NOT NULL DEFAULT FALSE  AFTER `name`;
UPDATE `ark_security_user` SET `system` = 1 WHERE `user` = 'anonymous' OR `user` = 'sysadmin';

COMMIT;
