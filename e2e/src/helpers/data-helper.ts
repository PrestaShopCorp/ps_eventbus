import R from "ramda";
import {PsEventbusSyncUpload} from "./mock-probe";

/**
 * sort upload data by collection and id to allow easier comparison
 * @param data ps_eventbus upload data
 */
export const sortUploadData: (data : PsEventbusSyncUpload[]) => PsEventbusSyncUpload[] = R.pipe(
  R.sortBy(R.prop('collection')),
  R.sortBy(R.prop('id')),
)
