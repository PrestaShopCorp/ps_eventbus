-- Définir le nom de la base de données et la quantité souhaité pour le clean
SET @db_name = 'prestashop';
set @quantity_needed = '100000';

-- Récupérer le nom de la table avec le prefix
SET @table_with_prefix = (SELECT table_name
FROM information_schema.tables
WHERE table_schema = @db_name
AND table_name LIKE '%_eventbus_incremental_sync');

-- Récupère la quantité d'entrées et le type associé
SET @get_content_with_extra_counts = CONCAT('
	SELECT type, 
	COUNT(*) as incr_type_count
	FROM ', @table_with_prefix, '
	GROUP BY type
	HAVING COUNT(*) > ', @quantity_needed, '
');

-- Exécuter la requête dynamique directement
PREPARE dynamic_query FROM @get_content_with_extra_counts;
EXECUTE dynamic_query;
