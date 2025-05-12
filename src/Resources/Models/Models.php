<?php

namespace Letta\Resources\Models;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/models endpoints.
 */
class Models
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Models constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List LLM models.
     * GET /v1/models/llm
     */
    public function listLlmModels()
    {
        // TODO: Implement
    }

    /**
     * List embedding models.
     * GET /v1/models/embedding
     */
    public function listEmbeddingModels()
    {
        // TODO: Implement
    }
} 