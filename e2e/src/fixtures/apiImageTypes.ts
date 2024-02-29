import {ImageType} from '../type/image-type';

export const image_types_full: ImageType[] = [
  {
    id: '1',
    collection: 'images',
    properties: {
      id_image_type: 1,
      name: 'cart_default',
      width: 125,
      height: 125,
      products: true,
      categories: false,
      manufacturers: false,
      suppliers: false,
      stores: false
    }
  },
  {
    id: '2',
    collection: 'images',
    properties: {
      id_image_type: 2,
      name: 'small_default',
      width: 98,
      height: 98,
      products: true,
      categories: true,
      manufacturers: true,
      suppliers: true,
      stores: false
    }
  },
  {
    id: '3',
    collection: 'images',
    properties: {
      id_image_type: 3,
      name: 'medium_default',
      width: 452,
      height: 452,
      products: true,
      categories: false,
      manufacturers: true,
      suppliers: true,
      stores: false
    }
  },
  {
    id: '4',
    collection: 'images',
    properties: {
      id_image_type: 4,
      name: 'home_default',
      width: 250,
      height: 250,
      products: true,
      categories: false,
      manufacturers: false,
      suppliers: false,
      stores: false
    }
  },
  {
    id: '5',
    collection: 'images',
    properties: {
      id_image_type: 5,
      name: 'large_default',
      width: 800,
      height: 800,
      products: true,
      categories: false,
      manufacturers: true,
      suppliers: true,
      stores: false
    }
  },
  {
    id: '6',
    collection: 'images',
    properties: {
      id_image_type: 6,
      name: 'category_default',
      width: 141,
      height: 180,
      products: false,
      categories: true,
      manufacturers: false,
      suppliers: false,
      stores: false
    }
  },
  {
    id: '7',
    collection: 'images',
    properties: {
      id_image_type: 7,
      name: 'stores_default',
      width: 170,
      height: 115,
      products: false,
      categories: false,
      manufacturers: false,
      suppliers: false,
      stores: true
    }
  }
]
