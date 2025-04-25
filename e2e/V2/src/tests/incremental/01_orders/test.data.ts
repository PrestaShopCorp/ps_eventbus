import {
  dataAddresses,
  dataCustomers, dataOrderStatuses, dataPaymentMethods,
  dataProducts,
  dataZones,
  FakerAddress,
  FakerCarrier,
  FakerOrder
} from "@prestashop-core/ui-testing";
import {faker} from "@faker-js/faker";

const superAddressName = `Eventbus ${faker.person.lastName()} address`

export const customerAddress: FakerAddress = new FakerAddress({
  name: superAddressName,
  alias: superAddressName,
  email: 'pub@prestashop.com',
  country: 'United Kingdom'
});

export const carrier: FakerCarrier = new FakerCarrier({
  // General settings
  name: `Eventbus ${faker.animal.dog()} Carrier`,
  speedGrade: 7,
  trackingURL: 'https://example.com/track.php?num=@',
  // Shipping locations and cost
  handlingCosts: false,
  freeShipping: false,
  billing: 'According to total weight',
  taxRule: 'No tax',
  outOfRangeBehavior: 'Apply the cost of the highest defined range',
  ranges: [
    {
      weightMin: 0,
      weightMax: 5,
      zones: [
        {
          zone: dataZones.europeNonEu,
          price: 3,
        },
        {
          zone: dataZones.europe,
          price: 5,
        },
        {
          zone: dataZones.northAmerica,
          price: 2,
        },
      ],
    },
    {
      weightMin: 5,
      weightMax: 10,
      zones: [
        {
          zone: dataZones.europeNonEu,
          price: 6,
        },
        {
          zone: dataZones.europe,
          price: 10,
        },
        {
          zone: dataZones.northAmerica,
          price: 4,
        },
      ],
    },
    {
      weightMin: 10,
      weightMax: 20,
      zones: [
        {
          zone: dataZones.europeNonEu,
          price: 9,
        },
        {
          zone: dataZones.europe,
          price: 20,
        },
        {
          zone: dataZones.northAmerica,
          price: 8,
        },
      ],
    },
  ],
  // Size weight and group access
  maxWidth: 200,
  maxHeight: 200,
  maxDepth: 200,
  maxWeight: 500,
  enable: true,
});

export const order: FakerOrder = new FakerOrder({
  customer: dataCustomers.johnDoe,
  products: [
    {
      product: dataProducts.demo_5,
      quantity: 4,
    },
  ],
  deliveryAddress: customerAddress,
  invoiceAddress: customerAddress,
  deliveryOption: {
    name: `${carrier.name} - ${carrier.transitName}`,
    freeShipping: true,
  },
  paymentMethod: dataPaymentMethods.checkPayment,
  status: dataOrderStatuses.paymentAccepted,
  totalPrice: (dataProducts.demo_5.priceTaxExcluded * 4) * 1.2, // Price tax included
});
