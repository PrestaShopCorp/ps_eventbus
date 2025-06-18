import { defineConfig, devices } from '@playwright/test';

//import dotenv from 'dotenv';
import {config} from 'dotenv';
import path from 'path';

//dotenv.config({ path: path.resolve(__dirname, '.env') });

function loadGlobal(): void {
  global.FO = {
    URL: process.env.URL_FO || 'http://localhost:8000/',
  };

  /*
  Linked to the issue #22581
  */
  global.URLHasPort = (global.FO.URL).match(/:\d+.+/) !== null;

  global.BO = {
    URL: process.env.URL_BO || `${global.FO.URL}admin-dev/`,
    EMAIL: process.env.LOGIN || 'admin@prestashop.com',
    PASSWD: process.env.PASSWD || 'prestashop',
    FIRSTNAME: process.env.FIRSTNAME || 'Marc',
    LASTNAME: process.env.LASTNAME || 'Beier',
  };

  global.PSConfig = {
    parametersFile: process.env.PS_PARAMETERS_FILE || path.resolve(__dirname, '../../../', 'app/config/parameters.php'),
  };

  global.INSTALL = {
    URL: process.env.URL_INSTALL || `${global.FO.URL}install-dev/`,
    LANGUAGE: process.env.INSTALL_LANGUAGE || 'en',
    COUNTRY: process.env.INSTALL_COUNTRY || 'France',
    ENABLE_SSL: process.env.ENABLE_SSL === 'true',
    DB_SERVER: process.env.DB_SERVER || '127.0.0.1',
    DB_NAME: process.env.DB_NAME || 'prestashopdb',
    DB_USER: process.env.DB_USER || 'root',
    DB_PASSWD: process.env.DB_PASSWD || '',
    DB_PREFIX: process.env.DB_PREFIX || 'tst_',
    SHOP_NAME: process.env.SHOP_NAME || 'PrestaShop',
  };

  global.BROWSER = {
    //@ts-ignore
    name: process.env.BROWSER || 'chromium',
    lang: process.env.BROWSER_LANG || 'en-GB',
    width: process.env.BROWSER_WIDTH ? parseInt(process.env.BROWSER_WIDTH, 10) : 1680,
    height: process.env.BROWSER_HEIGHT ? parseInt(process.env.BROWSER_HEIGHT, 10) : 900,
    sandboxArgs: ['--no-sandbox', '--disable-setuid-sandbox'],
    acceptDownloads: true,
    config: {
      headless: process.env.HEADLESS ? JSON.parse(process.env.HEADLESS) : true,
      timeout: 0,
      slowMo: parseInt(process.env.SLOW_MO ?? '1000', 10)
    },
    interceptErrors: process.env.INTERCEPT_ERRORS ? JSON.parse(process.env.INTERCEPT_ERRORS) : false,
  };

  //@ts-ignore
  global.GENERATE_FAILED_STEPS = process.env.GENERATE_FAILED_STEPS ? JSON.parse(process.env.GENERATE_FAILED_STEPS) : false;

  global.SCREENSHOT = {
    FOLDER: process.env.SCREENSHOT_FOLDER || './screenshots',
    AFTER_FAIL: process.env.TAKE_SCREENSHOT_AFTER_FAIL ? JSON.parse(process.env.TAKE_SCREENSHOT_AFTER_FAIL) : false,
  };

  global.maildevConfig = {
    smtpPort: parseInt(process.env.SMTP_PORT ?? '1025', 10),
    smtpServer: process.env.SMTP_SERVER || 'localhost',
    silent: true,
  };

  global.keycloakConfig = {
    keycloakExternalUrl: process.env.KEYCLOAK_URL_EXTERNAL || 'http://localhost:8003',
    keycloakInternalUrl: process.env.KEYCLOAK_URL_INTERNAL || 'http://keycloak:8080',
    keycloakAdminUser: process.env.KEYCLOAK_ADMIN_USER || 'admin',
    keycloakAdminPass: process.env.KEYCLOAK_ADMIN_PASS || 'admin',
    keycloakClientId: process.env.KEYCLOAK_CLIENT_ID || 'prestashop-keycloak',
    //@ts-ignore
    keycloakClientSecret: process.env.KEYCLOAK_CLIENT_SECRET || 'aapfdgdfghdsfuhgdsfydsffgpoihfg',
  };
}

/**
 * Read environment variables from file.
 * https://github.com/motdotla/dotenv
 */
config();
/**
 * Load global data from environment variables
 */
loadGlobal();
/**
 * See https://playwright.dev/docs/test-configuration.
 */
export default defineConfig({
  timeout: 120000,
  expect: {
    timeout: 10000
  },
  testDir: './src/tests',
  // don't run test on parallel mode
  fullyParallel: false,
  retries: 0,
  workers: 1,
  reporter: [
    ['list', {printSteps: true}],
    ['html', {open: 'never'}],
    ['json', {outputFile: 'playwright-report/results.json'}],
    [
      'playwright-ctrf-json-reporter',
      {
        outputFile: 'summary.json',
        outputDir: 'report-summary'
      }
    ],
  ],
  use: {
    headless: !(process.env.HEADLESS === 'false'),
    screenshot: 'only-on-failure',
    trace: 'on-first-retry',
  },

  projects: [
    {
      name: 'healthcheck',
      testMatch: 'healthcheck.setup.ts',
    },
    {
      name: 'full-sync',
      testMatch: 'full-sync.setup.ts',
      dependencies: ['healthcheck'],
    },
    {
      name: "INCREMENTAL",
      testDir: './src/tests/incremental/',
      dependencies: ['HEALTHCHECK'],
      teardown: 'RESTORE-DB'
      //dependencies: ['FULL-SYNC'],
    },
    {
      name: "RESTORE-DB",
      testMatch: 'restore-db.teardown.ts',
    },
    {
      name: "SANITY",
      testDir: './src/tests/sanity/',
      dependencies: ['HEALTHCHECK']
    }
  ],
});
