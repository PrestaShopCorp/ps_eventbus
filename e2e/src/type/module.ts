export type Module =   {
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
