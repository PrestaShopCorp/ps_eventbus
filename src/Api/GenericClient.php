<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Client;

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
     * @var Client
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
     * GenericClient constructor.
     */
    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    /**
     * Getter for client.
     *
     * @return Client
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
        $response = $this->getClient()->post($this->getRoute(), $options);
        $responseHandler = new ResponseApiHandler();
        $response = $responseHandler->handleResponse($response);

        return $response;
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
        $response = $this->getClient()->patch($this->getRoute(), $options);
        $responseHandler = new ResponseApiHandler();
        $response = $responseHandler->handleResponse($response);

        return $response;
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
        $response = $this->getClient()->delete($this->getRoute(), $options);
        $responseHandler = new ResponseApiHandler();
        $response = $responseHandler->handleResponse($response);

        return $response;
    }

    /**
     * Wrapper of method post from guzzle client.
     *
     * @param array $options payload
     *
     * @return array return response or false if no response
     */
    protected function get(array $options = [])
    {
        $response = $this->getClient()->get($this->getRoute(), $options);
        $responseHandler = new ResponseApiHandler();
        $response = $responseHandler->handleResponse($response);

        return $response;
    }

    /**
     * Setter for client.
     *
     * @return void
     */
    protected function setClient(Client $client)
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
