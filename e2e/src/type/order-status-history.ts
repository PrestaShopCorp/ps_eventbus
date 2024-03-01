import fixture from '../fixtures/apiOrders/order_status_history.json'

// test type
const t: OrderStatusHistory[] = fixture;

export type OrderStatusHistory = {
  id: number,
  collection: string,
  properties: {
    created_at: string,
    date_add: string,
    id_order: number,
    id_order_history: number,
    id_order_state: number,
    is_deleted: boolean,
    is_delivered: boolean,
    is_paid: boolean,
    is_shipped: boolean,
    is_validated: boolean,
    name: string,
    template: string,
    updated_at: string
  }
}
