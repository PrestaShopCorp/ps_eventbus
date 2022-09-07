<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

abstract class GenericClient
{
    /**
     * If set to false, you will not be able to catch the error
     * guzzle will show a different error message.
     *
     * @var bool
     */
    protected $catchExceptions = false;
    /**
     * Guzzle Client.
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * Class Link in order to generate module link.
     *
     * @var \Link
     */
    protected $link;

    /**
     * Api route.
     *
     * @var string
     */
    protected $route;

    /**
     * Set how long guzzle will wait a response before end it up.
     *
     * @var int
     */
    protected $timeout = 10;

    /**
     * @var array
     */
    public $options;

    /**
     * @var array
     */
    public $headers;

    /**
     * @param ClientInterface $client
     * @param array $options
     */
    public function __construct(ClientInterface $client, array $options)
    {
        $this->setClient($client);
        $this->setOptions($options);
        $this->setHeaders($options['headers']);
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return GenericClient
     */
    public function setOptions(array $options): GenericClient
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     *
     * @return GenericClient
     */
    public function setHeaders(array $headers): GenericClient
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return GenericClient
     */
    public function mergeHeader(array $headers)
    {
        return $this->setHeaders(array_merge($this->getHeaders(), $headers));
    }

    /**
     * Getter for client.
     *
     * @return ClientInterface
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * Getter for exceptions mode.
     *
     * @return bool
     */
    protected function getExceptionsMode()
    {
        return $this->catchExceptions;
    }

    /**
     * Getter for Link.
     *
     * @return \Link
     */
    protected function getLink()
    {
        return $this->link;
    }

    /**
     * Getter for route.
     *
     * @return string
     */
    protected function getRoute()
    {
        return $this->route;
    }

    /**
     * Getter for timeout.
     *
     * @return int
     */
    protected function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Wrapper of method post from guzzle client.
     *
     * @param array $options payload
     *
     * @return array return response or false if no response
     */
    protected function post(array $options = [])
    {
        $this->mergeHeader($options['headers']);
        $request = new Request('POST', $this->getRoute(), $this->getHeaders(), $options['body']);

        return $this->sendRequest($request);
    }

    /**
     * Wrapper of method patch from guzzle client.
     *
     * @param array $options payload
     *
     * @return array return response or false if no response
     */
    protected function patch(array $options = [])
    {
        $this->mergeHeader($options['headers']);
        $request = new Request('PATCH', $this->getRoute(), $this->getHeaders(), $options['body']);

        return $this->sendRequest($request);
    }

    /**
     * Wrapper of method delete from guzzle client.
     *
     * @param array $options payload
     *
     * @return array return response array
     */
    protected function delete(array $options = [])
    {
        $this->mergeHeader($options['headers']);
        $request = new Request('DELETE', $this->getRoute(), $this->getHeaders(), $options['body']);

        return $this->sendRequest($request);
    }

    /**
     * Wrapper of method post from guzzle client.
     *
     * @return array return response or false if no response
     *
     * @throws ClientExceptionInterface
     */
    protected function get()
    {
        $request = new Request('GET', $this->getRoute(), $this->getHeaders());

        return $this->sendRequest($request);
    }

    /**
     * Wrapper of method sendRequest from guzzle client.
     *
     * @param RequestInterface $request
     *
     * @return array
     *
     * @throws ClientExceptionInterface
     */
    public function sendRequest(RequestInterface $request)
    {
        $response = $this->getClient()->sendRequest($request);
        $responseHandler = new ResponseApiHandler();
        $response = $responseHandler->handleResponse($response);

        return $response;
    }

    /**
     * Setter for client.
     *
     * @return void
     */
    protected function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Setter for exceptions mode.
     *
     * @param bool $bool
     *
     * @return void
     */
    protected function setExceptionsMode($bool)
    {
        $this->catchExceptions = $bool;
    }

    /**
     * Setter for link.
     *
     * @return void
     */
    protected function setLink(\Link $link)
    {
        $this->link = $link;
    }

    /**
     * Setter for route.
     *
     * @param string $route
     *
     * @return void
     */
    protected function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * Setter for timeout.
     *
     * @param int $timeout
     *
     * @return void
     */
    protected function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }
}
