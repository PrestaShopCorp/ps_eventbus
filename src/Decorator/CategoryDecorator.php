<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class CategoryDecorator
{
    /**
     * @param array $categories
     *
     * @return void
     */
    public function decorateCategories(&$categories)
    {
        foreach ($categories as &$category) {
            $this->castPropertyValues($category);
            $this->formatDescription($category);
        }
    }

    /**
     * @param array $category
     *
     * @return void
     */
    private function castPropertyValues(&$category)
    {
        $category['id_category'] = (int) $category['id_category'];
        $category['id_parent'] = (int) $category['id_parent'];
    }

    /**
     * @param array $category
     *
     * @return void
     */
    private function formatDescription(&$category)
    {
        $category['description'] = base64_encode($category['description']);
    }
}
