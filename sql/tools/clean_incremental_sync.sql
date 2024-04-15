-- Define the name of the database and the quantity desired for the clean
SET @db_name = 'prestashop';
set @quantity_needed = '100000';

-- Retrieve the eventbus_incremental_sync table name with prefix
SET @eventbus_incremental_sync_table = (SELECT table_name
FROM information_schema.tables
WHERE table_schema = @db_name
AND table_name LIKE '%_eventbus_incremental_sync');

-- Retrieve the _eventbus_type_sync table name with prefix
SET @eventbus_type_sync_table = (SELECT table_name
FROM information_schema.tables
WHERE table_schema = @db_name
AND table_name LIKE '%_eventbus_type_sync');

-- enable full-sync for selected shop content
SET @enable_full_sync = CONCAT('
	UPDATE ', @eventbus_type_sync_table, '
	SET `offset` = 0, full_sync_finished = 0
	WHERE type IN (
		SELECT type
		FROM (
			SELECT type, COUNT(*) as incr_type_count
			FROM ', @eventbus_incremental_sync_table, '
			GROUP BY type
			HAVING COUNT(*) > ', @quantity_needed, '
		) AS subquery
	);
');

-- Execute dynamic query
PREPARE enable_full_sync FROM @enable_full_sync;
EXECUTE enable_full_sync;

-- Delete entries with more than X entries of this type (set above via the variable @quantity_needed)
SET @delete_query = CONCAT('
	DELETE FROM ', @eventbus_incremental_sync_table, '
	WHERE type IN (
		SELECT type
		FROM (
			SELECT type, COUNT(*) as incr_type_count
        	FROM ', @eventbus_incremental_sync_table, '
        	GROUP BY type
        	HAVING COUNT(*) > ', @quantity_needed, '
   	 	) AS subquery
	);
');

-- Execute dynamic query
PREPARE delete_query FROM @delete_query;
EXECUTE delete_query;
