import fixture from '../fixtures/latest/order_histories.json'

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: OrderHistory[] = fixture;

export type OrderHistory = {
  id: number,
  collection: string,
  properties: {
    created_at: string;
    date_add: string;
    id_order: number;
    id_order_history: number;
    id_order_state: number;
    is_deleted: boolean;
    is_delivered: boolean;
    is_paid: boolean;
    is_shipped: boolean;
    is_validated: boolean;
    name: string;
    template: string;
    updated_at: string;
  };
};
