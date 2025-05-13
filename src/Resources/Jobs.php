<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/jobs endpoints.
 *
 * Provides methods to interact with Letta job resources, including listing, retrieving, and deleting jobs.
 */
class Jobs
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Jobs constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all jobs.
     * GET /v1/jobs
     *
     * @param array $params Optional query parameters
     * @return array List of job objects
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
     *
     * @param array $params Optional query parameters
     * @return array List of active job objects
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
     *
     * @param string $jobId Job ID
     * @return array Job object
     */
    public function retrieve(string $jobId)
    {
        $response = $this->http->request('GET', "/v1/jobs/{$jobId}");
        return $response;
    }

    /**
     * Delete/cancel job by ID.
     * DELETE /v1/jobs/{job_id}
     *
     * @param string $jobId Job ID
     * @return array API response
     */
    public function delete(string $jobId)
    {
        $response = $this->http->request('DELETE', "/v1/jobs/{$jobId}");
        return $response;
    }
} 