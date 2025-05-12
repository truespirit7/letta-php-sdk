<?php

namespace Letta\Models;

/**
 * Data model for a Block object.
 *
 * @property string $id
 * @property string $value
 * @property int $limit
 * @property string|null $name
 * @property bool $is_template
 * @property string|null $label
 * @property string|null $description
 * @property array|null $metadata
 * @property string|null $created_by_id
 * @property string|null $last_updated_by_id
 */
class Block
{
    public $id;
    public $value;
    public $limit;
    public $name;
    public $is_template;
    public $label;
    public $description;
    public $metadata;
    public $created_by_id;
    public $last_updated_by_id;

    // TODO: Add constructor, validation, and type safety improvements
} 