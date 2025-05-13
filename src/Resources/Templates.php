<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/templates endpoints.
 *
 * Provides methods to interact with Letta template resources, including listing templates and creating/versioning templates from agents (cloud-only).
 */
class Templates
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Templates constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all templates.
     * GET /v1/templates/
     *
     * @param array $params Optional query parameters
     * @return array List of template objects
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/templates/');
        return $response;
    }

    /**
     * Create template from agent (Cloud-only).
     * POST /v1/agents/{agent_id}/template
     *
     * @param string $agentId Agent ID
     * @param array $data Optional template creation payload
     * @return array API response
     */
    public function createFromAgent(string $agentId, array $data = [])
    {
        $response = $this->http->request('POST', "/v1/agents/{$agentId}/template", ['body' => $data]);
        return $response;
    }

    /**
     * Version agent template (Cloud-only).
     * POST /v1/agents/{agent_id}/version-template
     *
     * @param string $agentId Agent ID
     * @param array $data Optional versioning payload
     * @return array API response
     */
    public function versionFromAgent(string $agentId, array $data = [])
    {
        $response = $this->http->request('POST', "/v1/agents/{$agentId}/version-template", ['body' => $data]);
        return $response;
    }
} 