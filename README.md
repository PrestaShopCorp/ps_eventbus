# ps_eventbus

Module companion for EventBus

## Architecture

ps_eventbus receives an input request from the eventbus processor, and pushes objects from the Prestashop database to the eventbus proxy. More information in the [miro board of the Eventbus project](https://miro.com/app/board/o9J_ksqp-sc=).

## API Endpoints

### Open routes

* `/apiHealthCheck`

### Authenticated routes (with `job_id`)

* `/apiCarriers`
* `/apiCarts`
* `/apiCategories`
* `/apiInfo`
* `/apiModules`
* `/apiOrders`
* `/apiProducts`
* `/apiGoogleTaxonomies`
* `/apiThemes`
