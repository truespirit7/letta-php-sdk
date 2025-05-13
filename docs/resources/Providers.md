# Providers Resource

Resource class for `/v1/providers` endpoints.

Provides methods to interact with Letta provider resources, including listing, creating, deleting, modifying, and checking providers.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all providers. | `$params` (optional array) | `array` (List of provider objects) |
| `create(array $data)` | Create a new provider. | `$data` (array, provider creation payload) | _Not implemented_ |
| `delete(string $providerId)` | Delete provider by ID. | `$providerId` (string) | _Not implemented_ |
| `modify(string $providerId, array $data)` | Modify provider by ID. | `$providerId` (string), `$data` (array) | _Not implemented_ |
| `check(string $providerId)` | Check provider by ID. | `$providerId` (string) | _Not implemented_ |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Providers;

$http = new HttpClient($apiKey);
$providers = new Providers($http);

// List providers
$allProviders = $providers->list();
print_r($allProviders);
``` 