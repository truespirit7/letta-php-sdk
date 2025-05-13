# Voice Resource

Resource class for `/v1/voice` endpoints.

Provides methods to interact with Letta voice resources, including creating voice chat completions.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `createVoiceChatCompletion(array $data)` | Create voice chat completion. | `$data` (array, voice chat completion payload) | `array` (API response) |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Voice;

$http = new HttpClient($apiKey);
$voice = new Voice($http);

$response = $voice->createVoiceChatCompletion([
    // ... voice chat completion payload ...
]);
print_r($response);
``` 