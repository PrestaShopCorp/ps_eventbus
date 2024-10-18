import fixture from "../fixtures/latest/apiImageTypes/image_types.json";

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: ImageType[] = fixture;

export type ImageType = {
  id: string;
  collection: string;
  properties: {
    id_image_type: number;
    name: string;
    width: number;
    height: number;
    products: boolean;
    categories: boolean;
    manufacturers: boolean;
    suppliers: boolean;
    stores: boolean;
  };
};
