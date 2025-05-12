<?php

namespace Letta\Resources;

use Letta\Http\HttpClient;

/**
 * Resource class for /v1/voice endpoints.
 */
class Voice
{
    /**
     * @var HttpClient
     */
    private $http;

    /**
     * Voice constructor.
     *
     * @param HttpClient $http
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create voice chat completion.
     * POST /v1/voice/chat-completions
     */
    public function createVoiceChatCompletion(array $data)
    {
        $response = $this->http->request('POST', '/v1/voice/chat-completions', ['body' => $data]);
        return $response;
    }
} 