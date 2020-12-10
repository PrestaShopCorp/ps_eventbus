INSERT INTO `PREFIX_eventbus_type_sync`
SELECT * FROM `PREFIX_accounts_type_sync`;

INSERT INTO `PREFIX_eventbus_deleted_objects`
SELECT * FROM `PREFIX_accounts_deleted_objects`;

INSERT INTO `PREFIX_eventbus_incremental_sync`
SELECT * FROM `PREFIX_accounts_incremental_sync`;

DROP TABLE IF EXISTS `PREFIX_accounts_type_sync`;
DROP TABLE IF EXISTS `PREFIX_accounts_deleted_objects`;
DROP TABLE IF EXISTS `PREFIX_accounts_incremental_sync`;
DROP TABLE IF EXISTS `PREFIX_accounts_sync`;