import R from "ramda";
import {PsEventbusSyncUpload} from "./mock-probe";

/**
 * sort upload data by collection and id to allow easier comparison
 */
export const sortUploadData: (data : PsEventbusSyncUpload) => PsEventbusSyncUpload = R.pipe(
  R.sortBy(R.prop('collection')),
  R.sortBy(R.prop('id')),
)
