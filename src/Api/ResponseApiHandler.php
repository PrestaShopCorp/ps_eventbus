<?php
/**
 * 2007-2020 PrestaShop.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2020 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\Module\PsEventbus\Api;

use Psr\Http\Message\ResponseInterface;

/**
 * Handle api response.
 */
class ResponseApiHandler
{
    /**
     * Format api response.
     *
     * @return array
     */
    public function handleResponse(ResponseInterface $response)
    {
        /** @var array $responseContents */
        $responseContents = json_decode($response->getBody()->getContents(), true);

        return [
            'status' => $this->responseIsSuccessful($responseContents, $response->getStatusCode()),
            'httpCode' => $response->getStatusCode(),
            'body' => $responseContents,
        ];
    }

    /**
     * Check if the response is successful or not (response code 200 to 299).
     *
     * @param array $responseContents
     * @param int $httpStatusCode
     *
     * @return bool
     */
    private function responseIsSuccessful($responseContents, $httpStatusCode)
    {
        // Directly return true, no need to check the body for a 204 status code
        // 204 status code is only send by /payments/order/update
        if (204 === $httpStatusCode) {
            return true;
        }

        return '2' === substr((string) $httpStatusCode, 0, 1) && null !== $responseContents;
    }
}
