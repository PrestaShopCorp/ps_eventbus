-- Define the name of the database and the quantity desired for the clean
SET @db_name = 'prestashop';
set @quantity_needed = '100000';

-- Retrieve the eventbus_incremental_sync table name with prefix
SET @eventbus_incremental_sync_table = (SELECT table_name
FROM information_schema.tables
WHERE table_schema = @db_name
AND table_name LIKE '%_eventbus_incremental_sync');

-- Retrieves the input quantity and associated type
SET @get_content_with_extra_counts = CONCAT('
	SELECT type, 
	COUNT(*) as incr_type_count
	FROM ', @eventbus_incremental_sync_table, '
	GROUP BY type
	HAVING COUNT(*) > ', @quantity_needed, '
');

-- Execute dynamic query
PREPARE get_content_with_extra_counts FROM @get_content_with_extra_counts;
EXECUTE get_content_with_extra_counts;
