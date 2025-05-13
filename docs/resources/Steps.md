# Steps Resource

Resource class for `/v1/steps` endpoints.

Provides methods to interact with Letta step resources, including listing steps and retrieving a step by ID.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all steps. | `$params` (optional array) | `array` (List of step objects) |
| `retrieve(string $stepId)` | Retrieve step by ID. | `$stepId` (string) | `array` (Step object) |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Steps;

$http = new HttpClient($apiKey);
$steps = new Steps($http);

// List steps
$allSteps = $steps->list();
print_r($allSteps);

// Retrieve a step by ID
$step = $steps->retrieve('step_id_here');
print_r($step);
``` 