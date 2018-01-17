SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Drop Constraints and PK
--
ALTER TABLE `ark_workflow_actor_role`
    DROP FOREIGN KEY `workflow_actor_role_actor_constraint`,
    DROP FOREIGN KEY `workflow_actor_role_agent_constraint`,
    DROP PRIMARY KEY;

--
-- Populate missing values
--
UPDATE `ark_workflow_actor_role`
    SET `agent_for` = `actor`
    WHERE `agent_for` IS NULL;

--
-- NULL not allowed
--
ALTER TABLE `ark_workflow_actor_role`
    CHANGE `agent_for` `agent_for` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

 --
 -- Add PK
 --
ALTER TABLE `ark_workflow_actor_role`
    ADD PRIMARY KEY (`actor`,`role`,`agent_for`);

--
-- Add Constraints back
--
ALTER TABLE `ark_workflow_actor_role`
    ADD CONSTRAINT `workflow_actor_role_actor_constraint` FOREIGN KEY (`actor`) REFERENCES `ark_item_actor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `workflow_actor_role_agent_constraint` FOREIGN KEY (`agent_for`) REFERENCES `ark_item_actor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;
