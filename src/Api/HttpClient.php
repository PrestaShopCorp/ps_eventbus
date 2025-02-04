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

/** This wrapper came from https://github.com/php-mod/curl
 *  The original code was modified to fit ps_eventbus needs
 */

namespace PrestaShop\Module\PsEventbus\Api;

if (!defined('_PS_VERSION_')) {
    exit;
}

class HttpClient
{
    /**
     * @var HttpClient
     */
    private static $instance;

    /**
     * @var string Type AUTH_BASIC
     */
    const AUTH_BASIC = CURLAUTH_BASIC;

    /**
     * @var string Type AUTH_DIGEST
     */
    const AUTH_DIGEST = CURLAUTH_DIGEST;

    /**
     * @var string Type AUTH_GSSNEGOTIATE
     */
    const AUTH_GSSNEGOTIATE = CURLAUTH_GSSNEGOTIATE;

    /**
     * @var string Type AUTH_NTLM
     */
    const AUTH_NTLM = CURLAUTH_NTLM;

    /**
     * @var string Type AUTH_ANY
     */
    const AUTH_ANY = CURLAUTH_ANY;

    /**
     * @var string Type AUTH_ANYSAFE
     */
    const AUTH_ANYSAFE = CURLAUTH_ANYSAFE;

    /**
     * @var string The user agent name which is set when making a request
     */
    const USER_AGENT = 'PHP Curl/2.3';

    private $_cookies = [];

    private $_headers = [];

    /**
     * @var resource Contains the curl resource created by `curl_init()` function
     */
    public $curl;

    /**
     * @var bool Whether an error occurred or not
     */
    public $error = false;

    /**
     * @var int Contains the error code of the current request, 0 means no error happened
     */
    public $error_code = 0;

    /**
     * @var string If the curl request failed, the error message is contained
     */
    public $error_message;

    /**
     * @var bool Whether an error occurred or not
     */
    public $curl_error = false;

    /**
     * @var int contains the error code of the current request, 0 means no error happened
     *
     * @see https://curl.haxx.se/libcurl/c/libcurl-errors.html
     */
    public $curl_error_code = 0;

    /**
     * @var string If the curl request failed, the error message is contained
     */
    public $curl_error_message;

    /**
     * @var bool Whether an error occurred or not
     */
    public $http_error = false;

    /**
     * @var int contains the status code of the current processed request
     */
    public $http_status_code = 0;

    /**
     * @var string If the curl request failed, the error message is contained
     */
    public $http_error_message;

    /**
     * @var string|array TBD (ensure type) Contains the request header information
     */
    public $request_headers;

    /**
     * @var string|array TBD (ensure type) Contains the response header information
     */
    public $response_headers = [];

    /**
     * @var string|false|null Contains the response from the curl request
     */
    public $response;

    /**
     * @var bool Whether the current section of response headers is after 'HTTP/1.1 100 Continue'
     */
    protected $response_header_continue = false;

    // Disable instantiation
    private function __construct()
    {
        $this->init();
    }

    // Disable cloning
    private function __clone()
    {
    }

    // Unserialization of singleton is forbidden
    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize a singleton.');
    }

    /**
     * Get the instance of the HttpClient.
     *
     * @return HttpClient
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        } else {
            self::$instance->reset();
        }

        return self::$instance;
    }

    /**
     * Initializer for the curl resource.
     *
     * Is called by the __construct() of the class or when the curl request is reset.
     *
     * @return self
     */
    private function init()
    {
        $this->curl = curl_init();
        $this->setUserAgent(self::USER_AGENT);
        $this->setOpt(CURLINFO_HEADER_OUT, true);
        $this->setOpt(CURLOPT_HEADER, false);
        $this->setOpt(CURLOPT_RETURNTRANSFER, true);
        $this->setOpt(CURLOPT_HEADERFUNCTION, [$this, 'addResponseHeaderLine']);
        $this->setOpt(CURLOPT_CONNECTTIMEOUT, 10);

        return $this;
    }

    /**
     * @param array<mixed> $data
     *
     * @return string
     */
    private function formatNewlineJsonString($data)
    {
        $jsonArray = array_map(function ($dataItem) {
            return json_encode($dataItem, JSON_UNESCAPED_SLASHES);
        }, $data);

        $json = implode("\r\n", $jsonArray);

        return str_replace('\\u0000', '', $json);
    }

    /**
     * Set the timeout for the current request.
     *
     * @param mixed $timeout
     *
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->setOpt(CURLOPT_TIMEOUT, $timeout);

        return $this;
    }

    /**
     * Handle writing the response headers
     *
     * @param resource $curl The current curl resource
     * @param string $header_line A line from the list of response headers
     *
     * @return int Returns the length of the $header_line
     */
    public function addResponseHeaderLine($curl, $header_line)
    {
        $trimmed_header = trim($header_line, "\r\n");

        if ($trimmed_header === '') {
            $this->response_header_continue = false;
        } elseif (strtolower($trimmed_header) === 'http/1.1 100 continue') {
            $this->response_header_continue = true;
        } elseif (!$this->response_header_continue) {
            $this->response_headers[] = $trimmed_header;
        }

        return strlen($header_line);
    }

    /**
     * Execute the curl request based on the respective settings.
     *
     * @return int Returns the error code for the current curl request
     */
    protected function exec()
    {
        $this->response_headers = [];
        $this->response = curl_exec($this->curl);
        $this->curl_error_code = curl_errno($this->curl);
        $this->curl_error_message = curl_error($this->curl);
        $this->curl_error = !($this->getErrorCode() === 0);
        $this->http_status_code = intval(curl_getinfo($this->curl, CURLINFO_HTTP_CODE));
        $this->http_error = $this->isError();
        $this->error = $this->curl_error || $this->http_error;
        $this->error_code = $this->error ? ($this->curl_error ? $this->getErrorCode() : $this->getHttpStatus()) : 0;
        $this->request_headers = preg_split('/\r\n/', curl_getinfo($this->curl, CURLINFO_HEADER_OUT), -1, PREG_SPLIT_NO_EMPTY);
        $this->http_error_message = $this->error ? (isset($this->response_headers['0']) ? $this->response_headers['0'] : '') : '';
        $this->error_message = $this->curl_error ? $this->getErrorMessage() : $this->http_error_message;

        return $this->error_code;
    }

    /**
     * @param array|object|string $data
     */
    protected function preparePayload($data)
    {
        $this->setOpt(CURLOPT_POST, true);

        if (is_array($data) || is_object($data)) {
            $skip = false;
            foreach ($data as $key => $value) {
                // If a value is an instance of CurlFile skip the http_build_query
                // see issue https://github.com/php-mod/curl/issues/46
                // suggestion from: https://stackoverflow.com/a/36603038/4611030
                if ($value instanceof \CURLFile) {
                    $skip = true;
                }
            }

            if (!$skip) {
                $data = http_build_query($data);
            }
        }

        $this->setOpt(CURLOPT_POSTFIELDS, $data);
    }

    /**
     * Set the json payload informations to the postfield curl option.
     *
     * @param array $data the data to be sent
     *
     * @return void
     */
    protected function prepareJsonPayload($data)
    {
        $this->setOpt(CURLOPT_POST, true);
        $this->setOpt(CURLOPT_POSTFIELDS, json_encode($data));
    }

    /**
     * Set auth options for the current request.
     *
     * Available auth types are:
     *
     * + self::AUTH_BASIC
     * + self::AUTH_DIGEST
     * + self::AUTH_GSSNEGOTIATE
     * + self::AUTH_NTLM
     * + self::AUTH_ANY
     * + self::AUTH_ANYSAFE
     *
     * @param int $httpauth The type of authentication
     */
    protected function setHttpAuth($httpauth)
    {
        $this->setOpt(CURLOPT_HTTPAUTH, $httpauth);
    }

    /**
     * Make a get request with optional data.
     *
     * The get request has no body data, the data will be correctly added to the $url with the http_build_query() method.
     *
     * @param string $url The url to make the get request for
     * @param array $headers Optional headers to pass to the url
     * @param array $data Optional arguments who are part of the url
     *
     * @return self
     */
    public function get($url, $headers, $data = null)
    {
        $this->setHeaders($headers);

        if (!is_null($data) && is_array($data) && count($data) > 0) {
            $this->setOpt(CURLOPT_URL, $url . '?' . http_build_query($data));
        } else {
            $this->setOpt(CURLOPT_URL, $url);
        }

        $this->setOpt(CURLOPT_HTTPGET, true);
        $this->exec();

        return $this;
    }

    /**
     * Make a post request with optional post data.
     *
     * @param string $url The url to make the post request
     * @param array $headers Optional headers to pass to the url
     * @param array $data Post data to pass to the url
     * @param bool $isFile If there is a multipart, set it to true or False if it is a json
     *
     * @return self
     */
    public function post($url, array $headers = [], array $data = [], $isFile = null)
    {
        if (is_null($isFile)) {
            $isFile = false;
        }

        $this->setHeaders($headers);
        $this->setOpt(CURLOPT_URL, $url);

        if ($isFile) {
            // Créer un fichier temporaire
            $temp = tmpfile();
            fwrite($temp, $this->formatNewlineJsonString($data));
            rewind($temp);

            // Sauvegarder le fichier temporaire pour cURL
            $tempPath = stream_get_meta_data($temp)['uri'];
            $payload = ['file' => new \CURLFile($tempPath, 'text/plain', 'file')];
            $this->preparePayload($payload);
        } else {
            $this->prepareJsonPayload($data);
        }

        $this->exec();

        if ($isFile) {
            fclose($temp);
        }

        return $this;
    }

    /**
     * Make a put request with optional data.
     *
     * The put request data can be either sent via payload or as get parameters of the string.
     *
     * @param string $url The url to make the put request
     * @param array $data Optional data to pass to the $url
     * @param bool $payload Whether the data should be transmitted trough payload or as get parameters of the string
     *
     * @return self
     */
    public function put($url, $data = null, $payload = null)
    {
        if (is_null($data)) {
            $data = [];
        }

        if (is_null($payload)) {
            $payload = false;
        }

        if (!empty($data)) {
            if ($payload === false) {
                $url .= '?' . http_build_query($data);
            } else {
                $this->preparePayload($data);
            }
        }

        $this->setOpt(CURLOPT_URL, $url);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'PUT');
        $this->exec();

        return $this;
    }

    /**
     * Make a patch request with optional data.
     *
     * The patch request data can be either sent via payload or as get parameters of the string.
     *
     * @param string $url The url to make the patch request
     * @param array $data Optional data to pass to the $url
     * @param bool $payload Whether the data should be transmitted trough payload or as get parameters of the string
     *
     * @return self
     */
    public function patch($url, $data = null, $payload = null)
    {
        if (is_null($data)) {
            $data = [];
        }

        if (is_null($payload)) {
            $payload = false;
        }

        if (!empty($data)) {
            if ($payload === false) {
                $url .= '?' . http_build_query($data);
            } else {
                $this->preparePayload($data);
            }
        }

        $this->setOpt(CURLOPT_URL, $url);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'PATCH');
        $this->exec();

        return $this;
    }

    /**
     * Make a delete request with optional data.
     *
     * @param string $url The url to make the delete request
     * @param array $data Optional data to pass to the $url
     * @param bool $payload Whether the data should be transmitted trough payload or as get parameters of the string
     *
     * @return self
     */
    public function delete($url, $data = null, $payload = null)
    {
        if (is_null($data)) {
            $data = [];
        }

        if (is_null($payload)) {
            $payload = false;
        }

        if (!empty($data)) {
            if ($payload === false) {
                $url .= '?' . http_build_query($data);
            } else {
                $this->preparePayload($data);
            }
        }

        $this->setOpt(CURLOPT_URL, $url);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->exec();

        return $this;
    }

    /**
     * Pass basic auth data.
     *
     * If the the requested url is secured by an htaccess basic auth mechanism you can use this method to provided the auth data.
     *
     * ```php
     * $curl = new Curl();
     * $curl->setBasicAuthentication('john', 'doe');
     * $curl->get('http://example.com/secure.php');
     * ```
     *
     * @param string $username The username for the authentication
     * @param string $password The password for the given username for the authentication
     *
     * @return self
     */
    public function setBasicAuthentication($username, $password)
    {
        $this->setHttpAuth(self::AUTH_BASIC);
        $this->setOpt(CURLOPT_USERPWD, $username . ':' . $password);

        return $this;
    }

    /**
     * Provide optional headers information.
     *
     * In order to pass optional headers array with key value pairing:
     *
     * ```php
     * $curl = new Curl();
     * $curl->setHeaders(['X-Requested-With', 'XMLHttpRequest']);
     * $curl->get('http://example.com/request.php');
     * ```
     *
     * @param array $headers The headers to pass to the current request
     *
     * @return self
     */
    public function setHeaders($headers)
    {
        if (!is_null($headers)) {
            foreach ($headers as $key => $value) {
                $this->_headers[$key] = $key . ': ' . $value;
                $this->setOpt(CURLOPT_HTTPHEADER, array_values($this->_headers));
            }
        }

        return $this;
    }

    /**
     * Provide a User Agent.
     *
     * In order to provide you customized user agent name you can use this method.
     *
     * ```php
     * $curl = new Curl();
     * $curl->setUserAgent('My John Doe Agent 1.0');
     * $curl->get('http://example.com/request.php');
     * ```
     *
     * @param string $useragent The name of the user agent to set for the current request
     *
     * @return self
     */
    public function setUserAgent($useragent)
    {
        $this->setOpt(CURLOPT_USERAGENT, $useragent);

        return $this;
    }

    /**
     * Set the HTTP referer header.
     *
     * The $referer Information can help identify the requested client where the requested was made.
     *
     * @param string $referer An url to pass and will be set as referer header
     *
     * @return self
     */
    public function setReferer($referer)
    {
        $this->setOpt(CURLOPT_REFERER, $referer);

        return $this;
    }

    /**
     * Set contents of HTTP Cookie header.
     *
     * @param string $key The name of the cookie
     * @param string $value The value for the provided cookie name
     *
     * @return self
     */
    public function setCookie($key, $value)
    {
        $this->_cookies[$key] = $value;
        $this->setOpt(CURLOPT_COOKIE, http_build_query($this->_cookies, '', '; '));

        return $this;
    }

    /**
     * Set customized curl options.
     *
     * To see a full list of options: http://php.net/curl_setopt
     *
     * @see http://php.net/curl_setopt
     *
     * @param int $option The curl option constant e.g. `CURLOPT_AUTOREFERER`, `CURLOPT_COOKIESESSION`
     * @param mixed $value The value to pass for the given $option
     *
     * @return bool
     */
    public function setOpt($option, $value)
    {
        return curl_setopt($this->curl, $option, $value);
    }

    /**
     * Get customized curl options.
     *
     * To see a full list of options: http://php.net/curl_getinfo
     *
     * @see http://php.net/curl_getinfo
     *
     * @param int $option The curl option constant e.g. `CURLOPT_AUTOREFERER`, `CURLOPT_COOKIESESSION`
     * @param mixed The value to check for the given $option
     *
     * @return mixed
     */
    public function getOpt($option)
    {
        return curl_getinfo($this->curl, $option);
    }

    /**
     * Return the endpoint set for curl
     *
     * @see http://php.net/curl_getinfo
     *
     * @return string of endpoint
     */
    public function getEndpoint()
    {
        return $this->getOpt(CURLINFO_EFFECTIVE_URL);
    }

    /**
     * Enable verbosity.
     *
     * @param bool $on
     *
     * @return self
     */
    public function setVerbose($on = null)
    {
        if (is_null($on)) {
            $on = true;
        }

        $this->setOpt(CURLOPT_VERBOSE, $on);

        return $this;
    }

    /**
     * Reset all curl options.
     *
     * In order to make multiple requests with the same curl object all settings requires to be reset.
     *
     * @return self
     */
    public function reset()
    {
        $this->close();
        $this->_cookies = [];
        $this->_headers = [];
        $this->error = false;
        $this->error_code = 0;
        $this->error_message = null;
        $this->curl_error = false;
        $this->curl_error_code = 0;
        $this->curl_error_message = null;
        $this->http_error = false;
        $this->http_status_code = 0;
        $this->http_error_message = null;
        $this->request_headers = null;
        $this->response_headers = [];
        $this->response = false;
        $this->init();

        return $this;
    }

    /**
     * Closing the current open curl resource.
     *
     * @return self
     */
    public function close()
    {
        if (is_resource($this->curl)) {
            curl_close($this->curl);
        }

        return $this;
    }

    /**
     * Close the connection when the Curl object will be destroyed.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Was an 'info' header returned.
     *
     * @return bool
     */
    public function isInfo()
    {
        return $this->getHttpStatus() >= 100 && $this->getHttpStatus() < 200;
    }

    /**
     * Was an 'OK' response returned.
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->getHttpStatus() >= 200 && $this->getHttpStatus() < 300;
    }

    /**
     * Was a 'redirect' returned.
     *
     * @return bool
     */
    public function isRedirect()
    {
        return $this->getHttpStatus() >= 300 && $this->getHttpStatus() < 400;
    }

    /**
     * Was an 'error' returned (client error or server error).
     *
     * @return bool
     */
    public function isError()
    {
        return $this->getHttpStatus() >= 400 && $this->getHttpStatus() < 600;
    }

    /**
     * Was a 'client error' returned.
     *
     * @return bool
     */
    public function isClientError()
    {
        return $this->getHttpStatus() >= 400 && $this->getHttpStatus() < 500;
    }

    /**
     * Was a 'server error' returned.
     *
     * @return bool
     */
    public function isServerError()
    {
        return $this->getHttpStatus() >= 500 && $this->getHttpStatus() < 600;
    }

    /**
     * Get a specific response header key or all values from the response headers array.
     *
     * Usage example:
     *
     * ```php
     * $curl = (new Curl())->get('http://example.com');
     *
     * echo $curl->getResponseHeaders('Content-Type');
     * ```
     *
     * Or in order to dump all keys with the given values use:
     *
     * ```php
     * $curl = (new Curl())->get('http://example.com');
     *
     * var_dump($curl->getResponseHeaders());
     * ```
     *
     * @param string $headerKey optional key to get from the array
     *
     * @return bool|string|array
     *
     * @since 1.9
     */
    public function getResponseHeaders($headerKey = null)
    {
        $headers = [];
        $headerKey = strtolower($headerKey);

        foreach ($this->response_headers as $header) {
            $parts = explode(':', $header, 2);

            $key = isset($parts[0]) ? $parts[0] : '';
            $value = isset($parts[1]) ? $parts[1] : '';

            $headers[trim(strtolower($key))] = trim($value);
        }

        if ($headerKey) {
            return isset($headers[$headerKey]) ? $headers[$headerKey] : false;
        }

        return $headers;
    }

    /**
     * Get response from the curl request
     *
     * @return string|false
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get curl error code
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->curl_error_code;
    }

    /**
     * Get curl error message
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->curl_error_message;
    }

    /**
     * Get http status code from the curl request
     *
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->http_status_code;
    }
}
