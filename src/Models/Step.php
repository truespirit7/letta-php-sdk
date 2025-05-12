<?php

namespace Letta\Models;

/**
 * Data model for a Step object.
 *
 * @property string $id
 * @property string $run_id
 * @property string $agent_id
 * @property string $type
 * @property mixed $input
 * @property mixed $output
 * @property string $timestamp
 */
class Step
{
    public $id;
    public $run_id;
    public $agent_id;
    public $type;
    public $input;
    public $output;
    public $timestamp;

    // TODO: Add constructor, validation, and type safety improvements
} 