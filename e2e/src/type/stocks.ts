import fixture from '../fixtures/latest/apiStocks/stocks.json'

// test type
const t: Stocks[] = fixture;

export type Stocks = {
  id: number,
  collection: string,
  properties: {
    id_stock_available: number,
    id_product: number,
    id_product_attribute: number,
    id_shop: number,
    id_shop_group: number,
    quantity: number,
    physical_quantity: number,
    reserved_quantity: number,
    depends_on_stock: boolean,
    out_of_stock: boolean,
    location: string
  }
}
