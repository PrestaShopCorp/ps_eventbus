<?php

namespace PrestaShop\Module\PsEventbus\Formatter;

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
