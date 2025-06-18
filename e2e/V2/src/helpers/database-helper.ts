//@ts-nocheck
import mariadb from 'mariadb';
import {Globals} from "@data/globals";

const pool = mariadb.createPool({
  host: Globals.DATABASE.HOST,
  user: Globals.DATABASE.USER,
  password: Globals.DATABASE.PASSWORD,
  database: Globals.DATABASE.NAME,
  connectionLimit: 5,
});

const query = async (sql, params = []) => {
  let conn;
  try {
    conn = await pool.getConnection();
    const res = await conn.query(sql, params);
    return res;
  } finally {
    if (conn) conn.release();
  }
};

export const getLastCreatedOrder = async () => {
  const rows = await query(
    `SELECT * FROM ps_orders ORDER BY date_add DESC LIMIT 1`
  );
  return rows[0];
};

export const getCurrencyById = async (id_currency) => {
  const rows = await query(
    `SELECT * FROM ps_currency WHERE id_currency = ?`,
    [id_currency]
  );
  return rows[0];
};

export const getOrderStateById = async (id_order_state) => {
  const rows = await query(
    `SELECT * FROM ps_order_state WHERE id_order_state = ?`,
    [id_order_state]
  );
  return rows[0];
};
export const getStatusLabelNameByOrderState = async (id_order_state) => {
  const rows = await query(
    `SELECT name FROM ps_order_state_lang WHERE id_order_state = ? LIMIT 1`,
    [id_order_state]
  );
  return rows[0]?.name || null;
};
