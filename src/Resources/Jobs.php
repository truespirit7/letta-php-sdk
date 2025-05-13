<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/jobs endpoints.
 */
class Jobs
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Jobs constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all jobs.
     * GET /v1/jobs
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/jobs', [
            'query' => $params
        ]);
        return $response;
    }

    /**
     * List active jobs.
     * GET /v1/jobs/active
     */
    public function listActive(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/jobs/active', [
            'query' => $params
        ]);
        return $response;
    }

    /**
     * Retrieve job by ID.
     * GET /v1/jobs/{job_id}
     */
    public function retrieve(string $jobId)
    {
        $response = $this->http->request('GET', "/v1/jobs/{$jobId}");
        return $response;
    }

    /**
     * Delete/cancel job by ID.
     * DELETE /v1/jobs/{job_id}
     */
    public function delete(string $jobId)
    {
        $response = $this->http->request('DELETE', "/v1/jobs/{$jobId}");
        return $response;
    }
} 