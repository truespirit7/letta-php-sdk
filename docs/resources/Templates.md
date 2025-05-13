# Templates Resource

Resource class for `/v1/templates` endpoints.

Provides methods to interact with Letta template resources, including listing templates and creating/versioning templates from agents (cloud-only).

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all templates. | `$params` (optional array) | `array` (List of template objects) |
| `createFromAgent(string $agentId, array $data = [])` | Create template from agent (Cloud-only). | `$agentId` (string), `$data` (optional array) | `array` (API response) |
| `versionFromAgent(string $agentId, array $data = [])` | Version agent template (Cloud-only). | `$agentId` (string), `$data` (optional array) | `array` (API response) |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Templates;

$http = new HttpClient($apiKey);
$templates = new Templates($http);

// List templates
$allTemplates = $templates->list();
print_r($allTemplates);

// Create template from agent
$response = $templates->createFromAgent('agent_id_here', [
    // ... template creation payload ...
]);
print_r($response);

// Version agent template
$versioned = $templates->versionFromAgent('agent_id_here', [
    // ... versioning payload ...
]);
print_r($versioned);
``` 