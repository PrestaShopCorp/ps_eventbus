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

namespace PrestaShop\Module\PsEventbus\Formatter;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ArrayFormatter
{
    /**
     * @param array<mixed> $data
     * @param string $separator
     *
     * @return string
     */
    public function arrayToString($data, $separator = ';')
    {
        return implode($separator, $data);
    }

    /**
     * @param array<mixed> $data
     * @param string|int $key
     * @param bool $unique
     *
     * @return array<mixed>
     */
    public function formatValueArray($data, $key, $unique = null)
    {
        $result = array_map(function ($dataItem) use ($key) {
            return $dataItem[$key];
        }, $data);

        if ($unique) {
            return $this->unique($result);
        }

        return $result;
    }

    /**
     * @param array<mixed> $data
     *
     * @return array<mixed>
     */
    private function unique($data)
    {
        return array_unique($data);
    }

    /**
     * @param array<mixed> $data
     * @param string|int $key
     * @param string $separator
     *
     * @return string
     */
    public function formatValueString($data, $key, $separator = ';')
    {
        return implode($separator, $this->formatValueArray($data, $key));
    }
}
