<?php

namespace Letta\Models;

/**
 * Data model for an Agent object.
 *
 * @property string $id
 * @property string $name
 * @property string $system
 * @property string $agent_type
 * @property array $llm_config
 * @property array $embedding_config
 * @property array $memory
 * @property array $tools
 * @property array $sources
 * @property array $tags
 * @property string|null $created_by_id
 * @property string|null $last_updated_by_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property array|null $tool_rules
 * @property array|null $message_ids
 * @property array|null $response_format
 * @property string|null $description
 * @property array|null $metadata
 * @property array|null $tool_exec_environment_variables
 * @property string|null $project_id
 * @property string|null $template_id
 * @property string|null $base_template_id
 * @property array|null $identity_ids
 * @property bool|null $message_buffer_autoclear
 * @property bool|null $enable_sleeptime
 * @property array|null $multi_agent_group
 */
class Agent
{
    public $id;
    public $name;
    public $system;
    public $agent_type;
    public $llm_config;
    public $embedding_config;
    public $memory;
    public $tools;
    public $sources;
    public $tags;
    public $created_by_id;
    public $last_updated_by_id;
    public $created_at;
    public $updated_at;
    public $tool_rules;
    public $message_ids;
    public $response_format;
    public $description;
    public $metadata;
    public $tool_exec_environment_variables;
    public $project_id;
    public $template_id;
    public $base_template_id;
    public $identity_ids;
    public $message_buffer_autoclear;
    public $enable_sleeptime;
    public $multi_agent_group;

    // TODO: Add constructor, validation, and type safety improvements
} 