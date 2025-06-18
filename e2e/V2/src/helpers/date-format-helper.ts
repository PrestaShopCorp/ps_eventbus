import { format, toZonedTime } from 'date-fns-tz';

/**
 * Formate une date UTC en string sans deux-points dans le décalage horaire (ex: +0200)
 * utilisé par les champs comme created_at, updated_at
 */
export function toIsoNoColon(date: Date | string): string {
  const d = new Date(date);
  const zoned = toZonedTime(d, 'Europe/Paris');
  const isoWithColon = format(zoned, "yyyy-MM-dd'T'HH:mm:ssxxx");
  return isoWithColon.replace(/([+-]\d{2}):?(\d{2})$/, '$1$2');
}

/**
 * Formate une date UTC en string SQL-like (ex: "YYYY-MM-DD HH:mm:ss")
 * utilisé par les champs comme invoice_date, delivery_date
 */
export function toSqlDateTime(date: Date | string): string {
  const d = new Date(date);
  const zoned = toZonedTime(d, 'Europe/Paris');
  return format(zoned, 'yyyy-MM-dd HH:mm:ss');
}
