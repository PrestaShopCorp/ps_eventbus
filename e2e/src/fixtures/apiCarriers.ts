import {Carrier} from '../type/carrier';
import {Carrier_detail} from '../type/carrier-details';

export const carriers_full: Carrier[] = [
  {
    collection: 'carriers',
    id: '1',
    properties: {
      active: true,
      carrier_taxes_rates_group_id: '1',
      currency: 'EUR',
      delay: 'Pick up in-store',
      deleted: false,
      disable_carrier_when_out_of_range: false,
      external_module_name: '',
      free_shipping_starts_at_price: 0,
      free_shipping_starts_at_weight: 0,
      grade: 0,
      id_carrier: '1',
      id_reference: '1',
      is_free: true,
      is_module: false,
      max_depth: 0,
      max_height: 0,
      max_weight: 0,
      max_width: 0,
      name: 'Click and collect',
      need_range: false,
      shipping_external: false,
      shipping_handling: 0,
      url: '',
      weight_unit: 'kg'
    }
  },
  {
    collection: 'carriers',
    id: '2',
    properties: {
      active: true,
      carrier_taxes_rates_group_id: '1',
      currency: 'EUR',
      delay: 'Delivery next day!',
      deleted: false,
      disable_carrier_when_out_of_range: false,
      external_module_name: '',
      free_shipping_starts_at_price: 0,
      free_shipping_starts_at_weight: 0,
      grade: 0,
      id_carrier: '2',
      id_reference: '2',
      is_free: false,
      is_module: false,
      max_depth: 0,
      max_height: 0,
      max_weight: 0,
      max_width: 0,
      name: 'My carrier',
      need_range: false,
      shipping_external: false,
      shipping_handling: 2,
      url: '',
      weight_unit: 'kg'
    }
  },
  {
    collection: 'carriers',
    id: '3',
    properties: {
      active: false,
      carrier_taxes_rates_group_id: '1',
      currency: 'EUR',
      delay: 'Buy more to pay less!',
      deleted: false,
      disable_carrier_when_out_of_range: false,
      external_module_name: '',
      free_shipping_starts_at_price: 0,
      free_shipping_starts_at_weight: 0,
      grade: 0,
      id_carrier: '3',
      id_reference: '3',
      is_free: false,
      is_module: false,
      max_depth: 0,
      max_height: 0,
      max_weight: 0,
      max_width: 0,
      name: 'My cheap carrier',
      need_range: false,
      shipping_external: false,
      shipping_handling: 2,
      url: '',
      weight_unit: 'kg'
    }
  },
  {
    collection: 'carriers',
    id: '4',
    properties: {
      active: false,
      carrier_taxes_rates_group_id: '1',
      currency: 'EUR',
      delay: 'The lighter the cheaper!',
      deleted: false,
      disable_carrier_when_out_of_range: false,
      external_module_name: '',
      free_shipping_starts_at_price: 0,
      free_shipping_starts_at_weight: 0,
      grade: 0,
      id_carrier: '4',
      id_reference: '4',
      is_free: false,
      is_module: false,
      max_depth: 0,
      max_height: 0,
      max_weight: 0,
      max_width: 0,
      name: 'My light carrier',
      need_range: false,
      shipping_external: false,
      shipping_handling: 2,
      url: '',
      weight_unit: 'kg'
    }
  },
]

export const carrier_details_full: Carrier_detail[] = [
  {
    collection: 'carrier_details',
    id: '3-1-range_price-2',
    properties: {
      country_ids: 'FR',
      delimiter1: 0,
      delimiter2: 50,
      id_carrier_detail: '2',
      id_range: '2',
      id_reference: '3',
      id_zone: '1',
      price: 3,
      shipping_method: 'range_price',
      state_ids: ''
    }
  },
  {
    collection: 'carrier_details',
    id: '3-2-range_price-2',
    properties: {
      country_ids: 'US',
      delimiter1: 0,
      delimiter2: 50,
      id_carrier_detail: '2',
      id_range: '2',
      id_reference: '3',
      id_zone: '2',
      price: 4,
      shipping_method: 'range_price',
      state_ids: 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC'
    }
  },
  {
    collection: 'carrier_details',
    id: '3-2-range_price-3',
    properties: {
      country_ids: 'US',
      delimiter1: 50,
      delimiter2: 100,
      id_carrier_detail: '3',
      id_range: '3',
      id_reference: '3',
      id_zone: '2',
      price: 2,
      shipping_method: 'range_price',
      state_ids: 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC'
    }
  },
  {
    collection: 'carrier_details',
    id: '3-1-range_price-3',
    properties: {
      country_ids: 'FR',
      delimiter1: 50,
      delimiter2: 100,
      id_carrier_detail: '3',
      id_range: '3',
      id_reference: '3',
      id_zone: '1',
      price: 1,
      shipping_method: 'range_price',
      state_ids: ''
    }
  },
  {
    collection: 'carrier_details',
    id: '3-1-range_price-4',
    properties: {
      country_ids: 'FR',
      delimiter1: 100,
      delimiter2: 200,
      id_carrier_detail: '4',
      id_range: '4',
      id_reference: '3',
      id_zone: '1',
      price: 0,
      shipping_method: 'range_price',
      state_ids: ''
    }
  },
  {
    collection: 'carrier_details',
    id: '3-2-range_price-4',
    properties: {
      country_ids: 'US',
      delimiter1: 100,
      delimiter2: 200,
      id_carrier_detail: '4',
      id_range: '4',
      id_reference: '3',
      id_zone: '2',
      price: 0,
      shipping_method: 'range_price',
      state_ids: 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC'
    }
  },
  {
    collection: 'carrier_details',
    id: '4-1-range_weight-2',
    properties: {
      country_ids: 'FR',
      delimiter1: 0,
      delimiter2: 1,
      id_carrier_detail: '2',
      id_range: '2',
      id_reference: '4',
      id_zone: '1',
      price: 0,
      shipping_method: 'range_weight',
      state_ids: ''
    }
  },
  {
    collection: 'carrier_details',
    id: '4-2-range_weight-2',
    properties: {
      country_ids: 'US',
      delimiter1: 0,
      delimiter2: 1,
      id_carrier_detail: '2',
      id_range: '2',
      id_reference: '4',
      id_zone: '2',
      price: 0,
      shipping_method: 'range_weight',
      state_ids: 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC'
    }
  },
  {
    collection: 'carrier_details',
    id: '4-2-range_weight-3',
    properties: {
      country_ids: 'US',
      delimiter1: 1,
      delimiter2: 3,
      id_carrier_detail: '3',
      id_range: '3',
      id_reference: '4',
      id_zone: '2',
      price: 3,
      shipping_method: 'range_weight',
      state_ids: 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC'
    }
  },
  {
    collection: 'carrier_details',
    id: '4-1-range_weight-3',
    properties: {
      country_ids: 'FR',
      delimiter1: 1,
      delimiter2: 3,
      id_carrier_detail: '3',
      id_range: '3',
      id_reference: '4',
      id_zone: '1',
      price: 2,
      shipping_method: 'range_weight',
      state_ids: ''
    }
  },
  {
    collection: 'carrier_details',
    id: '4-1-range_weight-4',
    properties: {
      country_ids: 'FR',
      delimiter1: 3,
      delimiter2: 10000,
      id_carrier_detail: '4',
      id_range: '4',
      id_reference: '4',
      id_zone: '1',
      price: 5,
      shipping_method: 'range_weight',
      state_ids: ''
    }
  },
  {
    collection: 'carrier_details',
    id: '4-2-range_weight-4',
    properties: {
      country_ids: 'US',
      delimiter1: 3,
      delimiter2: 10000,
      id_carrier_detail: '4',
      id_range: '4',
      id_reference: '4',
      id_zone: '2',
      price: 6,
      shipping_method: 'range_weight',
      state_ids: 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC'
    }
  },
  {
    collection: 'carrier_details',
    id: '2-1-range_weight-1',
    properties: {
      country_ids: 'FR',
      delimiter1: 0,
      delimiter2: 10000,
      id_carrier_detail: '1',
      id_range: '1',
      id_reference: '2',
      id_zone: '1',
      price: 5,
      shipping_method: 'range_weight',
      state_ids: ''
    }
  },
  {
    collection: 'carrier_details',
    id: '2-2-range_weight-1',
    properties: {
      country_ids: 'US',
      delimiter1: 0,
      delimiter2: 10000,
      id_carrier_detail: '1',
      id_range: '1',
      id_reference: '2',
      id_zone: '2',
      price: 5,
      shipping_method: 'range_weight',
      state_ids: 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC'
    }
  }
]
