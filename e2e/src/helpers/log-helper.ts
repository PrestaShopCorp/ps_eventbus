import {AxiosError} from "axios";
import R from "ramda";

export function logAxiosError(err: Error) {
  if(err instanceof AxiosError) {
    console.log(R.pick(['status', 'statusText' ,'data',], err.response))
  }
}
