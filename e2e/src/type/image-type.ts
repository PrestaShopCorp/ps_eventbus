import fixture from '../fixtures/apiImageTypes/image_types.json'

// test type
const t: ImageType[] = fixture;

export type ImageType = {
  id: string,
  collection: string,
  properties: {
    id_image_type: number,
    name: string,
    width: number,
    height: number,
    products: boolean,
    categories: boolean,
    manufacturers: boolean,
    suppliers: boolean,
    stores: boolean
  }
}
