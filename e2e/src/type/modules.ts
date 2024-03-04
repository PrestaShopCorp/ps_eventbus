import fixture from '../fixtures/apiModules/modules.json'

// test type
const t: Modules[] = fixture;

export type Modules = {
  id: string,
  collection: string,
  properties: {
    module_id: number,
    name: string,
    module_version: string,
    active: boolean,
    created_at: string,
    updated_at: string
  }
}
