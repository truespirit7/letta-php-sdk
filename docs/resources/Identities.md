# Identities Resource

Resource class for `/v1/identities` endpoints.

Provides methods to interact with Letta identity resources, including listing, creating, upserting, counting, retrieving, deleting, and modifying identities.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all identities. | `$params` (optional array) | _Not implemented_ |
| `create(array $data)` | Create a new identity. | `$data` (array, identity creation payload) | `object` (Identity object) |
| `upsert(array $data)` | Upsert an identity. | `$data` (array, identity upsert payload) | _Not implemented_ |
| `count(array $params = [])` | Count identities. | `$params` (optional array) | _Not implemented_ |
| `retrieve(string $identityId)` | Retrieve identity by ID. | `$identityId` (string) | `object` (Identity object) |
| `delete(string $identityId)` | Delete identity by ID. | `$identityId` (string) | `bool` (True on success) |
| `modify(string $identityId, array $data)` | Modify identity by ID. | `$identityId` (string), `$data` (array) | _Not implemented_ |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Identities;

$http = new HttpClient($apiKey);
$identities = new Identities($http);

// Create an identity
$newIdentity = $identities->create([
    // ... identity creation payload ...
]);
print_r($newIdentity);

// Retrieve an identity
$identity = $identities->retrieve('identity_id_here');
print_r($identity);

// Delete an identity
$success = $identities->delete('identity_id_here');
var_dump($success);
``` 