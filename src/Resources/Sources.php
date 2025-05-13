<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/sources endpoints.
 *
 * Provides methods to interact with Letta source resources, including creation, retrieval, modification, deletion, file management, and passage listing.
 */
class Sources
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Sources constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all sources.
     * GET /v1/sources/
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
     * Create a new source.
     * POST /v1/sources/
     *
     * @param array $data Source creation payload
     * @return object Source object
     */
    public function create(array $data)
    {
        $response = $this->http->request('POST', '/v1/sources/', ['body' => $data]);
        return (object) $response;
    }

    /**
     * Count sources.
     * GET /v1/sources/count
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
     * Retrieve source by ID.
     * GET /v1/sources/{source_id}
     *
     * @param string $sourceId Source ID
     * @return object Source object
     */
    public function retrieve(string $sourceId)
    {
        $response = $this->http->request('GET', "/v1/sources/{$sourceId}");
        return (object) $response;
    }

    /**
     * Modify source by ID.
     * PATCH /v1/sources/{source_id}
     *
     * @param string $sourceId Source ID
     * @param array $data Modification payload
     * @return void
     * @todo Implement
     */
    public function modify(string $sourceId, array $data)
    {
        // TODO: Implement
    }

    /**
     * Delete source by ID.
     * DELETE /v1/sources/{source_id}
     *
     * @param string $sourceId Source ID
     * @return bool True on success
     */
    public function delete(string $sourceId)
    {
        $this->http->request('DELETE', "/v1/sources/{$sourceId}");
        return true;
    }

    /**
     * Get source ID by name.
     * GET /v1/sources/id/{name}
     *
     * @param string $name Source name
     * @return void
     * @todo Implement
     */
    public function getIdByName(string $name)
    {
        // TODO: Implement
    }

    /**
     * List files for a source.
     * GET /v1/sources/{source_id}/files
     *
     * @param string $sourceId Source ID
     * @return array List of file objects
     */
    public function listFiles(string $sourceId)
    {
        $response = $this->http->request('GET', "/v1/sources/{$sourceId}/files");
        return $response;
    }

    /**
     * Upload file to source (multipart/form-data).
     * POST /v1/sources/{source_id}/upload
     *
     * @param string $sourceId Source ID
     * @param string $filePath Path to the file to upload
     * @return array Job object representing the upload task
     * @throws \Exception on upload failure
     */
    public function uploadFile(string $sourceId, $filePath)
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("File does not exist: $filePath");
        }
        $ch = curl_init();
        // Get base URL from HttpClient (reflection workaround for private property)
        $baseUrl = null;
        $ref = new \ReflectionClass($this->http);
        if ($ref->hasProperty('baseUrl')) {
            $prop = $ref->getProperty('baseUrl');
            $prop->setAccessible(true);
            $baseUrl = $prop->getValue($this->http);
        }
        if (!$baseUrl) {
            throw new \Exception('Could not determine base URL from HttpClient');
        }
        $url = $baseUrl . "/v1/sources/{$sourceId}/upload";
        // Get token from HttpClient (reflection workaround for private property)
        $token = null;
        if ($ref->hasProperty('token')) {
            $propToken = $ref->getProperty('token');
            $propToken->setAccessible(true);
            $token = $propToken->getValue($this->http);
        }
        if (!$token) {
            throw new \Exception('Could not determine token from HttpClient');
        }
        $headers = [
            'Authorization: Bearer ' . $token,
        ];
        $filename = basename($filePath);
        $mime = 'application/pdf';
        $postFields = [
            'file' => new \CURLFile($filePath, $mime, $filename)
        ];
        $verbosePath = getcwd() . '/curl_upload_verbose.log';
        $debugFile = sys_get_temp_dir() . '/debug_upload.txt';
        file_put_contents($debugFile, '[DEBUG] Attempting to open verbose log at: ' . $verbosePath . "\n", FILE_APPEND);
        $verbose = fopen($verbosePath, 'w+');
        if (!$verbose) {
            file_put_contents($debugFile, '[DEBUG] Failed to open verbose log file: ' . $verbosePath . "\n", FILE_APPEND);
            throw new \Exception('Failed to open verbose log file: ' . $verbosePath);
        }
        file_put_contents($debugFile, '[DEBUG] Verbose log opened successfully.' . "\n", FILE_APPEND);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_STDERR, $verbose);
        file_put_contents($debugFile, '[DEBUG] Starting cURL file upload...' . "\n", FILE_APPEND);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        file_put_contents($debugFile, '[DEBUG] cURL file upload complete.' . "\n", FILE_APPEND);
        if (curl_errno($ch)) {
            file_put_contents($debugFile, '[DEBUG] Curl error: ' . curl_error($ch) . "\n", FILE_APPEND);
            fclose($verbose);
            throw new \Exception('Curl error: ' . curl_error($ch));
        }
        fclose($verbose);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $data = json_decode($response, true);
        if ($httpCode >= 400) {
            file_put_contents($debugFile, '[DEBUG] HTTP error ' . $httpCode . ': ' . ($data['error'] ?? $response) . "\n", FILE_APPEND);
            throw new \Exception('HTTP error ' . $httpCode . ': ' . ($data['error'] ?? $response));
        }
        file_put_contents($debugFile, '[DEBUG] File upload successful.' . "\n", FILE_APPEND);
        return $data ?? [];
    }

    /**
     * Delete file from source.
     * DELETE /v1/sources/{source_id}/{file_id}
     *
     * @param string $sourceId Source ID
     * @param string $fileId File ID
     * @return bool True on success
     */
    public function deleteFile(string $sourceId, string $fileId)
    {
        $this->http->request('DELETE', "/v1/sources/{$sourceId}/{$fileId}");
        return true;
    }

    /**
     * List passages for a source.
     * GET /v1/sources/{source_id}/passages
     *
     * @param string $sourceId Source ID
     * @return array List of passage objects
     */
    public function listPassages(string $sourceId)
    {
        $response = $this->http->request('GET', "/v1/sources/{$sourceId}/passages");
        return $response;
    }
} 