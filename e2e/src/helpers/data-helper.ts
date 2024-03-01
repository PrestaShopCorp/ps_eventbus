import R from "ramda";
import {PsEventbusSyncUpload} from "./mock-probe";
import {Content, contentControllerMapping, Controller} from "../type/controllers";
import fs from "fs";
import {of} from "rxjs";

/**
 * sort upload data by collection and id to allow easier comparison
 * @param data ps_eventbus upload data
 */
export const sortUploadData: (data: PsEventbusSyncUpload[]) => PsEventbusSyncUpload[] = R.pipe(
  R.sortBy(R.prop('collection')),
  R.sortBy(R.prop('id')),
)

/**
 * modules returned by ps_eventbus use their database it as their collection id, which makes it random.
 * this function provides a way to generate a predictable replacement id.
 * @param data
 */
export function generatePredictableModuleId(data: PsEventbusSyncUpload[]): PsEventbusSyncUpload[] {
  return data.map(it => ({...it, id: `${it.properties.name}`}));
}

export function omitProperties(data: PsEventbusSyncUpload[], omitFields: string[]): PsEventbusSyncUpload[] {
  return data.map(it => ({
    ...it,
    properties: R.omit(omitFields, it.properties)
  }))
}

export function getControllerContent(controller: Controller): Content[] {
  return Object.entries(contentControllerMapping)
    .filter(it => it[1] === controller)
    .map(it => it[0]) as Content[];
}

export async function loadFixture(controller: Controller): Promise<PsEventbusSyncUpload[]> {
  const contents = getControllerContent(controller);
  const fixture = [];

  const files = contents.map(content => fs.promises.readFile(`./src/fixtures/${controller}/${content}.json`, 'utf-8'));
  for await (const file of files) {
      fixture.push(...JSON.parse(file))
  }
  return fixture;
}
