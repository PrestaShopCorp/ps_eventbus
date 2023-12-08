<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class ImageDecorator
{
    /**
     * @param array $images
     *
     * @return void
     */
    public function decorateImages(array &$images)
    {
        foreach ($images as &$image) {
            $this->castPropertyValues($image);
        }
    }

    /**
     * @param array $image
     *
     * @return void
     */
    private function castPropertyValues(array &$image)
    {
        $image['id_image'] = (int) $image['id_image'];
        $image['id_product'] = (int) $image['id_product'];
        $image['id_lang'] = (int) $image['id_lang'];
        $image['id_shop'] = (int) $image['id_shop'];
        $image['position'] = (int) $image['position'];
        $image['cover'] = (bool) $image['cover'];
        $image['legend'] = (string) $image['legend'];
    }
}
