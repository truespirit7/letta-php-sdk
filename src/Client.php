<?php

namespace Letta;

use Letta\Http\HttpClient;
use Letta\Resources\Agents;
use Letta\Resources\Tools;
use Letta\Resources\Blocks;
use Letta\Resources\Identities;
use Letta\Resources\Sources;
use Letta\Resources\Groups;
use Letta\Resources\Models\Models;
use Letta\Resources\Tags;
use Letta\Resources\Batches;
use Letta\Resources\Voice;
use Letta\Resources\Templates;
use Letta\Resources\Providers;
use Letta\Resources\Runs;
use Letta\Resources\Steps;
use Letta\Resources\Health;
use Letta\Resources\Jobs;

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

    private $httpClient;
    private $agents;
    private $tools;
    private $blocks;
    private $identities;
    private $sources;
    private $groups;
    private $models;
    private $tags;
    private $batches;
    private $voice;
    private $templates;
    private $providers;
    private $runs;
    private $steps;
    private $health;
    private $jobs;

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
        $this->httpClient = new HttpClient($this->baseUrl, $this->token);
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

    public function agents(): Agents
    {
        if (!$this->agents) {
            $this->agents = new Agents($this->httpClient);
        }
        return $this->agents;
    }

    public function tools(): Tools
    {
        if (!$this->tools) {
            $this->tools = new Tools($this->httpClient);
        }
        return $this->tools;
    }

    public function blocks(): Blocks
    {
        if (!$this->blocks) {
            $this->blocks = new Blocks($this->httpClient);
        }
        return $this->blocks;
    }

    public function identities(): Identities
    {
        if (!$this->identities) {
            $this->identities = new Identities($this->httpClient);
        }
        return $this->identities;
    }

    public function sources(): Sources
    {
        if (!$this->sources) {
            $this->sources = new Sources($this->httpClient);
        }
        return $this->sources;
    }

    public function groups(): Groups
    {
        if (!$this->groups) {
            $this->groups = new Groups($this->httpClient);
        }
        return $this->groups;
    }

    public function models(): Models
    {
        if (!$this->models) {
            $this->models = new Models($this->httpClient);
        }
        return $this->models;
    }

    public function tags(): Tags
    {
        if (!$this->tags) {
            $this->tags = new Tags($this->httpClient);
        }
        return $this->tags;
    }

    public function batches(): Batches
    {
        if (!$this->batches) {
            $this->batches = new Batches($this->httpClient);
        }
        return $this->batches;
    }

    public function voice(): Voice
    {
        if (!$this->voice) {
            $this->voice = new Voice($this->httpClient);
        }
        return $this->voice;
    }

    public function templates(): Templates
    {
        if (!$this->templates) {
            $this->templates = new Templates($this->httpClient);
        }
        return $this->templates;
    }

    public function providers(): Providers
    {
        if (!$this->providers) {
            $this->providers = new Providers($this->httpClient);
        }
        return $this->providers;
    }

    public function runs(): Runs
    {
        if (!$this->runs) {
            $this->runs = new Runs($this->httpClient);
        }
        return $this->runs;
    }

    public function steps(): Steps
    {
        if (!$this->steps) {
            $this->steps = new Steps($this->httpClient);
        }
        return $this->steps;
    }

    public function health(): Health
    {
        if (!$this->health) {
            $this->health = new Health($this->httpClient);
        }
        return $this->health;
    }

    public function jobs(): Jobs
    {
        if (!$this->jobs) {
            $this->jobs = new Jobs($this->httpClient);
        }
        return $this->jobs;
    }

    // TODO: Add resource accessors (e.g., $client->agents(), $client->tools(), etc.)
} 