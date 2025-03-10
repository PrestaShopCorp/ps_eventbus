import fixture from '../fixtures/latest/manufacturers.json';

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: Manufacturers[] = fixture;

export type Manufacturers = {
    id: number;
    collection: string;
    properties: {
        id_manufacturer: number;
        name: string;
        created_at: string;
        updated_at: string;
        active: boolean;
        id_lang: number;
        description: string;
        short_description: string;
        meta_title: string;
        meta_keywords: string;
        meta_description: string;
        id_shop: number;
    };
};
