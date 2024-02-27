import {AxiosError} from "axios";
import R from "ramda";
import fs from "fs";
import testConfig from "./test.config";
import {expect} from "@jest/globals";

export function logAxiosError(err: Error) {
  if(err instanceof AxiosError) {
    console.log(R.pick(['status', 'statusText' ,'data',], err.response))
  }
}

export async function dumpData(data: any, filename: string) {
  const dir = `./dumps/${testConfig.testRunTime}`;
  await fs.promises.mkdir(dir, {recursive: true});
  await fs.promises.writeFile(`${dir}/${filename}.json`, JSON.stringify(data, null, 2));
}
