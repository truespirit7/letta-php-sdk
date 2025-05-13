<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/blocks endpoints.
 *
 * Provides methods to interact with Letta block resources, including listing, creating, retrieving, deleting, and modifying blocks.
 */
class Blocks
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Blocks constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all blocks.
     * GET /v1/blocks/
     *
     * @param array $params Optional query parameters
     * @return void
     * @todo Implement
     */
    public function list(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Create a new block.
     * POST /v1/blocks/
     *
     * @param array $data Block creation payload
     * @return object Block object
     */
    public function create(array $data)
    {
        $response = $this->http->request('POST', '/v1/blocks/', ['body' => $data]);
        return (object) $response;
    }

    /**
     * Retrieve block by ID.
     * GET /v1/blocks/{block_id}
     *
     * @param string $blockId Block ID
     * @return object Block object
     */
    public function retrieve(string $blockId)
    {
        $response = $this->http->request('GET', "/v1/blocks/{$blockId}");
        return (object) $response;
    }

    /**
     * Delete block by ID.
     * DELETE /v1/blocks/{block_id}
     *
     * @param string $blockId Block ID
     * @return bool True on success
     */
    public function delete(string $blockId)
    {
        $this->http->request('DELETE', "/v1/blocks/{$blockId}");
        return true;
    }

    /**
     * Modify block by ID.
     * PATCH /v1/blocks/{block_id}
     *
     * @param string $blockId Block ID
     * @param array $data Modification payload
     * @return void
     * @todo Implement
     */
    public function modify(string $blockId, array $data)
    {
        // TODO: Implement
    }
} 