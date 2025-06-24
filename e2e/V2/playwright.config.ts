import { defineConfig, devices } from '@playwright/test';

import {config} from 'dotenv';
import path from 'path';

config({ path: path.resolve(__dirname, '.env') });


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
      name: 'HEALTHCHECK',
      testMatch: 'healthcheck.setup.ts',
    },
    {
      name: 'full-sync',
      testMatch: 'full-sync.setup.ts',
      dependencies: ['HEALTHCHECK'],
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
