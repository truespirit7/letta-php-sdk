<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/agents endpoints.
 */
class Agents
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Agents constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all agents.
     * GET /v1/agents/
     */
    public function list(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Create a new agent.
     * POST /v1/agents/
     */
    public function create(array $data)
    {
        // TODO: Implement
    }

    /**
     * Count agents.
     * GET /v1/agents/count
     */
    public function count(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Export agent serialized.
     * GET /v1/agents/export
     */
    public function export(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * Import agent serialized.
     * POST /v1/agents/import
     */
    public function import(array $serializedAgent)
    {
        // TODO: Implement
    }

    /**
     * Retrieve agent by ID.
     * GET /v1/agents/{agent_id}
     */
    public function retrieve(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * Delete agent by ID.
     * DELETE /v1/agents/{agent_id}
     */
    public function delete(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * Modify agent by ID.
     * PATCH /v1/agents/{agent_id}
     */
    public function modify(string $agentId, array $data)
    {
        // TODO: Implement
    }

    /**
     * Search deployed agents (Cloud-only).
     * POST /v1/agents/search
     */
    public function search(array $criteria)
    {
        // TODO: Implement
    }

    /**
     * Retrieve agent context window.
     * GET /v1/agents/{agent_id}/context
     */
    public function getContext(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * List agent's tools.
     * GET /v1/agents/{agent_id}/tools
     */
    public function listTools(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * Attach tool to agent.
     * PATCH /v1/agents/{agent_id}/tools/attach/{tool_id}
     */
    public function attachTool(string $agentId, string $toolId)
    {
        // TODO: Implement
    }

    /**
     * Detach tool from agent.
     * PATCH /v1/agents/{agent_id}/tools/detach/{tool_id}
     */
    public function detachTool(string $agentId, string $toolId)
    {
        // TODO: Implement
    }

    /**
     * List agent's sources.
     * GET /v1/agents/{agent_id}/sources
     */
    public function listSources(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * Attach source to agent.
     * PATCH /v1/agents/{agent_id}/sources/attach/{source_id}
     */
    public function attachSource(string $agentId, string $sourceId)
    {
        // TODO: Implement
    }

    /**
     * Detach source from agent.
     * PATCH /v1/agents/{agent_id}/sources/detach/{source_id}
     */
    public function detachSource(string $agentId, string $sourceId)
    {
        // TODO: Implement
    }

    /**
     * Retrieve core memory block.
     * GET /v1/agents/{agent_id}/core-memory/blocks/{block_label}
     */
    public function getCoreMemoryBlock(string $agentId, string $blockLabel)
    {
        // TODO: Implement
    }

    /**
     * Modify core memory block.
     * PATCH /v1/agents/{agent_id}/core-memory/blocks/{block_label}
     */
    public function modifyCoreMemoryBlock(string $agentId, string $blockLabel, array $data)
    {
        // TODO: Implement
    }

    /**
     * Attach core memory block.
     * PATCH /v1/agents/{agent_id}/core-memory/blocks/attach/{block_id}
     */
    public function attachCoreMemoryBlock(string $agentId, string $blockId)
    {
        // TODO: Implement
    }

    /**
     * Detach core memory block.
     * PATCH /v1/agents/{agent_id}/core-memory/blocks/detach/{block_id}
     */
    public function detachCoreMemoryBlock(string $agentId, string $blockId)
    {
        // TODO: Implement
    }

    /**
     * List agent messages.
     * GET /v1/agents/{agent_id}/messages
     */
    public function listMessages(string $agentId, array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Send message to agent.
     * POST /v1/agents/{agent_id}/messages
     */
    public function sendMessage(string $agentId, array $messages, array $options = [])
    {
        // TODO: Implement
    }

    /**
     * Modify message.
     * PATCH /v1/agents/{agent_id}/messages/{message_id}
     */
    public function modifyMessage(string $agentId, string $messageId, array $data)
    {
        // TODO: Implement
    }

    /**
     * Send message asynchronously.
     * POST /v1/agents/{agent_id}/messages/async
     */
    public function sendMessageAsync(string $agentId, array $messages, array $options = [])
    {
        // TODO: Implement
    }

    /**
     * Reset agent messages.
     * PATCH /v1/agents/{agent_id}/reset-messages
     */
    public function resetMessages(string $agentId, array $options = [])
    {
        // TODO: Implement
    }
} 