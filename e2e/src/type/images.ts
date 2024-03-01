import fixture from '../fixtures/apiImages/images.json'

// test type
const t: Images[] = fixture;

export type Images =   {
  "id": string,
  "collection": string,
  "properties": {
    "id_image": number,
    "id_product": number,
    "position": number,
    "cover": boolean,
    "id_lang": number,
    "legend": string,
    "id_shop": number
  }
}
