<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/sources endpoints.
 */
class Sources
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Sources constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all sources.
     * GET /v1/sources/
     */
    public function list(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Create a new source.
     * POST /v1/sources/
     */
    public function create(array $data)
    {
        $response = $this->http->request('POST', '/v1/sources/', ['body' => $data]);
        return (object) $response;
    }

    /**
     * Count sources.
     * GET /v1/sources/count
     */
    public function count(array $params = [])
    {
        // TODO: Implement
    }

    /**
     * Retrieve source by ID.
     * GET /v1/sources/{source_id}
     */
    public function retrieve(string $sourceId)
    {
        $response = $this->http->request('GET', "/v1/sources/{$sourceId}");
        return (object) $response;
    }

    /**
     * Modify source by ID.
     * PATCH /v1/sources/{source_id}
     */
    public function modify(string $sourceId, array $data)
    {
        // TODO: Implement
    }

    /**
     * Delete source by ID.
     * DELETE /v1/sources/{source_id}
     */
    public function delete(string $sourceId)
    {
        $this->http->request('DELETE', "/v1/sources/{$sourceId}");
        return true;
    }

    /**
     * Get source ID by name.
     * GET /v1/sources/id/{name}
     */
    public function getIdByName(string $name)
    {
        // TODO: Implement
    }

    /**
     * List source files.
     * GET /v1/sources/{source_id}/files
     */
    public function listFiles(string $sourceId)
    {
        // TODO: Implement
    }

    /**
     * Upload file to source.
     * POST /v1/sources/{source_id}/files
     */
    public function uploadFile(string $sourceId, $file)
    {
        // TODO: Implement
    }

    /**
     * Delete file from source.
     * DELETE /v1/sources/{source_id}/files/{file_id}
     */
    public function deleteFile(string $sourceId, string $fileId)
    {
        // TODO: Implement
    }

    /**
     * List source passages.
     * GET /v1/sources/{source_id}/passages
     */
    public function listPassages(string $sourceId)
    {
        // TODO: Implement
    }
} 