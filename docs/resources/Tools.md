# Tools Resource

Resource class for `/v1/tools` endpoints.

Provides methods to interact with Letta tool resources, including listing, creating, retrieving, updating, deleting, and advanced tool operations.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all tools. | `$params` (optional array) | `array` (List of tool objects) |
| `create(array $data)` | Create a new tool. | `$data` (array, tool creation payload) | `array` (Tool object) |
| `retrieve(string $toolId)` | Retrieve tool by ID. | `$toolId` (string) | `array` (Tool object) |
| `update(string $toolId, array $data)` | Update tool by ID. | `$toolId` (string), `$data` (array) | `array` (Tool object) |
| `delete(string $toolId)` | Delete tool by ID. | `$toolId` (string) | `bool` (True on success) |
| `runFromSource(array $data)` | Run tool from source (advanced). | `$data` (array) | `array` (Run result) |
| `upsertBase(array $data)` | Upsert base tool (advanced). | `$data` (array) | `array` (Tool object) |
| `runMCP(array $data)` | Run MCP tool (experimental). | `$data` (array) | `array` (Run result) |
| `runComposio(array $data)` | Run Composio tool (experimental). | `$data` (array) | `array` (Run result) |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Tools;

$http = new HttpClient($apiKey);
$tools = new Tools($http);

// List tools
$allTools = $tools->list();
print_r($allTools);

// Create a tool
$newTool = $tools->create([
    // ... tool creation payload ...
]);
print_r($newTool);

// Retrieve a tool
$tool = $tools->retrieve('tool_id_here');
print_r($tool);

// Delete a tool
$success = $tools->delete('tool_id_here');
var_dump($success);
``` 