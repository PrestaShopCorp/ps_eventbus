<?php

namespace PrestaShop\Module\PsEventbus\Formatter;

class JsonFormatter
{
    /**
     * @param array $data
     *
     * @return string
     */
    public function formatNewlineJsonString($data)
    {
        $jsonArray = array_map(function ($dataItem) {
            return json_encode($dataItem, JSON_UNESCAPED_SLASHES);
        }, $data);

        $json = implode("\r\n", $jsonArray);

        return str_replace('\\u0000', '', $json);
    }
}
