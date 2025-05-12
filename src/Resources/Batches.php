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
        // TODO: Implement
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
     * List batch messages.
     * GET /v1/batches/messages/{batch_id}/messages
     */
    public function listBatchMessages(string $batchId)
    {
        // TODO: Implement
    }
} 