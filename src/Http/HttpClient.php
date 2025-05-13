<?php

namespace Letta\Http;

/**
 * Handles HTTP requests for the Letta SDK, including authentication.
 */
class HttpClient
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $token;

    /**
     * HttpClient constructor.
     *
     * @param string $baseUrl
     * @param string $token
     */
    public function __construct(string $baseUrl, string $token)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->token = $token;
    }

    /**
     * Send an HTTP request to the Letta API.
     *
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $path API endpoint path (e.g., '/v1/agents')
     * @param array $options Request options (query, body, headers, etc.)
     * @return array Response data (to be defined)
     *
     * @throws \Exception on HTTP or network error
     */
    public function request(string $method, string $path, array $options = []): array
    {
        $url = $this->baseUrl . $path;
        $ch = curl_init();
        $headers = [
            'Authorization: Bearer ' . $this->token,
            'Accept: application/json',
        ];
        if (isset($options['headers'])) {
            foreach ($options['headers'] as $key => $value) {
                $headers[] = "$key: $value";
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if (isset($options['body'])) {
            $body = $options['body'];
            if (is_object($body)) {
                $body = (array) $body;
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
                $headers[] = 'Content-Type: application/json';
            }
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        $data = json_decode($response, true);
        if ($data === null && !empty($response)) {
            // Log the raw response for debugging
            error_log('[Letta SDK][DEBUG] Raw API response: ' . $response);
        }
        if ($httpCode >= 400) {
            throw new \Exception('HTTP error ' . $httpCode . ': ' . ($data['error'] ?? $response));
        }
        return $data ?? [];
    }

    // TODO: Add helper methods for GET, POST, etc. if needed
} 