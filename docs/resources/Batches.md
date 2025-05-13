# Batches Resource

Resource class for `/v1/batches` endpoints.

Provides methods to interact with Letta batch resources, including listing, creating, retrieving, deleting, and modifying batches.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all batches. | `$params` (optional array) | _Not implemented_ |
| `create(array $data)` | Create a new batch. | `$data` (array, batch creation payload) | _Not implemented_ |
| `retrieve(string $batchId)` | Retrieve batch by ID. | `$batchId` (string) | _Not implemented_ |
| `delete(string $batchId)` | Delete batch by ID. | `$batchId` (string) | _Not implemented_ |
| `modify(string $batchId, array $data)` | Modify batch by ID. | `$batchId` (string), `$data` (array) | _Not implemented_ |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Batches;

$http = new HttpClient($apiKey);
$batches = new Batches($http);

// Example: List batches (not implemented)
// $allBatches = $batches->list();
// print_r($allBatches);
``` 