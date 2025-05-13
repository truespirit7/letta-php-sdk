# Jobs Resource

Resource class for `/v1/jobs` endpoints.

Provides methods to interact with Letta job resources, including listing, creating, retrieving, deleting, and modifying jobs.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all jobs. | `$params` (optional array) | _Not implemented_ |
| `create(array $data)` | Create a new job. | `$data` (array, job creation payload) | _Not implemented_ |
| `retrieve(string $jobId)` | Retrieve job by ID. | `$jobId` (string) | _Not implemented_ |
| `delete(string $jobId)` | Delete job by ID. | `$jobId` (string) | _Not implemented_ |
| `modify(string $jobId, array $data)` | Modify job by ID. | `$jobId` (string), `$data` (array) | _Not implemented_ |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Jobs;

$http = new HttpClient($apiKey);
jobs = new Jobs($http);

// Example: List jobs (not implemented)
// $allJobs = $jobs->list();
// print_r($allJobs);
``` 