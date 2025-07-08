<?php

namespace Letta\Resources;

use Illuminate\Support\Facades\Http as LaravelHttp;

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
    // public function createVoiceChatCompletion(string $agentId, array $data)
    // {
    //     $response = $this->http->request('POST', '/v1/voice-beta/'.$agentId.'/chat/completions', ['body' => $data]);
    //     // $response = $this->http->request('POST', '/v1/voice/chat-completions', ['body' => $data]);
    //     return $response;
    // }

    public function createVoiceChatCompletion(string $agentId, array $messages, array $options = [])
    {
        $body = array_merge([
            'messages' => $messages,
            'stream' => true
        ], $options);

        $response = LaravelHttp::withHeaders([
            'Authorization' => 'Bearer ' . $_ENV['LETTA_API_TOKEN'],
            'Accept' => 'text/event-stream',
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache',
        ])->withOptions(['stream' => true])
          ->withBody(json_encode($body), 'application/json')
            ->post("https://api.letta.com/v1/voice-beta/{$agentId}/chat/completions");


        $stream = $response->getBody();
        while (!$stream->eof()) {
            $chunk = $stream->read(1024);
            echo $chunk;
            // Важно: обернуть chunk в формат SSE
            echo "data: " . str_replace("\n", "\\n", trim($chunk)) . "\n\n";
            ob_flush();
            flush();
        }


        return response()->stream(function () use ($response) {
            $stream = $response->getBody();
            while (!$stream->eof()) {
                $chunk = $stream->read(1024);
                // Важно: обернуть chunk в формат SSE
                echo "data: " . str_replace("\n", "\\n", trim($chunk)) . "\n\n";
                ob_flush();
                flush();
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no', // для nginx
        ]);
    }
}
