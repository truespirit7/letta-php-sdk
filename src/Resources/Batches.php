<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/batches endpoints.
 */
class Batches
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Batches constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List batch runs.
     * GET /v1/batches/runs
     */
    public function listRuns(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/batches/runs');
        return $response;
    }

    /**
     * Create messages batch.
     * POST /v1/batches/messages
     */
    public function createMessagesBatch(array $data)
    {
        // TODO: Implement
    }

    /**
     * Retrieve batch run by ID.
     * GET /v1/batches/runs/{batch_id}
     */
    public function retrieveRun(string $batchId)
    {
        // TODO: Implement
    }

    /**
     * Cancel batch run by ID.
     * PATCH /v1/batches/runs/{batch_id}
     */
    public function cancelRun(string $batchId, array $data)
    {
        // TODO: Implement
    }

    /**
     * List messages from a batch run (global batch messages endpoint).
     * GET /batch-runs/{batch_id}/messages
     */
    public function listBatchMessages(string $batchId)
    {
        $response = $this->http->request('GET', "/batch-runs/{$batchId}/messages");
        return $response;
    }
} 