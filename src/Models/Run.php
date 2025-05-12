<?php

namespace Letta\Models;

/**
 * Data model for a Run object.
 *
 * @property string $id
 * @property string $status
 * @property string|null $created_by_id
 * @property string|null $last_updated_by_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $completed_at
 * @property array|null $metadata
 * @property string|null $job_type
 * @property string|null $callback_url
 */
class Run
{
    public $id;
    public $status;
    public $created_by_id;
    public $last_updated_by_id;
    public $created_at;
    public $updated_at;
    public $completed_at;
    public $metadata;
    public $job_type;
    public $callback_url;

    // TODO: Add constructor, validation, and type safety improvements
} 