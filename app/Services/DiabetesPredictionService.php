<?php

namespace App\Services;

class DiabetesPredictionService extends PredictionRequest
{
    /**
     * @var string
     */
    protected $url = '/predict/diabetes';

    /**
     * The predict function.
     *
     * @param array $input
     *
     * @return mixed
     */
    function predict (array $input)
    {
        $response = $this->sendRequest($input);
        return json_decode($response->getBody(), true);
    }
}