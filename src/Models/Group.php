<?php

namespace Letta\Models;

/**
 * Data model for a Group object.
 *
 * @property string $id
 * @property string $manager_type
 * @property array $agent_ids
 * @property string $description
 * @property array $shared_block_ids
 * @property string|null $manager_agent_id
 * @property string|null $termination_token
 * @property int|null $max_turns
 * @property int|null $sleeptime_agent_frequency
 * @property int|null $turns_counter
 * @property string|null $last_processed_message_id
 * @property int|null $max_message_buffer_length
 * @property int|null $min_message_buffer_length
 */
class Group
{
    public $id;
    public $manager_type;
    public $agent_ids;
    public $description;
    public $shared_block_ids;
    public $manager_agent_id;
    public $termination_token;
    public $max_turns;
    public $sleeptime_agent_frequency;
    public $turns_counter;
    public $last_processed_message_id;
    public $max_message_buffer_length;
    public $min_message_buffer_length;

    // TODO: Add constructor, validation, and type safety improvements
} 