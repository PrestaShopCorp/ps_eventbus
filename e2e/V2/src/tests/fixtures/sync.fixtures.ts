//@ts-nocheck
import {test as base, expect, test} from '@playwright/test';
// Utils
import {colorText} from "@helpers/utils";
// prisma
import { PrismaClient } from '@prismaClient/prisma'
// Prisma client
const prisma = new PrismaClient();

type SyncFixtures = {
  shopContent: ShopContent[];
  forceFullSync: string;
};

export const sync = base.extend<SyncFixtures> ({
  shopContent: '',
  forceFullSync: async ({shopContent}, use) => {
    shopContent.forEach((content) => {
      test.step(`Force ${content} sync status to "synced"`, async () => {

        const isAlreadySync = await prisma.ps_eventbus_type_sync.findUnique({
          where: {
            type_id_shop_lang_iso: {
              type: content,
              id_shop: 1,
              lang_iso: 'en'
            }
          }
        });

        if (isAlreadySync) {
          console.info(colorText(`[INFO] ${content} already synced`, ["bold", "yellow", "italic"]));
        }
        else {
          await prisma.ps_eventbus_type_sync.create({data:  {
              type: content,
              offset: 0,
              id_shop: 1,
              lang_iso: 'en',
              full_sync_finished: true,
              last_sync_date: new Date()
            }});
        }
      });
    })

    await use(shopContent);
  }
});
