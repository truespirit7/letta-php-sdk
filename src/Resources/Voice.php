<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/voice endpoints.
 *
 * Provides methods to interact with Letta voice resources, including creating voice chat completions.
 */
class Voice
{
    /**
     * @var HttpClient HTTP client for making API requests.
     */
    private $http;

    /**
     * Voice constructor.
     *
     * @param HttpClient $http HTTP client instance
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create voice chat completion.
     * POST /v1/voice/chat-completions
     *
     * @param array $data Voice chat completion payload
     * @return array API response
     */
    public function createVoiceChatCompletion(array $data)
    {
        $response = $this->http->request('POST', '/v1/voice/chat-completions', ['body' => $data]);
        return $response;
    }
} 