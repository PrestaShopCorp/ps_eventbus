import type {
  GlobalInstall,
  GlobalFO,
  GlobalBO,
  GlobalBrowserConfig,
  GlobalPSConfig,
  GlobalBrowserErrors,
  GlobalScreenshot,
  GlobalMaildevConfig,
  GlobalKeycloakConfig,
} from '@prestashop-core/ui-testing';
/* eslint-disable no-var */
declare global {
  var INSTALL: GlobalInstall;
  var URLHasPort: boolean;
  var FO: GlobalFO;
  var BO: GlobalBO;
  var PSConfig: GlobalPSConfig;
  var BROWSER: GlobalBrowserConfig;
  var SCREENSHOT: GlobalScreenshot;
  var maildevConfig: GlobalMaildevConfig;
  var keycloakConfig: GlobalKeycloakConfig;
  var browserErrors: GlobalBrowserErrors;
}

export {};
