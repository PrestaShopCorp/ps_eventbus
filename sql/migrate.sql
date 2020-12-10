SELECT * INTO `PREFIX_eventbus_type_sync`
FROM `PREFIX_accounts_type_sync`;

SELECT * INTO `PREFIX_eventbus_deleted_objects`
FROM `PREFIX_accounts_deleted_objects`;

SELECT * INTO `PREFIX_eventbus_incremental_sync`
FROM `PREFIX_accounts_incremental_sync`;