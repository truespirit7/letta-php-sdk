# Tags Resource

Resource class for `/v1/tags` endpoint.

Provides a method to list all tags in the Letta system.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list()` | List all tags. | None | `array` (List of tags) |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Tags;

$http = new HttpClient($apiKey);
$tags = new Tags($http);
$allTags = $tags->list();
print_r($allTags);
``` 