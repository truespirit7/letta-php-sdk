<?php

namespace Letta\Models;

/**
 * Data model for a Tool object.
 *
 * @property string $id
 * @property string $tool_type
 * @property string $description
 * @property string $source_type
 * @property string $name
 * @property array $tags
 * @property string $source_code
 * @property array $json_schema
 * @property array $args_json_schema
 * @property int $return_char_limit
 * @property string $created_by_id
 * @property string $last_updated_by_id
 * @property array $metadata_
 */
class Tool
{
    public $id;
    public $tool_type;
    public $description;
    public $source_type;
    public $name;
    public $tags;
    public $source_code;
    public $json_schema;
    public $args_json_schema;
    public $return_char_limit;
    public $created_by_id;
    public $last_updated_by_id;
    public $metadata_;

    // TODO: Add constructor, validation, and type safety improvements
} 