<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/groups endpoints.
 *
 * Provides methods to interact with Letta group resources, including listing, creating, counting, retrieving, modifying, and deleting groups.
 */
class Groups
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Groups constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all groups.
     * GET /v1/groups/
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
     * Create a new group.
     * POST /v1/groups/
     *
     * @param array $data Group creation payload
     * @return object Group object
     */
    public function create(array $data)
    {
        $response = $this->http->request('POST', '/v1/groups/', ['body' => $data]);
        return (object) $response;
    }

    /**
     * Count groups.
     * GET /v1/groups/count
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
     * Retrieve group by ID.
     * GET /v1/groups/{group_id}
     *
     * @param string $groupId Group ID
     * @return object Group object
     */
    public function retrieve(string $groupId)
    {
        $response = $this->http->request('GET', "/v1/groups/{$groupId}");
        return (object) $response;
    }

    /**
     * Modify group by ID.
     * PATCH /v1/groups/{group_id}
     *
     * @param string $groupId Group ID
     * @param array $data Modification payload
     * @return void
     * @todo Implement
     */
    public function modify(string $groupId, array $data)
    {
        // TODO: Implement
    }

    /**
     * Delete group by ID.
     * DELETE /v1/groups/{group_id}
     *
     * @param string $groupId Group ID
     * @return bool True on success
     */
    public function delete(string $groupId)
    {
        $this->http->request('DELETE', "/v1/groups/{$groupId}");
        return true;
    }
} 