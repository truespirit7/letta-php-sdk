<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/agents endpoints.
 *
 * Provides methods to interact with Letta agent resources, including creation, retrieval, modification, deletion, and management of tools, sources, memory, and messages.
 */
class Agents
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Agents constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all agents.
     * GET /v1/agents/
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
     * Create a new agent.
     * POST /v1/agents/
     *
     * @param array $data Agent creation payload
     * @return void
     * @todo Implement
     */
    public function create(array $data)
    {
        // TODO: Implement
    }

    /**
     * Count agents.
     * GET /v1/agents/count
     *
     * @param array $params Optional query parameters
     * @return void
     * @todo Implement
     */
    public function count(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Export agent serialized.
     * GET /v1/agents/export
     *
     * @param string $agentId Agent ID
     * @return void
     * @todo Implement
     */
    public function export(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * Import agent serialized.
     * POST /v1/agents/import
     *
     * @param array $serializedAgent Serialized agent data
     * @return void
     * @todo Implement
     */
    public function import(array $serializedAgent)
    {
        // TODO: Implement
    }

    /**
     * Retrieve agent by ID.
     * GET /v1/agents/{agent_id}
     *
     * @param string $agentId Agent ID
     * @return object Agent object
     */
    public function retrieve(string $agentId)
    {
        $response = $this->http->request('GET', "/v1/agents/{$agentId}");
        return (object) $response;
    }

    /**
     * Delete agent by ID.
     * DELETE /v1/agents/{agent_id}
     *
     * @param string $agentId Agent ID
     * @return void
     * @todo Implement
     */
    public function delete(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * Modify agent by ID.
     * PATCH /v1/agents/{agent_id}
     *
     * @param string $agentId Agent ID
     * @param array $data Modification payload
     * @return void
     * @todo Implement
     */
    public function modify(string $agentId, array $data)
    {
        // TODO: Implement
    }

    /**
     * Search deployed agents (Cloud-only).
     * POST /v1/agents/search
     *
     * @param array $criteria Search criteria
     * @return void
     * @todo Implement
     */
    public function search(array $criteria)
    {
        // TODO: Implement
    }

    /**
     * Retrieve agent context window.
     * GET /v1/agents/{agent_id}/context
     *
     * @param string $agentId Agent ID
     * @return void
     * @todo Implement
     */
    public function getContext(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * List agent's tools.
     * GET /v1/agents/{agent_id}/tools
     *
     * @param string $agentId Agent ID
     * @return void
     * @todo Implement
     */
    public function listTools(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * Attach tool to agent.
     * PATCH /v1/agents/{agent_id}/tools/attach/{tool_id}
     *
     * @param string $agentId Agent ID
     * @param string $toolId Tool ID
     * @return void
     * @todo Implement
     */
    public function attachTool(string $agentId, string $toolId)
    {
        // TODO: Implement
    }

    /**
     * Detach tool from agent.
     * PATCH /v1/agents/{agent_id}/tools/detach/{tool_id}
     *
     * @param string $agentId Agent ID
     * @param string $toolId Tool ID
     * @return void
     * @todo Implement
     */
    public function detachTool(string $agentId, string $toolId)
    {
        // TODO: Implement
    }

    /**
     * List agent's sources.
     * GET /v1/agents/{agent_id}/sources
     *
     * @param string $agentId Agent ID
     * @return void
     * @todo Implement
     */
    public function listSources(string $agentId)
    {
        // TODO: Implement
    }

    /**
     * Attach source to agent.
     * PATCH /v1/agents/{agent_id}/sources/attach/{source_id}
     *
     * @param string $agentId Agent ID
     * @param string $sourceId Source ID
     * @return void
     * @todo Implement
     */
    public function attachSource(string $agentId, string $sourceId)
    {
        // TODO: Implement
    }

    /**
     * Detach source from agent.
     * PATCH /v1/agents/{agent_id}/sources/detach/{source_id}
     *
     * @param string $agentId Agent ID
     * @param string $sourceId Source ID
     * @return void
     * @todo Implement
     */
    public function detachSource(string $agentId, string $sourceId)
    {
        // TODO: Implement
    }

    /**
     * Retrieve core memory block.
     * GET /v1/agents/{agent_id}/core-memory/blocks/{block_label}
     *
     * @param string $agentId Agent ID
     * @param string $blockLabel Block label
     * @return void
     * @todo Implement
     */
    public function getCoreMemoryBlock(string $agentId, string $blockLabel)
    {
        // TODO: Implement
    }

    /**
     * Modify core memory block.
     * PATCH /v1/agents/{agent_id}/core-memory/blocks/{block_label}
     *
     * @param string $agentId Agent ID
     * @param string $blockLabel Block label
     * @param array $data Modification payload
     * @return void
     * @todo Implement
     */
    public function modifyCoreMemoryBlock(string $agentId, string $blockLabel, array $data)
    {
        // TODO: Implement
    }

    /**
     * Attach core memory block.
     * PATCH /v1/agents/{agent_id}/core-memory/blocks/attach/{block_id}
     *
     * @param string $agentId Agent ID
     * @param string $blockId Block ID
     * @return void
     * @todo Implement
     */
    public function attachCoreMemoryBlock(string $agentId, string $blockId)
    {
        // TODO: Implement
    }

    /**
     * Detach core memory block.
     * PATCH /v1/agents/{agent_id}/core-memory/blocks/detach/{block_id}
     *
     * @param string $agentId Agent ID
     * @param string $blockId Block ID
     * @return void
     * @todo Implement
     */
    public function detachCoreMemoryBlock(string $agentId, string $blockId)
    {
        // TODO: Implement
    }

    /**
     * List agent messages.
     * GET /v1/agents/{agent_id}/messages
     *
     * @param string $agentId Agent ID
     * @param array $params Optional query parameters
     * @return void
     * @todo Implement
     */
    public function listMessages(string $agentId, array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Send message to agent.
     * POST /v1/agents/{agent_id}/messages
     *
     * @param string $agentId Agent ID
     * @param array $messages Message payload
     * @param array $options Optional options
     * @return void
     * @todo Implement
     */
    public function sendMessage(string $agentId, array $messages, array $options = [])
    {
        // TODO: Implement
    }

    /**
     * Modify message.
     * PATCH /v1/agents/{agent_id}/messages/{message_id}
     *
     * @param string $agentId Agent ID
     * @param string $messageId Message ID
     * @param array $data Modification payload
     * @return void
     * @todo Implement
     */
    public function modifyMessage(string $agentId, string $messageId, array $data)
    {
        // TODO: Implement
    }

    /**
     * Send message asynchronously.
     * POST /v1/agents/{agent_id}/messages/async
     *
     * @param string $agentId Agent ID
     * @param array $messages Message payload
     * @param array $options Optional options
     * @return void
     * @todo Implement
     */
    public function sendMessageAsync(string $agentId, array $messages, array $options = [])
    {
        // TODO: Implement
    }

    /**
     * Reset agent messages.
     * PATCH /v1/agents/{agent_id}/reset-messages
     *
     * @param string $agentId Agent ID
     * @param array $options Optional options
     * @return void
     * @todo Implement
     */
    public function resetMessages(string $agentId, array $options = [])
    {
        // TODO: Implement
    }

    /**
     * Get memory variables for an agent (Cloud-only).
     * GET /v1/agents/{agent_id}/core-memory/variables
     *
     * @param string $agentId Agent ID
     * @return array Memory variables
     */
    public function getCoreMemoryVariables(string $agentId)
    {
        $response = $this->http->request('GET', "/v1/agents/{$agentId}/core-memory/variables");
        return $response;
    }
} 