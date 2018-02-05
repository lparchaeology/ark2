SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Rename tables
--
RENAME TABLE `dime_ark_data`.`ark_workflow_actor_role` TO `dime_ark_data`.`ark_security_actor_role`;
RENAME TABLE `dime_ark_data`.`ark_workflow_actor_user` TO `dime_ark_data`.`ark_security_actor_user`;

COMMIT;
