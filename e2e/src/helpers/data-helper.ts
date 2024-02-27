import R from "ramda";
import {PsEventbusSyncUpload} from "./mock-probe";

/**
 * sort
 */
export const sortUploadData: (data : PsEventbusSyncUpload) => PsEventbusSyncUpload = R.pipe(
  R.sortBy(R.prop('collection')),
  R.sortBy(R.prop('id')),
)
