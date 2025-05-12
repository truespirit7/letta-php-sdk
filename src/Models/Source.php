<?php

namespace Letta\Models;

/**
 * Data model for a Source object.
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $instructions
 * @property array $embedding_config
 * @property array $metadata
 * @property string $created_by_id
 * @property string $last_updated_by_id
 * @property string $created_at
 * @property string $updated_at
 */
class Source
{
    public $id;
    public $name;
    public $description;
    public $instructions;
    public $embedding_config;
    public $metadata;
    public $created_by_id;
    public $last_updated_by_id;
    public $created_at;
    public $updated_at;

    // TODO: Add constructor, validation, and type safety improvements
} 