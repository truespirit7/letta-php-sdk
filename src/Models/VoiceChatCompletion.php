<?php

namespace Letta\Models;

/**
 * Data model for a VoiceChatCompletion object.
 *
 * @property string $id
 * @property string $transcript
 * @property string $response_text
 * @property string $response_audio
 * @property string $message_id
 */
class VoiceChatCompletion
{
    public $id;
    public $transcript;
    public $response_text;
    public $response_audio;
    public $message_id;

    // TODO: Add constructor, validation, and type safety improvements
} 