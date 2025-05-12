<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/blocks endpoints.
 */
class Blocks
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Blocks constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all blocks.
     * GET /v1/blocks/
     */
    public function list(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Create a new block.
     * POST /v1/blocks/
     */
    public function create(array $data)
    {
        // TODO: Implement
    }

    /**
     * Retrieve block by ID.
     * GET /v1/blocks/{block_id}
     */
    public function retrieve(string $blockId)
    {
        // TODO: Implement
    }

    /**
     * Delete block by ID.
     * DELETE /v1/blocks/{block_id}
     */
    public function delete(string $blockId)
    {
        // TODO: Implement
    }

    /**
     * Modify block by ID.
     * PATCH /v1/blocks/{block_id}
     */
    public function modify(string $blockId, array $data)
    {
        // TODO: Implement
    }
} 