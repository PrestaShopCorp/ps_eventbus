import R from "ramda";
import {Controller, PsEventbusSyncUpload} from "./mock-probe";

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
