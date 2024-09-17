import fixture from "../fixtures/latest/categories.json"

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: Categories[] = fixture;

export type Categories = {
  id: string;
  collection: string;
  properties: {
    created_at: string;
    description: string;
    id_category: number;
    id_parent: number;
    iso_code: string;
    link_rewrite: string;
    meta_description: string;
    meta_keywords: string;
    meta_title: string;
    name: string;
    unique_category_id: string;
    updated_at: string;
  };
};
