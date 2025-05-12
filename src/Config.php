<?php

namespace Letta;

/**
 * Configuration holder for Letta SDK (base URL, token, options).
 */
class Config
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
     * Config constructor.
     *
     * @param string $token
     * @param string $baseUrl
     * @param array $options
     */
    public function __construct(string $token, string $baseUrl, array $options = [])
    {
        $this->token = $token;
        $this->baseUrl = $baseUrl;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
} 