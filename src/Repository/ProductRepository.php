<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ProductRepository
{
    /**
     * @var \Context
     */
    private $context;
    /**
     * @var \Db
     */
    private $db;

    /**
     * @var int
     */
    private $shopId;

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;

        if (!$this->context->employee instanceof \Employee) {
            if (($employees = \Employee::getEmployees()) !== false) {
                $this->context->employee = new \Employee($employees[0]['id_employee']);
            }
        }

        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
    }

    /**
     * @param int $langId
     *
     * @return \DbQuery
     */
    private function getBaseQuery($langId)
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopIdGroup = (int) $this->context->shop->id_shop_group;

        $query = new \DbQuery();

        $query->from('product', 'p')
            ->innerJoin('product_shop', 'ps', 'ps.id_product = p.id_product AND ps.id_shop = ' . $this->shopId)
            ->innerJoin('product_lang', 'pl', 'pl.id_product = ps.id_product AND pl.id_shop = ps.id_shop AND pl.id_lang = ' . (int) $langId)
            ->leftJoin('product_attribute_shop', 'pas', 'pas.id_product = p.id_product AND pas.id_shop = ps.id_shop')
            ->leftJoin('product_attribute', 'pa', 'pas.id_product_attribute = pa.id_product_attribute')
            ->leftJoin('category_lang', 'cl', 'ps.id_category_default = cl.id_category AND ps.id_shop = cl.id_shop AND cl.id_lang = ' . (int) $langId)
            ->leftJoin('manufacturer', 'm', 'p.id_manufacturer = m.id_manufacturer');

        if ($this->context->shop->getGroup()->share_stock) {
            $query->leftJoin('stock_available', 'sa', 'sa.id_product = p.id_product AND
             sa.id_product_attribute = IFNULL(pas.id_product_attribute, 0) AND sa.id_shop_group = ' . $shopIdGroup);
        } else {
            $query->leftJoin('stock_available', 'sa', 'sa.id_product = p.id_product AND
             sa.id_product_attribute = IFNULL(pas.id_product_attribute, 0) AND sa.id_shop = ps.id_shop');
        }

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $langId
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProducts($offset, $limit, $langId)
    {
        $query = $this->getBaseQuery($langId);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param int $offset
     * @param int $langId
     *
     * @return int
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getRemainingProductsCount($offset, $langId)
    {
        $products = $this->getProducts($offset, 1, $langId);

        if (!is_array($products) || empty($products)) {
            return 0;
        }

        return count($products);
    }

    /**
     * @param array<mixed> $attributeIds
     * @param int $langId
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductAttributeValues($attributeIds, $langId)
    {
        if (!$attributeIds) {
            return [];
        }
        $query = new \DbQuery();

        $query->select('pas.id_product_attribute, agl.name as name, al.name as value')
            ->from('product_attribute_shop', 'pas')
            ->leftJoin('product_attribute_combination', 'pac', 'pac.id_product_attribute = pas.id_product_attribute')
            ->leftJoin('attribute', 'a', 'a.id_attribute = pac.id_attribute')
            ->leftJoin('attribute_group_lang', 'agl', 'agl.id_attribute_group = a.id_attribute_group AND agl.id_lang = ' . (int) $langId)
            ->leftJoin('attribute_lang', 'al', 'al.id_attribute = pac.id_attribute AND al.id_lang = agl.id_lang')
            ->where('pas.id_product_attribute IN (' . implode(',', array_map('intval', $attributeIds)) . ') AND pas.id_shop = ' . $this->shopId);

        $attributes = $this->db->executeS($query);

        if (is_array($attributes)) {
            $resultArray = [];

            foreach ($attributes as $attribute) {
                $resultArray[$attribute['id_product_attribute']][$attribute['name']] = $attribute['value'];
            }

            return $resultArray;
        }

        return [];
    }

    /**
     * @param array<mixed> $productIds
     * @param int $langId
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductFeatures($productIds, $langId)
    {
        if (!$productIds) {
            return [];
        }

        $query = new \DbQuery();

        $query->select('fp.id_product, fl.name, fvl.value')
            ->from('feature_product', 'fp')
            ->leftJoin('feature_lang', 'fl', 'fl.id_feature = fp.id_feature AND fl.id_lang = ' . (int) $langId)
            ->leftJoin('feature_value_lang', 'fvl', 'fvl.id_feature_value = fp.id_feature_value AND fvl.id_lang = fl.id_lang')
            ->where('fp.id_product IN (' . implode(',', array_map('intval', $productIds)) . ')');

        $features = $this->db->executeS($query);

        if (is_array($features)) {
            $resultArray = [];

            foreach ($features as $feature) {
                $resultArray[$feature['id_product']][$feature['name']] = $feature['value'];
            }

            return $resultArray;
        }

        return [];
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
        if (!$productIds) {
            return [];
        }

        $query = new \DbQuery();

        $query->select('imgs.id_product, imgs.id_image, IFNULL(imgs.cover, 0) as cover')
            ->from('image_shop', 'imgs')
            ->where('imgs.id_shop = ' . $this->shopId . ' AND imgs.id_product IN (' . implode(',', array_map('intval', $productIds)) . ')');

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
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
        if (!$attributeIds) {
            return [];
        }
        $query = new \DbQuery();

        $query->select('id_product_attribute, id_image')
            ->from('product_attribute_image', 'pai')
            ->where('pai.id_product_attribute IN (' . implode(',', array_map('intval', $attributeIds)) . ')');

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param int $productId
     * @param int $attributeId
     *
     * @return float|null
     */
    public function getPriceTaxExcluded($productId, $attributeId)
    {
        return \Product::getPriceStatic($productId, false, $attributeId, 6, null, false, false);
    }

    /**
     * @param int $productId
     * @param int $attributeId
     *
     * @return float|null
     */
    public function getPriceTaxIncluded($productId, $attributeId)
    {
        return \Product::getPriceStatic($productId, true, $attributeId, 6, null, false, false);
    }

    /**
     * @param int $productId
     * @param int $attributeId
     *
     * @return float|null
     */
    public function getSalePriceTaxExcluded($productId, $attributeId)
    {
        return \Product::getPriceStatic($productId, false, $attributeId, 6);
    }

    /**
     * @param int $productId
     * @param int $attributeId
     *
     * @return float|null
     */
    public function getSalePriceTaxIncluded($productId, $attributeId)
    {
        return \Product::getPriceStatic($productId, true, $attributeId, 6);
    }

    /**
     * @param int $limit
     * @param int $langId
     * @param array<mixed> $productIds
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductsIncremental($limit, $langId, $productIds)
    {
        $query = $this->getBaseQuery($langId);

        $this->addSelectParameters($query);

        $query->where('p.id_product IN(' . implode(',', array_map('intval', $productIds)) . ')')
            ->limit($limit);

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $langId
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langId)
    {
        $query = $this->getBaseQuery($langId);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $query->build());

        return array_merge(
            (array) $query,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('p.id_product, p.id_manufacturer, p.id_supplier, IFNULL(pas.id_product_attribute, 0) as id_attribute, pas.default_on as is_default_attribute');
        $query->select('pl.name, pl.description, pl.description_short, pl.link_rewrite, cl.name as default_category');
        $query->select('ps.id_category_default, IFNULL(NULLIF(pa.reference, ""), p.reference) as reference, IFNULL(NULLIF(pa.upc, ""), p.upc) as upc');
        $query->select('IFNULL(NULLIF(pa.ean13, ""), p.ean13) as ean, ps.condition, ps.visibility, ps.active, sa.quantity, m.name as manufacturer');
        $query->select('(p.weight + IFNULL(pas.weight, 0)) as weight, (ps.price + IFNULL(pas.price, 0)) as price_tax_excl');
        $query->select('p.date_add as created_at, p.date_upd as updated_at');
        $query->select('p.available_for_order, p.available_date, p.cache_is_pack as is_bundle, p.is_virtual');
        $query->select('p.unity, p.unit_price_ratio');

        if (property_exists(new \Product(), 'mpn')) {
            $query->select('p.mpn');
        }

        // https://github.com/PrestaShop/PrestaShop/commit/10268af8db4163dc2a02edb8da93d02f37f814d8#diff-e94a594ba740485c7a4882b333984d3932a2f99c0d6d0005620745087cce7a10R260
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.3.0', '>=')) {
            $query->select('p.additional_delivery_times');
            $query->select('pl.delivery_in_stock, pl.delivery_out_stock');
        }

        $query->select('p.width, p.height, p.depth, p.additional_shipping_cost');

        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '>=')) {
            $query->select('IFNULL(NULLIF(pa.isbn, ""), p.isbn) as isbn');
        }
    }
}
