<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class ImageTypeDecorator
{
    /**
     * @param array<mixed> $imageTypes
     *
     * @return void
     */
    public function decorateImageTypes(&$imageTypes)
    {
        foreach ($imageTypes as &$imageType) {
            $this->castPropertyValues($imageType);
        }
    }

    /**
     * @param array<mixed> $imageType
     *
     * @return void
     */
    private function castPropertyValues(&$imageType)
    {
        $imageType['id_image_type'] = (int) $imageType['id_image_type'];
        $imageType['name'] = (string) $imageType['name'];
        $imageType['width'] = (int) $imageType['width'];
        $imageType['height'] = (int) $imageType['height'];
        $imageType['products'] = (bool) $imageType['products'];
        $imageType['categories'] = (bool) $imageType['categories'];
        $imageType['manufacturers'] = (bool) $imageType['manufacturers'];
        $imageType['suppliers'] = (bool) $imageType['suppliers'];
        $imageType['stores'] = (bool) $imageType['stores'];
    }
}
