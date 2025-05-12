<?php

namespace Letta;

/**
 * Main entry point for the Letta PHP SDK.
 * Manages configuration and exposes resource classes.
 */
class Client
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
     * @var array
     */
    private $options;

    /**
     * Client constructor.
     *
     * @param string $token  Bearer token for authentication
     * @param string $baseUrl  API base URL (default: 'https://api.letta.com')
     * @param array $options  Additional options (optional)
     */
    public function __construct(string $token, string $baseUrl = 'https://api.letta.com', array $options = [])
    {
        $this->token = $token;
        $this->baseUrl = $baseUrl;
        $this->options = $options;
    }

    /**
     * Get the API base URL.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Get the Bearer token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Get additional options.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    // TODO: Add resource accessors (e.g., $client->agents(), $client->tools(), etc.)
} 