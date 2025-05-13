<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/batches endpoints.
 *
 * Provides methods to interact with Letta batch resources, including listing batch runs, creating message batches, retrieving and canceling batch runs, and listing batch messages.
 */
class Batches
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Batches constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List batch runs.
     * GET /v1/batches/runs
     *
     * @param array $params Optional query parameters
     * @return array List of batch run objects
     */
    public function listRuns(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/batches/runs');
        return $response;
    }

    /**
     * Create messages batch.
     * POST /v1/batches/messages
     *
     * @param array $data Batch creation payload
     * @return void
     * @todo Implement
     */
    public function createMessagesBatch(array $data)
    {
        // TODO: Implement
    }

    /**
     * Retrieve batch run by ID.
     * GET /v1/batches/runs/{batch_id}
     *
     * @param string $batchId Batch run ID
     * @return void
     * @todo Implement
     */
    public function retrieveRun(string $batchId)
    {
        // TODO: Implement
    }

    /**
     * Cancel batch run by ID.
     * PATCH /v1/batches/runs/{batch_id}
     *
     * @param string $batchId Batch run ID
     * @param array $data Cancel payload
     * @return void
     * @todo Implement
     */
    public function cancelRun(string $batchId, array $data)
    {
        // TODO: Implement
    }

    /**
     * List messages from a batch run (global batch messages endpoint).
     * GET /batch-runs/{batch_id}/messages
     *
     * @param string $batchId Batch run ID
     * @return array List of message objects
     */
    public function listBatchMessages(string $batchId)
    {
        $response = $this->http->request('GET', "/batch-runs/{$batchId}/messages");
        return $response;
    }
} 