<?php

namespace Flowplayer;

use Flowplayer\Exceptions\ApiParamValidationException;
use Flowplayer\Exceptions\FlowplayerAPIQueryException;
use GuzzleHttp\Client as HttpClient;

class APICaller
{
    protected $client;

    protected $credentials = [
        'username' => '',
        'password' => ''
    ];

    protected $default_parameters = [];

    /**
     * Valid API Parameter Keynames
     *
     * @var array
     */
    protected $allowed_parameters = [];

    /**
     * APICaller constructor.
     * @param $client
     * @param $parameters array
     */
    public function __construct(HTTPClient $client, $parameters = [])
    {
        $this->client = $client;

        $this->credentials['username'] = $parameters['username'];
        $this->credentials['password'] = $parameters['password'];

        // Drop params that we don't want in the URI string
        unset($parameters['gateway_url'], $parameters['username'], $parameters['password']);

        $this->default_parameters = array_merge($this->default_parameters, $parameters);
    }

    /**
     * Query
     *
     * Public Query method that should prep, execute, and validate the results of the API query
     *
     * Sets the result_string and result_decoded vars to class variables
     * @param $params
     * @throws ApiParamValidationException
     * @return array
     */
    public function query($params = [])
    {
        foreach ($params as $param_name => $value) {
            if ( ! in_array($param_name, $this->allowed_parameters)) {
                throw new ApiParamValidationException('Invalid API Parameter Submitted');
            }
        }

        $result = $this->executeQuery(array_merge($this->default_parameters, $params));
        $this->validateResult($result);

        return $this->translateResult($result);
    }

    /**
     * Execute API Query
     *
     * Executes API Query call, returns result
     *
     * @param 	string 	Full URI Query string
     * @return 	string 	API result
     */
    protected function executeQuery($params)
    {
        return $this->client->get(
            $this->gateway_url,
            [
                'auth' => [
                    $this->credentials['username'],
                    $this->credentials['password']
                ],
                'query' => $params
            ]
        );
    }

    /**
     * Validate API Result
     * @param 	mixed 	api result
     * @return 	bool 	valid result
     */
    protected function validateResult($api_result)
    {
        if ($api_result->getStatusCode() !== 200) {
            throw new FlowplayerAPIQueryException("Response Code {$api_result->getStatusCode()} Found");
        }
    }

    /**
     * Validate API Result
     * @param 	mixed 	api result
     * @return 	array publications
     */
    protected function translateResult($api_result)
    {
        return $api_result->json()['resultSet'];
    }
}
