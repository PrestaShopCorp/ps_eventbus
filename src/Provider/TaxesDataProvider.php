<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use Language;
use PrestaShop\Module\PsEventbus\DTO\Carrier as EventBusCarrier;
use PrestaShop\Module\PsEventbus\DTO\Tax;
use PrestaShop\Module\PsEventbus\DTO\TaxGroup;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\TaxRepository;
use Tax as PsTax;
use TaxRule;
use TaxRulesGroup;

class TaxesDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var TaxRepository
     */
    private $taxRepository;

    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;

    public function __construct(
        ConfigurationRepository $configurationRepository,
        TaxRepository $taxRepository
    ) {
        $this->taxRepository = $taxRepository;
        $this->configurationRepository = $configurationRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        return $this->createTaxRules();
    }

    /**
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function getFormattedDataIncremental($limit, $langIso)
    {
        $taxesIncremental = $this->taxRepository->getTaxesIncremental('taxes', $langIso);

        if (!$taxesIncremental) {
            return [];
        }

        $taxRules = $this->createTaxRules();

        return [
            'ids' => 0,
            'data' => $taxRules,
        ];
    }

    public function getRemainingObjectsCount($offset, $langIso)
    {
        return 0;
    }

    public function createTaxRules()
    {
        $language = new Language($this->configurationRepository->get('PS_LANG_DEFAULT'));

        $taxRules = [];
        $taxRulesGroups = \TaxRulesGroup::getTaxRulesGroups(true);
        foreach ($taxRulesGroups as $rulesGroup) {
            $taxGroup = $this->createTaxGroup($rulesGroup['id_tax_rules_group'], $language->id);
            $taxes = $this->createTaxes($rulesGroup['id_tax_rules_group'], $language->id);
            $taxGroup->setTaxes($taxes);
            $taxRules[] = $taxGroup;
        }

        $formattedTaxRules = [];
        /* @var EventBusCarrier $eventBusCarrier */
        foreach ($taxRules as $taxRule) {
            $formattedTaxRules = array_merge($formattedTaxRules, $taxRule->jsonSerialize());
        }

        return $formattedTaxRules;
    }

    /**
     * @param int $taxRulesGroupId
     * @param int $langId
     *
     * @return TaxGroup
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    private function createTaxGroup($taxRulesGroupId, $langId)
    {
        $taxRulesGroup = new TaxRulesGroup($taxRulesGroupId, $langId);

        $taxGroup = new TaxGroup();
        $taxGroup->setTaxRulesGroupId($taxRulesGroup->id);
        $taxGroup->setName($taxRulesGroup->name);
        $taxGroup->setShopId($langId);
        $taxGroup->setActive($taxRulesGroup->active);
        $taxGroup->setDeleted($taxRulesGroup->deleted);

        return $taxGroup;
    }

    /**
     * @param int $taxRulesGroupId
     * @param int $langId
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    private function createTaxes($taxRulesGroupId, $langId)
    {
        $taxRules = \TaxRule::getTaxRulesByGroupId($langId, $taxRulesGroupId);

        $taxes = [];
        foreach ($taxRules as $taxRule) {
            $taxRule = new TaxRule($taxRule['id_tax_rule']);
            $psTax = new PsTax($taxRule->id_tax, $langId);
            $tax = new Tax();
            $tax
                ->setTaxId($psTax->id)
                ->setTaxRulesGroupId($taxRulesGroupId)
                ->setName($psTax->name)
                ->setRate($psTax->rate)
                ->setActive((bool) $psTax->active)
                ->setDeleted((bool) $psTax->deleted);
            $taxes[] = $tax;
        }

        return $taxes;
    }
}
