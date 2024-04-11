-- Définir le nom de la base de données
SET @db_name = 'prestashop';
set @quantity_needed = '100000';

-- Récupérer le nom de la table avec le prefix
SET @table_with_prefix = (SELECT table_name
FROM information_schema.tables
WHERE table_schema = @db_name
AND table_name LIKE '%_eventbus_incremental_sync');

-- Supprime les entrées avec plus de X entrée de ce type (paramétré au dessus via la variable @quantity_needed)
SET @delete_query = CONCAT('
	DELETE FROM ', @table_with_prefix, '
	WHERE type IN (
		SELECT type
		FROM (
			SELECT type, COUNT(*) as incr_type_count
        	FROM ', @table_with_prefix, '
        	GROUP BY type
        	HAVING COUNT(*) >', @quantity_needed, '
   	 	) AS subquery
	);
');

-- Exécuter la requête dynamique directement
PREPARE dynamic_query FROM @delete_query;
EXECUTE dynamic_query;
