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

use GuzzleHttp\Psr7\Request;
use PrestaShop\Module\PsEventbus\Api\Post\MultipartBody;
use PrestaShop\Module\PsEventbus\Api\Post\PostFileApi;
use Prestashop\ModuleLibGuzzleAdapter\ClientFactory;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\HttpClientInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

if (!defined('_PS_VERSION_')) {
    exit;
}

class HttpClientFactory
{
    /**
     * @var HttpClientInterface|\Symfony\Contracts\HttpClient\HttpClientInterface
     */
    private $client;

    /**
     * 
     * @var \Symfony\Contracts\HttpClient\ResponseInterface|\Psr\Http\Message\ResponseInterface
     */
    private $response;

    /**
     * @param int $timeout
     *
     * @return HttpClientFactory
     */
    public function __construct($timeout)
    {
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '9', '>=')) {
            $this->client = HttpClient::create();
        } else {
            $this->client = (new ClientFactory())->getClient([
                'allow_redirects' => true,
                'connect_timeout' => 10,
                'http_errors' => false,
                'read_timeout' => 30,
                'timeout' => $timeout,
            ]);
        }
    }

    /**
     * Send HTTP Request
     *
     * @param string|\Psr\Http\Message\RequestInterface $method
     * @param string $endpoint
     * @param array<mixed> $headers
     * @param array<mixed> $body
     *
     * @return self
     */
    public function sendRequest($method, $endpoint, $headers = null, $body = null)
    {
        $params = [];

        // Define $headers to array for Request() class
        // Or for Symfony Client
        if (is_null($headers)) {
            $headers = [];
        } else {
            $params['headers'] = $headers;
        }

        if (!is_null($body)) {
            $params['body'] = $body;
        }

        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '9', '>=')) {
            $params['headers'] = $headers;

            $this->response = $this->client->request(
                $method,
                $endpoint,
                $params
            );
        } else {
            $this->response = $this->client->sendRequest(
                new Request(
                    $method,
                    $endpoint,
                    $headers,
                    $body
                )
            );
        }

        return $this;
    }

    /**
     * @return string 
     */
    public function getContent() 
    {
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '9', '>=')) {
            try {
                return $this->response->getContent();
            /* } catch (ClientException $e) {
                //return '404 - not found';
            } catch(ServerException $e) {
                //return '500 - Server error'; */
            } catch (\Exception $e) {
                return '';
            }
        } else {
            return $this->response->getBody()->getContents();
        }
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }
}
