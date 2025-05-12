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
        $response = $this->http->request('GET', '/v1/models/llm');
        return $response;
    }

    /**
     * List embedding models.
     * GET /v1/models/embedding
     */
    public function listEmbeddingModels()
    {
        $response = $this->http->request('GET', '/v1/models/embedding');
        return $response;
    }

    /**
     * List all models.
     * GET /v1/models/
     */
    public function list()
    {
        $response = $this->http->request('GET', '/v1/models/');
        return $response;
    }
} 