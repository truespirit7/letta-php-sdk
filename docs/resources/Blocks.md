# Blocks Resource

Resource class for `/v1/blocks` endpoints.

Provides methods to interact with Letta block resources, including listing, creating, retrieving, deleting, and modifying blocks.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all blocks. | `$params` (optional array) | _Not implemented_ |
| `create(array $data)` | Create a new block. | `$data` (array, block creation payload) | `object` (Block object) |
| `retrieve(string $blockId)` | Retrieve block by ID. | `$blockId` (string) | `object` (Block object) |
| `delete(string $blockId)` | Delete block by ID. | `$blockId` (string) | `bool` (True on success) |
| `modify(string $blockId, array $data)` | Modify block by ID. | `$blockId` (string), `$data` (array) | _Not implemented_ |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Blocks;

$http = new HttpClient($apiKey);
$blocks = new Blocks($http);

// Create a block
$newBlock = $blocks->create([
    // ... block creation payload ...
]);
print_r($newBlock);

// Retrieve a block
$block = $blocks->retrieve('block_id_here');
print_r($block);

// Delete a block
$success = $blocks->delete('block_id_here');
var_dump($success);
``` 