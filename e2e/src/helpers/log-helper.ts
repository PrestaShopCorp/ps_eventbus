import {AxiosError} from "axios";
import R from "ramda";
import fs from "fs";
import testConfig from "./test.config";
import {PsEventbusSyncUpload} from "./mock-probe";

export function logAxiosError(err: Error) {
  if(err instanceof AxiosError) {
    console.log(R.pick(['status', 'statusText' ,'data',], err.response))
  }
}

export async function dumpUploadData(data: PsEventbusSyncUpload[], filename: string) {
  const dir = `./dumps/${testConfig.testRunTime}/${filename}`;
  await fs.promises.mkdir(dir, {recursive: true});
  const groupedData = R.groupBy( el => el.collection, data )
  Object.keys(groupedData).map(collection => {
    return fs.promises.writeFile(`${dir}/${collection}.json`,
      JSON.stringify(groupedData[collection], null, 2) + '\n');
  })
}
