<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/steps endpoints.
 *
 * Provides methods to interact with Letta step resources, including listing steps and retrieving a step by ID.
 */
class Steps
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Steps constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all steps.
     * GET /v1/steps/
     *
     * @param array $params Optional query parameters
     * @return array List of step objects
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/steps/', [
            'query' => $params
        ]);
        return $response;
    }

    /**
     * Retrieve step by ID.
     * GET /v1/steps/{step_id}
     *
     * @param string $stepId Step ID
     * @return array Step object
     */
    public function retrieve(string $stepId)
    {
        $response = $this->http->request('GET', "/v1/steps/{$stepId}");
        return $response;
    }
} 