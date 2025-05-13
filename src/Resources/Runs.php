<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/runs endpoints.
 *
 * Provides methods to interact with Letta run resources, including listing, retrieving, deleting runs, and getting token usage.
 */
class Runs
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Runs constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all runs.
     * GET /v1/runs/
     *
     * @param array $params Optional query parameters
     * @return array List of run objects
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/runs/', [
            'query' => $params
        ]);
        return $response;
    }

    /**
     * List active runs.
     * GET /v1/runs/active
     *
     * @param array $params Optional query parameters
     * @return array List of active run objects
     */
    public function listActive(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/runs/active', [
            'query' => $params
        ]);
        return $response;
    }

    /**
     * Retrieve run by ID.
     * GET /v1/runs/{run_id}
     *
     * @param string $runId Run ID
     * @return array Run object
     */
    public function retrieve(string $runId)
    {
        $response = $this->http->request('GET', "/v1/runs/{$runId}");
        return $response;
    }

    /**
     * Delete run by ID.
     * DELETE /v1/runs/{run_id}
     *
     * @param string $runId Run ID
     * @return array API response
     */
    public function delete(string $runId)
    {
        $response = $this->http->request('DELETE', "/v1/runs/{$runId}");
        return $response;
    }

    /**
     * Get token usage for a run.
     * GET /v1/runs/{run_id}/usage
     *
     * @param string $runId Run ID
     * @return array Usage information
     */
    public function usage(string $runId)
    {
        $response = $this->http->request('GET', "/v1/runs/{$runId}/usage");
        return $response;
    }
} 