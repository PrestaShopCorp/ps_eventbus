
export class Globals {

  public static SHOP = {
    LOCALE: process.env.BROWSER_LOCALE ?? 'en-US',
    BO_URL: process.env.BO_URL ?? 'http://localhost:8000/admin-dev',
    FO_URL: process.env.FO_URL ?? 'http://localhost:8000',
    ADMIN_EMAIL: process.env.ADMIN_EMAIL ?? 'admin@prestashop.com',
    ADMIN_PASSWORD: process.env.ADMIN_PASSWORD ?? 'prestashop',
  }
}
