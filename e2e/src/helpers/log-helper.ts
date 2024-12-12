import { AxiosError } from "axios";
import R from "ramda";
import fs from "fs";
import testConfig from "./test.config";
import { PsEventbusSyncUpload } from "./mock-probe";
import { getShopHealthCheck } from "./data-helper";

export function logAxiosError(err: Error) {
  if (err instanceof AxiosError) {
    const data = {
      ...R.pick(["url"], err.response.config),
      ...R.pick(["status", "statusText", "data"], err.response),
    };

    console.log(data);
  }
}

export async function dumpUploadData(data: PsEventbusSyncUpload[]) {
  const shopVersion = (await getShopHealthCheck()).prestashop_version;
  const dir = `./dumps/${testConfig.testRunTime}/${shopVersion}`;

  await fs.promises.mkdir(dir, { recursive: true });
  const groupedData = R.groupBy((el) => el.collection, data);
  const files = Object.keys(groupedData).map((collection) => {
    return fs.promises.writeFile(
      `${dir}/${collection}.json`,
      JSON.stringify(groupedData[collection], null, 2) + "\n",
    );
  });
  await Promise.all(files);
}
