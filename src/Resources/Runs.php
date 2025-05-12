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
        // TODO: Implement
    }

    /**
     * List active runs.
     * GET /v1/runs/active
     */
    public function listActive(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Retrieve run by ID.
     * GET /v1/runs/{run_id}
     */
    public function retrieve(string $runId)
    {
        // TODO: Implement
    }

    /**
     * Delete run by ID.
     * DELETE /v1/runs/{run_id}
     */
    public function delete(string $runId)
    {
        // TODO: Implement
    }
} 