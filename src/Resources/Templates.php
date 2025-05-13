<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/templates endpoints.
 */
class Templates
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Templates constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all templates.
     * GET /v1/templates/
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/templates/');
        return $response;
    }

    /**
     * Create template from agent (Cloud-only).
     * POST /v1/agents/{agent_id}/template
     */
    public function createFromAgent(string $agentId, array $data = [])
    {
        $response = $this->http->request('POST', "/v1/agents/{$agentId}/template", ['body' => $data]);
        return $response;
    }

    /**
     * Version agent template (Cloud-only).
     * POST /v1/agents/{agent_id}/version-template
     */
    public function versionFromAgent(string $agentId, array $data = [])
    {
        $response = $this->http->request('POST', "/v1/agents/{$agentId}/version-template", ['body' => $data]);
        return $response;
    }
} 