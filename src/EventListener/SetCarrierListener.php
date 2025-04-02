<?php

namespace PrestaShop\Module\PsEventbus\EventListener;

use PrestaShop\PrestaShop\Core\Domain\Product\Command\SetCarriersCommand;
use PrestaShop\PrestaShop\Core\Domain\Product\CommandHandler\SetCarriersHandlerInterface;

class SetCarrierListener implements SetCarriersHandlerInterface
{
    public function handle(SetCarriersCommand $command): void {
        $idProduct = $command->getProductId()->getValue();

        $carrierReferences = $command->getCarrierReferenceIds(); // Tableau des ID de transporteurs
        // ⚠️ Tu peux loguer les données pour debug
        \PrestaShopLogger::addLog("SetCarrierCommand intercepted: Product ID = $idProduct, Carriers = " . implode(',', $carrierReferences));
    }
}
