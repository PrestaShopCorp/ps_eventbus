import fixture from '../fixtures/latest/modules.json';

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: Modules[] = fixture;

export type Modules = {
    id: string;
    collection: string;
    properties: {
        module_id: string;
        name: string;
        module_version: string;
        active: boolean;
        created_at: string;
        updated_at: string;
    };
};
