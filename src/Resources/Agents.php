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
     * @return array List of agent objects
     */
    public function list(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/agents/', [
            'query' => $params
        ]);
        return $response;
    }

    /**
     * Create a new agent.
     * POST /v1/agents/
     *
     * @param array $data Agent creation payload
     * @return array Agent object
     */
    public function create(array $data)
    {
        $response = $this->http->request('POST', '/v1/agents/', [
            'body' => $data
        ]);
        return $response;
    }

    /**
     * Count agents.
     * GET /v1/agents/count
     *
     * @param array $params Optional query parameters
     * @return int Number of agents
     */
    public function count(array $params = [])
    {
        $response = $this->http->request('GET', '/v1/agents/count', [
            'query' => $params
        ]);
        if (is_array($response) && isset($response['count'])) {
            return (int) $response['count'];
        } elseif (is_numeric($response)) {
            return (int) $response;
        }
        return 0;
    }

    /**
     * Export agent serialized.
     * GET /v1/agents/export
     *
     * @param string $agentId Agent ID
     * @return array Exported agent data
     */
    public function export(string $agentId)
    {
        $response = $this->http->request('GET', '/v1/agents/export', [
            'query' => ['agent_id' => $agentId]
        ]);
        return $response;
    }

    /**
     * Import agent serialized.
     * POST /v1/agents/import
     *
     * @param array $serializedAgent Serialized agent data
     * @return array Imported agent object
     */
    public function import(array $serializedAgent)
    {
        $response = $this->http->request('POST', '/v1/agents/import', [
            'body' => $serializedAgent
        ]);
        return $response;
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
     * @return bool True on success
     */
    public function delete(string $agentId)
    {
        $this->http->request('DELETE', "/v1/agents/{$agentId}");
        return true;
    }

    /**
     * Modify agent by ID.
     * PATCH /v1/agents/{agent_id}
     *
     * @param string $agentId Agent ID
     * @param array $data Modification payload
     * @return array Modified agent object
     */
    public function modify(string $agentId, array $data)
    {
        $response = $this->http->request('PATCH', "/v1/agents/{$agentId}", [
            'body' => $data
        ]);
        return $response;
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
     * @return array Context window object
     */
    public function getContext(string $agentId)
    {
        $response = $this->http->request('GET', "/v1/agents/{$agentId}/context");
        return $response;
    }

    /**
     * List agent's tools.
     * GET /v1/agents/{agent_id}/tools
     *
     * @param string $agentId Agent ID
     * @return array List of tool objects
     */
    public function listTools(string $agentId)
    {
        $response = $this->http->request('GET', "/v1/agents/{$agentId}/tools");
        return $response;
    }

    /**
     * Attach tool to agent.
     * PATCH /v1/agents/{agent_id}/tools/attach/{tool_id}
     *
     * @param string $agentId Agent ID
     * @param string $toolId Tool ID
     * @return array Updated agent object
     */
    public function attachTool(string $agentId, string $toolId)
    {
        $response = $this->http->request('PATCH', "/v1/agents/{$agentId}/tools/attach/{$toolId}");
        return $response;
    }

    /**
     * Detach tool from agent.
     * PATCH /v1/agents/{agent_id}/tools/detach/{tool_id}
     *
     * @param string $agentId Agent ID
     * @param string $toolId Tool ID
     * @return array Updated agent object
     */
    public function detachTool(string $agentId, string $toolId)
    {
        $response = $this->http->request('PATCH', "/v1/agents/{$agentId}/tools/detach/{$toolId}");
        return $response;
    }

    /**
     * List agent's sources.
     * GET /v1/agents/{agent_id}/sources
     *
     * @param string $agentId Agent ID
     * @return array List of source objects
     */
    public function listSources(string $agentId)
    {
        $response = $this->http->request('GET', "/v1/agents/{$agentId}/sources");
        return $response;
    }

    /**
     * Attach source to agent.
     * PATCH /v1/agents/{agent_id}/sources/attach/{source_id}
     *
     * @param string $agentId Agent ID
     * @param string $sourceId Source ID
     * @return array Updated agent object
     */
    public function attachSource(string $agentId, string $sourceId)
    {
        $response = $this->http->request('PATCH', "/v1/agents/{$agentId}/sources/attach/{$sourceId}");
        return $response;
    }

    /**
     * Detach source from agent.
     * PATCH /v1/agents/{agent_id}/sources/detach/{source_id}
     *
     * @param string $agentId Agent ID
     * @param string $sourceId Source ID
     * @return array Updated agent object
     */
    public function detachSource(string $agentId, string $sourceId)
    {
        $response = $this->http->request('PATCH', "/v1/agents/{$agentId}/sources/detach/{$sourceId}");
        return $response;
    }

    /**
     * Retrieve core memory block.
     * GET /v1/agents/{agent_id}/core-memory/blocks/{block_label}
     *
     * @param string $agentId Agent ID
     * @param string $blockLabel Block label
     * @return array Block object
     */
    public function getCoreMemoryBlock(string $agentId, string $blockLabel)
    {
        $response = $this->http->request('GET', "/v1/agents/{$agentId}/core-memory/blocks/{$blockLabel}");
        return $response;
    }

    /**
     * Modify core memory block.
     * PATCH /v1/agents/{agent_id}/core-memory/blocks/{block_label}
     *
     * @param string $agentId Agent ID
     * @param string $blockLabel Block label
     * @param array $data Modification payload
     * @return array Block object
     */
    public function modifyCoreMemoryBlock(string $agentId, string $blockLabel, array $data)
    {
        $response = $this->http->request('PATCH', "/v1/agents/{$agentId}/core-memory/blocks/{$blockLabel}", [
            'body' => $data
        ]);
        return $response;
    }

    /**
     * Attach core memory block.
     * PATCH /v1/agents/{agent_id}/core-memory/blocks/attach/{block_id}
     *
     * @param string $agentId Agent ID
     * @param string $blockId Block ID
     * @return array Updated agent object
     */
    public function attachCoreMemoryBlock(string $agentId, string $blockId)
    {
        $response = $this->http->request('PATCH', "/v1/agents/{$agentId}/core-memory/blocks/attach/{$blockId}");
        return $response;
    }

    /**
     * Detach core memory block.
     * PATCH /v1/agents/{agent_id}/core-memory/blocks/detach/{block_id}
     *
     * @param string $agentId Agent ID
     * @param string $blockId Block ID
     * @return array Updated agent object
     */
    public function detachCoreMemoryBlock(string $agentId, string $blockId)
    {
        $response = $this->http->request('PATCH', "/v1/agents/{$agentId}/core-memory/blocks/detach/{$blockId}");
        return $response;
    }

    /**
     * List agent messages.
     * GET /v1/agents/{agent_id}/messages
     *
     * @param string $agentId Agent ID
     * @param array $params Optional query parameters
     * @return array List of message objects
     */
    public function listMessages(string $agentId, array $params = [])
    {
        $response = $this->http->request('GET', "/v1/agents/{$agentId}/messages", [
            'query' => $params
        ]);
        return $response;
    }

    /**
     * Send message to agent.
     * POST /v1/agents/{agent_id}/messages
     *
     * @param string $agentId Agent ID
     * @param array $messages Message payload (array of message objects)
     * @param array $options Optional options (e.g., use_assistant_message)
     * @return array API response (messages, usage, etc.)
     */
    public function sendMessage(string $agentId, array $messages, array $options = [])
    {
        $body = array_merge(['messages' => $messages], $options);
        $response = $this->http->request('POST', "/v1/agents/{$agentId}/messages", [
            'body' => $body
        ]);
        return $response;
    }

    /**
     * Modify message.
     * PATCH /v1/agents/{agent_id}/messages/{message_id}
     *
     * @param string $agentId Agent ID
     * @param string $messageId Message ID
     * @param array $data Modification payload
     * @return array API response (updated message)
     */
    public function modifyMessage(string $agentId, string $messageId, array $data)
    {
        $response = $this->http->request('PATCH', "/v1/agents/{$agentId}/messages/{$messageId}", [
            'body' => $data
        ]);
        return $response;
    }

    /**
     * Send message asynchronously.
     * POST /v1/agents/{agent_id}/messages/async
     *
     * @param string $agentId Agent ID
     * @param array $messages Message payload (array of message objects)
     * @param array $options Optional options
     * @return array API response (run object)
     */
    public function sendMessageAsync(string $agentId, array $messages, array $options = [])
    {
        $body = array_merge(['messages' => $messages], $options);
        $response = $this->http->request('POST', "/v1/agents/{$agentId}/messages/async", [
            'body' => $body
        ]);
        return $response;
    }

    /**
     * Reset agent messages.
     * PATCH /v1/agents/{agent_id}/reset-messages
     *
     * @param string $agentId Agent ID
     * @param array $options Optional options (e.g., add_default_initial_messages)
     * @return array API response (agent object)
     */
    public function resetMessages(string $agentId, array $options = [])
    {
        $response = $this->http->request('PATCH', "/v1/agents/{$agentId}/reset-messages", [
            'body' => $options
        ]);
        return $response;
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