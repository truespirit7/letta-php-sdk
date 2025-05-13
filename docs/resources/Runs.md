# Runs Resource

Resource class for `/v1/runs` endpoints.

Provides methods to interact with Letta run resources, including listing, creating, retrieving, deleting, and modifying runs.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all runs. | `$params` (optional array) | _Not implemented_ |
| `create(array $data)` | Create a new run. | `$data` (array, run creation payload) | _Not implemented_ |
| `retrieve(string $runId)` | Retrieve run by ID. | `$runId` (string) | _Not implemented_ |
| `delete(string $runId)` | Delete run by ID. | `$runId` (string) | _Not implemented_ |
| `modify(string $runId, array $data)` | Modify run by ID. | `$runId` (string), `$data` (array) | _Not implemented_ |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Runs;

$http = new HttpClient($apiKey);
$runs = new Runs($http);

// Example: List runs (not implemented)
// $allRuns = $runs->list();
// print_r($allRuns);
``` 