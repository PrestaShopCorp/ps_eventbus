<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'product';

    /**
     * @param string $langIso
     * @param bool $withSelecParameters
     *
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function generateFullQuery($langIso, $withSelecParameters)
    {
        $shopIdGroup = (int) parent::getShopContext()->id_shop_group;
        $langId = (int) \Language::getIdByIso($langIso);

        // WTF IS THAT ?
        if (!parent::getContext()->employee instanceof \Employee) {
            if (($employees = \Employee::getEmployees()) !== false) {
                parent::getContext()->employee = new \Employee($employees[0]['id_employee']);
            }
        }

        $this->generateMinimalQuery(self::TABLE_NAME, 'p');

        $this->query
            ->innerJoin('product_shop', 'ps', 'ps.id_product = p.id_product AND ps.id_shop = ' . parent::getShopContext()->id)
            ->innerJoin('product_lang', 'pl', 'pl.id_product = ps.id_product AND pl.id_shop = ps.id_shop AND pl.id_lang = ' . $langId)
            ->leftJoin('product_attribute_shop', 'pas', 'pas.id_product = p.id_product AND pas.id_shop = ps.id_shop')
            ->leftJoin('product_attribute', 'pa', 'pas.id_product_attribute = pa.id_product_attribute')
            ->leftJoin('category_lang', 'cl', 'ps.id_category_default = cl.id_category AND ps.id_shop = cl.id_shop AND cl.id_lang = ' . $langId)
            ->leftJoin('manufacturer', 'm', 'p.id_manufacturer = m.id_manufacturer');

        if (parent::getShopContext()->getGroup()->share_stock) {
            $this->query->leftJoin(
                'stock_available',
                'sa',
                'sa.id_product = p.id_product AND sa.id_product_attribute = IFNULL(pas.id_product_attribute, 0) AND sa.id_shop_group = ' . $shopIdGroup)
            ;
        } else {
            $this->query->leftJoin(
                'stock_available',
                'sa',
                'sa.id_product = p.id_product AND sa.id_product_attribute = IFNULL(pas.id_product_attribute, 0) AND sa.id_shop = ps.id_shop')
            ;
        }

        if ($withSelecParameters) {
            $this->query
                ->select('p.id_product')
                ->select('p.id_manufacturer')
                ->select('p.id_supplier')
                ->select('IFNULL(pas.id_product_attribute, 0) as id_attribute')
                ->select('pas.default_on as is_default_attribute')
                ->select('pl.name')
                ->select('pl.description')
                ->select('pl.description_short')
                ->select('pl.link_rewrite')
                ->select('cl.name as default_category')
                ->select('ps.id_category_default')
                ->select('IFNULL(NULLIF(pa.reference, ""), p.reference) as reference')
                ->select('IFNULL(NULLIF(pa.upc, ""), p.upc) as upc')
                ->select('IFNULL(NULLIF(pa.ean13, ""), p.ean13) as ean')
                ->select('ps.condition')
                ->select('ps.visibility')
                ->select('ps.active')
                ->select('sa.quantity')
                ->select('m.name as manufacturer')
                ->select('(p.weight + IFNULL(pas.weight, 0)) as weight')
                ->select('(ps.price + IFNULL(pas.price, 0)) as price_tax_excl')
                ->select('p.date_add as created_at')
                ->select('p.date_upd as updated_at')
                ->select('p.available_for_order')
                ->select('p.available_date')
                ->select('p.cache_is_pack as is_bundle')
                ->select('p.is_virtual')
                ->select('p.unity')
                ->select('p.unit_price_ratio')
                ->select('p.width')
                ->select('p.height')
                ->select('p.depth')
                ->select('p.additional_shipping_cost');

            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '>=')) {
                $this->query->select('IFNULL(NULLIF(pa.isbn, ""), p.isbn) as isbn');
            }

            // https://github.com/PrestaShop/PrestaShop/commit/10268af8db4163dc2a02edb8da93d02f37f814d8#diff-e94a594ba740485c7a4882b333984d3932a2f99c0d6d0005620745087cce7a10R260
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.3.0', '>=')) {
                $this->query
                    ->select('p.additional_delivery_times')
                    ->select('pl.delivery_in_stock')
                    ->select('pl.delivery_out_stock')
                ;
            }

            // https://github.com/PrestaShop/PrestaShop/commit/75fcc335a85c4e3acb2444ef9584590a59fc2d62#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R1615
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.7.0', '>=')) {
                $this->query->select('p.mpn');
            }
        }
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($offset, $limit, $langIso, $debug)
    {
        $this->generateFullQuery($langIso, true);

        $this->query->limit((int) $limit, (int) $offset);

        return $this->runQuery($debug);
    }

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $this->generateFullQuery($langIso, true);

        $this->query
            ->where('p.id_product IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit)
        ;

        return $this->runQuery($debug);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($offset, $limit, $langIso)
    {
        $this->generateFullQuery($langIso, false);

        $this->query->select('(COUNT(*) - ' . (int) $offset . ') as count');

        $result = $this->runQuery(false);

        return $result[0]['count'];
    }

    /**
     * @param array<mixed> $attributeIds
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductAttributeValues($attributeIds, $langIso)
    {
        $langId = (int) \Language::getIdByIso($langIso);

        $this->generateMinimalQuery('product_attribute_shop', 'pas');

        $this->query
            ->leftJoin('product_attribute_combination', 'pac', 'pac.id_product_attribute = pas.id_product_attribute')
            ->leftJoin('attribute', 'a', 'a.id_attribute = pac.id_attribute')
            ->leftJoin('attribute_group_lang', 'agl', 'agl.id_attribute_group = a.id_attribute_group AND agl.id_lang = ' . $langId)
            ->leftJoin('attribute_lang', 'al', 'al.id_attribute = pac.id_attribute AND al.id_lang = agl.id_lang')
            ->where('pas.id_product_attribute IN (' . implode(',', array_map('intval', $attributeIds)) . ') AND pas.id_shop = ' . parent::getShopContext()->id)
        ;

        $this->query
            ->select('pas.id_product_attribute, agl.name as name, al.name as value')
            ->select('agl.name as name')
            ->select('al.name as value')
        ;

        $attributes = $this->runQuery(false);

        $resultArray = [];

        foreach ($attributes as $attribute) {
            $resultArray[$attribute['id_product_attribute']][$attribute['name']] = $attribute['value'];
        }

        return $resultArray;

        /* return array_reduce($attributes, function ($key, $attribute) {
            return $attribute[$attribute['id_product_attribute']][$attribute['name']] = $attribute['value'];
        }); */
    }

    /**
     * @param array<mixed> $productIds
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductFeatures($productIds, $langIso)
    {
        $langId = (int) \Language::getIdByIso($langIso);

        $this->generateMinimalQuery('feature_product', 'fp');

        $this->query
            ->leftJoin('feature_lang', 'fl', 'fl.id_feature = fp.id_feature AND fl.id_lang = ' . $langId)
            ->leftJoin('feature_value_lang', 'fvl', 'fvl.id_feature_value = fp.id_feature_value AND fvl.id_lang = fl.id_lang')
            ->where('fp.id_product IN (' . implode(',', array_map('intval', $productIds)) . ')')
        ;

        $this->query
            ->select('fp.id_product')
            ->select('fl.name')
            ->select('fvl.value')
        ;

        $features = $this->runQuery(false);

        $resultArray = [];

        foreach ($features as $feature) {
            $resultArray[$feature['id_product']][$feature['name']] = $feature['value'];
        }

        return $resultArray;

        /* return array_reduce($features, function ($key, $feature) {
            return $feature[$feature['id_product']][$feature['name']] = $feature['value'];
        }); */
    }

    /**
     * @param array<mixed> $productIds
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductImages($productIds)
    {
        $this->generateMinimalQuery('image_shop', 'imgs');

        $this->query
            ->where('imgs.id_shop = ' . parent::getShopContext()->id . ' AND imgs.id_product IN (' . implode(',', array_map('intval', $productIds)) . ')');

        $this->query
            ->select('imgs.id_product, imgs.id_image, IFNULL(imgs.cover, 0) as cover')
            ->select('imgs.id_image')
            ->select('IFNULL(imgs.cover, 0) as cover')
        ;

        return $this->runQuery(false);
    }

    /**
     * @param array<mixed> $attributeIds
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getAttributeImages($attributeIds)
    {
        $this->generateMinimalQuery('product_attribute_image', 'pai');

        $this->query
            ->where('pai.id_product_attribute IN (' . implode(',', array_map('intval', $attributeIds)) . ')')
        ;

        $this->query
            ->select('id_product_attribute, id_image')
            ->select('id_image')
        ;

        return $this->runQuery(false);
    }
}
