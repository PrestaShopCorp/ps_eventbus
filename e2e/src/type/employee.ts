import fixture from '../fixtures/apiEmployees/employees.json'

export type Employee = {
    id: string;
    collection: string;
    properties: {
      active: boolean;
      bo_color?: number;
      bo_css: string;
      bo_menu: boolean;
      bo_theme: string;
      bo_width: number;
      default_tab: number;
      email_hash: string;
      has_enabled_gravatar: boolean;
      id_employee: number;
      id_lang: number;
      id_last_customer: number;
      id_last_customer_message: number;
      id_last_order: number;
      id_profile: number;
      id_shop: number;
      last_connection_date?: string;
      optin: boolean;
    }
}

// assert
const employee: Employee[] = fixture;
