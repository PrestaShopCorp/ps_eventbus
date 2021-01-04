<?php

namespace PrestaShop\Module\PsEventbus\Factory;

class Link
{
    /**
     * @return \Link
     */
    public static function get()
    {
        return \Context::getContext()->link;
    }
}
