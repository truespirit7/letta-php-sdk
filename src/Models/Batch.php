<?php

namespace Letta\Models;

/**
 * Data model for a Batch object.
 *
 * @property string $id
 * @property string $status
 * @property string|null $created_at
 * @property string|null $completed_at
 * @property int|null $total_items
 * @property int|null $completed_items
 * @property int|null $error_count
 * @property array|null $errors
 * @property array|null $results
 * @property string|null $job_type
 * @property array|null $metadata
 * @property string|null $callback_url
 */
class Batch
{
    public $id;
    public $status;
    public $created_at;
    public $completed_at;
    public $total_items;
    public $completed_items;
    public $error_count;
    public $errors;
    public $results;
    public $job_type;
    public $metadata;
    public $callback_url;

    // TODO: Add constructor, validation, and type safety improvements
} 