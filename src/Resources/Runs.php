<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/runs endpoints.
 */
class Runs
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Runs constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all runs.
     * GET /v1/runs/
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
     */
    public function retrieve(string $runId)
    {
        $response = $this->http->request('GET', "/v1/runs/{$runId}");
        return $response;
    }

    /**
     * Delete run by ID.
     * DELETE /v1/runs/{run_id}
     */
    public function delete(string $runId)
    {
        $response = $this->http->request('DELETE', "/v1/runs/{$runId}");
        return $response;
    }

    /**
     * Get token usage for a run.
     * GET /v1/runs/{run_id}/usage
     */
    public function usage(string $runId)
    {
        $response = $this->http->request('GET', "/v1/runs/{$runId}/usage");
        return $response;
    }
} 