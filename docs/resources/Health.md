# Health Resource

Resource class for `/v1/health` endpoint.

Provides a method to check the health status of the Letta API.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `check()` | Check API health. | None | `array` (Health status response) |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Health;

$http = new HttpClient($apiKey);
$health = new Health($http);
$status = $health->check();
print_r($status);
``` 