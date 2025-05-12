import fixture from '../../V2/src/data/fixtures/latest/carts.json';

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: Carts[] = fixture;

export type Carts = {
    id: string;
    collection: string;
    properties: {
        id_cart: string;
        created_at: string;
        updated_at: string;
    };
};
