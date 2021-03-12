<?php

namespace PrestaShop\Module\PsEventbus\Factory;

use Context;

class Link
{
    /**
     * @return \Link
     */
    public static function get()
    {
        return Context::getContext()->link;
    }
}
