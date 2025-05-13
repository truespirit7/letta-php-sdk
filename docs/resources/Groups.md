# Groups Resource

Resource class for `/v1/groups` endpoints.

Provides methods to interact with Letta group resources, including listing, creating, counting, retrieving, modifying, and deleting groups.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all groups. | `$params` (optional array) | _Not implemented_ |
| `create(array $data)` | Create a new group. | `$data` (array, group creation payload) | `object` (Group object) |
| `count(array $params = [])` | Count groups. | `$params` (optional array) | _Not implemented_ |
| `retrieve(string $groupId)` | Retrieve group by ID. | `$groupId` (string) | `object` (Group object) |
| `modify(string $groupId, array $data)` | Modify group by ID. | `$groupId` (string), `$data` (array) | _Not implemented_ |
| `delete(string $groupId)` | Delete group by ID. | `$groupId` (string) | `bool` (True on success) |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Groups;

$http = new HttpClient($apiKey);
$groups = new Groups($http);

// Create a group
$newGroup = $groups->create([
    // ... group creation payload ...
]);
print_r($newGroup);

// Retrieve a group
$group = $groups->retrieve('group_id_here');
print_r($group);

// Delete a group
$success = $groups->delete('group_id_here');
var_dump($success);
``` 