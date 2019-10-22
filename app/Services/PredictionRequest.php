<?php

namespace App\Services;

use GuzzleHttp\Client;

abstract class PredictionRequest {
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $url;

    /**
     * Initializes the guzzle client and base url.
     *
     * @param Client $client
     */
    function __construct (Client $client)
    {
        $this->client = $client;
        $this->baseUrl = env('PYTHON_APP_URL');
    }

    /**
     * The predict function.
     *
     * @param array $input
     *
     * @return mixed
     */
    abstract function predict(array $input);

    /**
     * Sends the request to the API.
     *
     * @param array $input
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendRequest(array $input)
    {
        return $this->client->post($this->baseUrl.$this->url, ['form_params' => $input]);
    }
}