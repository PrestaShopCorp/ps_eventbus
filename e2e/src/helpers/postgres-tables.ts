import testConfig from './test.config';

export const postgresTablesMapping = {
  categories: `${testConfig.postgres_params.schema}.categories`,
};
