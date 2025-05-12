<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/groups endpoints.
 */
class Groups
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Groups constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all groups.
     * GET /v1/groups/
     */
    public function list(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Create a new group.
     * POST /v1/groups/
     */
    public function create(array $data)
    {
        $response = $this->http->request('POST', '/v1/groups/', ['body' => $data]);
        return (object) $response;
    }

    /**
     * Count groups.
     * GET /v1/groups/count
     */
    public function count(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Retrieve group by ID.
     * GET /v1/groups/{group_id}
     */
    public function retrieve(string $groupId)
    {
        $response = $this->http->request('GET', "/v1/groups/{$groupId}");
        return (object) $response;
    }

    /**
     * Modify group by ID.
     * PATCH /v1/groups/{group_id}
     */
    public function modify(string $groupId, array $data)
    {
        // TODO: Implement
    }

    /**
     * Delete group by ID.
     * DELETE /v1/groups/{group_id}
     */
    public function delete(string $groupId)
    {
        $this->http->request('DELETE', "/v1/groups/{$groupId}");
        return true;
    }
} 