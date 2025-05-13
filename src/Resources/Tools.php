<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/tools endpoints.
 *
 * Provides methods to interact with Letta tool resources, including creation, retrieval, update, deletion, advanced tool operations, and integration with Composio and MCP.
 */
class Tools
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Tools constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all tools.
     * GET /v1/tools/
     *
     * @param array $params Optional query parameters
     * @return array List of tool objects
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/tools/');
        return $response;
    }

    /**
     * Create a new tool.
     * POST /v1/tools/
     *
     * @param array $data Tool creation payload
     * @return object Tool object
     */
    public function create(array $data)
    {
        $response = $this->http->request('POST', '/v1/tools/', ['body' => $data]);
        return (object) $response;
    }

    /**
     * Upsert a tool.
     * PUT /v1/tools/
     *
     * @param array $data Tool upsert payload
     * @return object Tool object
     */
    public function upsert(array $data)
    {
        $response = $this->http->request('PUT', '/v1/tools/', ['body' => $data]);
        return (object) $response;
    }

    /**
     * Upsert base tools.
     * POST /v1/tools/base
     *
     * @param array $data Base tool upsert payload
     * @return void
     * @todo Implement
     */
    public function upsertBase(array $data)
    {
        // TODO: Implement
    }

    /**
     * Run tool from source.
     * POST /v1/tools/run-from-source
     *
     * @param array $data Source run payload
     * @return void
     * @todo Implement
     */
    public function runFromSource(array $data)
    {
        // TODO: Implement
    }

    /**
     * List Composio apps.
     * GET /v1/tools/composio/apps
     *
     * @return void
     * @todo Implement
     */
    public function listComposioApps()
    {
        // TODO: Implement
    }

    /**
     * List Composio actions by app.
     * GET /v1/tools/composio/apps/{app_name}/actions
     *
     * @param string $appName App name
     * @return void
     * @todo Implement
     */
    public function listComposioActions(string $appName)
    {
        // TODO: Implement
    }

    /**
     * Add Composio tool.
     * POST /v1/tools/composio
     *
     * @param array $data Composio tool payload
     * @return void
     * @todo Implement
     */
    public function addComposioTool(array $data)
    {
        // TODO: Implement
    }

    /**
     * List MCP servers.
     * GET /v1/tools/mcp/servers
     *
     * @return void
     * @todo Implement
     */
    public function listMcpServers()
    {
        // TODO: Implement
    }

    /**
     * Add MCP server to config.
     * PUT /v1/tools/mcp/servers
     *
     * @param array $data MCP server payload
     * @return void
     * @todo Implement
     */
    public function addMcpServer(array $data)
    {
        // TODO: Implement
    }

    /**
     * List MCP tools by server.
     * GET /v1/tools/mcp/{server_id}/tools
     *
     * @param string $serverId Server ID
     * @return void
     * @todo Implement
     */
    public function listMcpTools(string $serverId)
    {
        // TODO: Implement
    }

    /**
     * Add MCP tool.
     * POST /v1/tools/mcp/tools
     *
     * @param array $data MCP tool payload
     * @return void
     * @todo Implement
     */
    public function addMcpTool(array $data)
    {
        // TODO: Implement
    }

    /**
     * Delete MCP server from config.
     * DELETE /v1/tools/mcp/servers/{server_id}
     *
     * @param string $serverId Server ID
     * @return void
     * @todo Implement
     */
    public function deleteMcpServer(string $serverId)
    {
        // TODO: Implement
    }

    /**
     * Retrieve a tool by ID.
     * GET /v1/tools/{tool_id}
     *
     * @param string $toolId Tool ID
     * @return object Tool object
     */
    public function retrieve(string $toolId)
    {
        $response = $this->http->request('GET', "/v1/tools/{$toolId}");
        return (object) $response;
    }

    /**
     * Delete a tool by ID.
     * DELETE /v1/tools/{tool_id}
     *
     * @param string $toolId Tool ID
     * @return bool True on success
     */
    public function delete(string $toolId)
    {
        $this->http->request('DELETE', "/v1/tools/{$toolId}");
        return true;
    }

    /**
     * Update a tool by ID.
     * PATCH /v1/tools/{tool_id}
     *
     * @param string $toolId Tool ID
     * @param array $data Update payload
     * @return object Tool object
     */
    public function update(string $toolId, array $data)
    {
        $response = $this->http->request('PATCH', "/v1/tools/{$toolId}", ['body' => $data]);
        return (object) $response;
    }

    /**
     * Count tools.
     * GET /v1/tools/count
     *
     * @return int Number of tools
     */
    public function count()
    {
        $response = $this->http->request('GET', '/v1/tools/count');
        // The API returns a plain integer or a JSON integer
        if (is_array($response) && isset($response['count'])) {
            return (int) $response['count'];
        } elseif (is_numeric($response)) {
            return (int) $response;
        }
        return 0;
    }
} 