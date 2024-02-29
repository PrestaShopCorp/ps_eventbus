import {Cart} from '../type/cart';
import {Cart_Product} from '../type/cart-product';

export const carts_full: Cart[] = [
  {
    id: '1',
    collection: 'carts',
    properties: {
      id_cart: '1',
      created_at: '2024-02-19T12:12:12+0100',
      updated_at: '2024-02-19T12:12:12+0100'
    }
  },
  {
    id: '2',
    collection: 'carts',
    properties: {
      id_cart: '2',
      created_at: '2024-02-19T12:12:12+0100',
      updated_at: '2024-02-19T12:12:12+0100'
    }
  },
  {
    id: '3',
    collection: 'carts',
    properties: {
      id_cart: '3',
      created_at: '2024-02-19T12:12:12+0100',
      updated_at: '2024-02-19T12:12:12+0100'
    }
  },
  {
    id: '4',
    collection: 'carts',
    properties: {
      id_cart: '4',
      created_at: '2024-02-19T12:12:12+0100',
      updated_at: '2024-02-19T12:12:12+0100'
    }
  },
  {
    id: '5',
    collection: 'carts',
    properties: {
      id_cart: '5',
      created_at: '2024-02-19T12:12:12+0100',
      updated_at: '2024-02-19T12:12:12+0100'
    }
  },

]

export const cart_products_full : Cart_Product[] = [
  {
    id: '1-1-1',
    collection: 'cart_products',
    properties: {
      id_cart: '1',
      id_product: '1',
      id_product_attribute: '1',
      quantity: 1,
      created_at: '-0001-11-30T00:00:00+0009',
      id_cart_product: '1-1-1'
    }
  },
  {
    id: '1-2-9',
    collection: 'cart_products',
    properties: {
      id_cart: '1',
      id_product: '2',
      id_product_attribute: '9',
      quantity: 1,
      created_at: '-0001-11-30T00:00:00+0009',
      id_cart_product: '1-2-9'
    }
  },
  {
    id: '2-4-18',
    collection: 'cart_products',
    properties: {
      id_cart: '2',
      id_product: '4',
      id_product_attribute: '18',
      quantity: 1,
      created_at: '-0001-11-30T00:00:00+0009',
      id_cart_product: '2-4-18'
    }
  },
  {
    id: '2-8-0',
    collection: 'cart_products',
    properties: {
      id_cart: '2',
      id_product: '8',
      id_product_attribute: '0',
      quantity: 1,
      created_at: '-0001-11-30T00:00:00+0009',
      id_cart_product: '2-8-0'
    }
  },
  {
    id: '3-16-28',
    collection: 'cart_products',
    properties: {
      id_cart: '3',
      id_product: '16',
      id_product_attribute: '28',
      quantity: 1,
      created_at: '-0001-11-30T00:00:00+0009',
      id_cart_product: '3-16-28'
    }
  },
  {
    id: '4-16-29',
    collection: 'cart_products',
    properties: {
      id_cart: '4',
      id_product: '16',
      id_product_attribute: '29',
      quantity: 1,
      created_at: '-0001-11-30T00:00:00+0009',
      id_cart_product: '4-16-29'
    }
  },
  {
    id: '5-10-25',
    collection: 'cart_products',
    properties: {
      id_cart: '5',
      id_product: '10',
      id_product_attribute: '25',
      quantity: 1,
      created_at: '-0001-11-30T00:00:00+0009',
      id_cart_product: '5-10-25'
    }
  }
]

