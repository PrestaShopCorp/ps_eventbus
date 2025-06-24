//@ts-nocheck
import {test as base, expect, test} from '@playwright/test';
import {
  boDashboardPage,
  boLoginPage,

} from '@prestashop-core/ui-testing';

type AuthenticationFixtures = {
  bo_login: string;
};


export const authentication = base.extend<AuthenticationFixtures> ({
  bo_login: async ({page}, use) => {

    await test.step('should login in BO', async () => {
      await boLoginPage.goTo(page, global.BO.URL);
      await boLoginPage.successLogin(page, global.BO.EMAIL, global.BO.PASSWD);

      const pageTitle = await boDashboardPage.getPageTitle(page);
      expect(pageTitle).toContain(boDashboardPage.pageTitle);
    });

    await use(page)
  }
});
