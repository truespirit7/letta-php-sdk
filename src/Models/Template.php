<?php

namespace Letta\Models;

/**
 * Data model for a Template object.
 *
 * @property string $id
 * @property string $templateId
 * @property string $templateName
 * @property string $description
 * @property string|null $base_template_id
 */
class Template
{
    public $id;
    public $templateId;
    public $templateName;
    public $description;
    public $base_template_id;

    // TODO: Add constructor, validation, and type safety improvements
} 