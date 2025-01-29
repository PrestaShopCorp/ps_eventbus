<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Api;

if (!defined('_PS_VERSION_')) {
    exit;
}

class HttpClientFactory
{
    /**
     * @var CurlWrapper
     */
    private $client;


    /**
     * @param int $timeout
     *
     * @return HttpClientFactory
     */
    public function __construct($timeout)
    {
        $this->client = new CurlWrapper();
        $this->client->setOpt(CURLOPT_TIMEOUT, $timeout);
        $this->client->setOpt(CURLOPT_CONNECTTIMEOUT, 10);
        $this->client->setopt(CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * Send HTTP GET Request
     * 
     * @param string $endpoint
     * @param array<mixed> $headers
     * @param string $body
     *
     * @return CurlWrapper
     */
    public function get($endpoint, $headers = null, $body = null)
    {
        if (!is_null($headers)) {
            foreach($headers as $key => $value) {
                $this->client->setHeader($key, $value);
            }
        }

        return $this->client->get($endpoint); 
    }

    /**
     * Send HTTP POST Request
     * 
     * @param string $endpoint
     * @param array<mixed> $headers
     * @param string $body
     * @param bool $asJson
     *
     * @return CurlWrapper
     */
    public function post($endpoint, $headers = null, $body = null, $asJson = null)
    {
        if (is_null($asJson)) {
            $asJson = false;
        }

        if (!is_null($headers)) {
            foreach($headers as $key => $value) {
                $this->client->setHeader($key, $value);
            }
        }

        if (!$asJson) {
            // Créer un fichier temporaire
            $temp = tmpfile();
            fwrite($temp, $body);
            rewind($temp);

            // Sauvegarder le fichier temporaire pour cURL
            $tempPath = stream_get_meta_data($temp)['uri'];
            $data = ['file' => new \CURLFile($tempPath, 'text/plain', 'file')];
        } else {
            $data = $body;
        }

        $query = $this->client->post($endpoint, $data, $asJson);

        if (!$asJson) {
            fclose($temp);
        }

        return $query;
    }
}
