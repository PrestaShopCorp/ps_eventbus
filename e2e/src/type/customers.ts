import fixture from "../fixtures/latest/apiCustomers/customers.json";

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: Customers[] = fixture;

export type Customers = {
  id: string;
  collection: string;
  properties: {
    active: boolean;
    created_at: string;
    deleted: boolean;
    email_hash: string;
    id_customer: number;
    id_lang: number;
    is_guest: boolean;
    newsletter: boolean;
    newsletter_date_add?: string;
    optin: boolean;
    updated_at: string;
  };
};
