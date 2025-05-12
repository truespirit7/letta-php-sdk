<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/tools endpoints.
 */
class Tools
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Tools constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all tools.
     * GET /v1/tools/
     */
    public function list(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Create a new tool.
     * POST /v1/tools/
     */
    public function create(array $data)
    {
        // TODO: Implement
    }

    /**
     * Upsert a tool.
     * PUT /v1/tools/
     */
    public function upsert(array $data)
    {
        // TODO: Implement
    }

    /**
     * Upsert base tools.
     * POST /v1/tools/base
     */
    public function upsertBase(array $data)
    {
        // TODO: Implement
    }

    /**
     * Run tool from source.
     * POST /v1/tools/run-from-source
     */
    public function runFromSource(array $data)
    {
        // TODO: Implement
    }

    /**
     * List Composio apps.
     * GET /v1/tools/composio/apps
     */
    public function listComposioApps()
    {
        // TODO: Implement
    }

    /**
     * List Composio actions by app.
     * GET /v1/tools/composio/apps/{app_name}/actions
     */
    public function listComposioActions(string $appName)
    {
        // TODO: Implement
    }

    /**
     * Add Composio tool.
     * POST /v1/tools/composio
     */
    public function addComposioTool(array $data)
    {
        // TODO: Implement
    }

    /**
     * List MCP servers.
     * GET /v1/tools/mcp/servers
     */
    public function listMcpServers()
    {
        // TODO: Implement
    }

    /**
     * Add MCP server to config.
     * PUT /v1/tools/mcp/servers
     */
    public function addMcpServer(array $data)
    {
        // TODO: Implement
    }

    /**
     * List MCP tools by server.
     * GET /v1/tools/mcp/{server_id}/tools
     */
    public function listMcpTools(string $serverId)
    {
        // TODO: Implement
    }

    /**
     * Add MCP tool.
     * POST /v1/tools/mcp/tools
     */
    public function addMcpTool(array $data)
    {
        // TODO: Implement
    }

    /**
     * Delete MCP server from config.
     * DELETE /v1/tools/mcp/servers/{server_id}
     */
    public function deleteMcpServer(string $serverId)
    {
        // TODO: Implement
    }
} 