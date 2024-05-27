import * as pg from 'pg';
import * as pgTypes from 'pg-types';

//pg date serialization (UTC)
pgTypes.setTypeParser(pgTypes.builtins.TIMESTAMP, (val) => new Date(`${val}Z`));

export class PostgresClient {
  client: pg.Client;
  isConnected = false;

  constructor({ user, password, host, port, database }) {
    this.client = new pg.Client({ user, password, host, port, database });
  }

  async disconnect() {
    this.isConnected = false;
    await this.client.end();
  }

  async connect() {
    if (this.isConnected) return;
    await this.client.connect();
    this.isConnected = true;
  }

  async query<T = unknown>(sql: string): Promise<T[]> {
    const res = await this.client.query(sql);
    return res.rows;
  }
}
