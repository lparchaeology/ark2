SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Insert National Museum Actor
--
INSERT INTO `dime_ark_data`.`ark_item_actor`
(`id`, `module`, `schma`, `class`, `status`, `visibility`, `idx`, `label`, `modifier`, `modified`, `creator`, `created`)
VALUES
('NMD', 'actor', 'core.actor', 'museum', 'registered', 'restricted', 'NMD', 'NMD', 'sysadmin', '2018-04-04 00:00:00', 'sysadmin', '2018-04-04 00:00:00');

INSERT INTO `dime_ark_data`.`ark_fragment_string`
(`module`, `item`, `attribute`, `format`, `parameter`, `value`, `modifier`, `modified`, `creator`, `created`)
VALUES
('actor', 'NMD', 'id', NULL, NULL, 'NMD', 'sysadmin', '2018-04-04 00:00:00', 'sysadmin', '2018-04-04 00:00:00'),
('actor', 'NMD', 'class', NULL, 'core.actor.class', 'museum', 'sysadmin', '2018-04-04 00:00:00', 'sysadmin', '2018-04-04 00:00:00');

INSERT INTO `dime_ark_data`.`ark_fragment_text`
(`module`, `item`, `attribute`, `format`, `parameter`, `value`, `modifier`, `modified`, `creator`, `created`)
VALUES
('actor', 'NMD', 'fullname', 'text/plain', 'da', 'Nationalmuseet', 'sysadmin', '2018-04-04 00:00:00', 'sysadmin', '2018-04-04 00:00:00'),
('actor', 'NMD', 'fullname', 'text/plain', 'en', 'National Museum of Denmark', 'sysadmin', '2018-04-04 00:00:00', 'sysadmin', '2018-04-04 00:00:00');


INSERT INTO `dime_ark_data`.`ark_fragment_boolean`
(`module`, `item`, `attribute`, `format`, `parameter`, `value`, `modifier`, `modified`, `creator`, `created`)
VALUES
('actor', 'NMD', 'participating', NULL, NULL, '0', 'admin', '2018-04-04 00:00:00', 'admin', '2018-04-04 00:00:00');

COMMIT;
