# Sources Resource

Resource class for `/v1/sources` endpoints.

Provides methods to interact with Letta source resources, including listing, creating, retrieving, updating, deleting, uploading files, listing files, and advanced operations.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all sources. | `$params` (optional array) | `array` (List of source objects) |
| `create(array $data)` | Create a new source. | `$data` (array, source creation payload) | `array` (Source object) |
| `retrieve(string $sourceId)` | Retrieve source by ID. | `$sourceId` (string) | `array` (Source object) |
| `update(string $sourceId, array $data)` | Update source by ID. | `$sourceId` (string), `$data` (array) | `array` (Source object) |
| `delete(string $sourceId)` | Delete source by ID. | `$sourceId` (string) | `bool` (True on success) |
| `uploadFile(string $sourceId, string $filePath, array $options = [])` | Upload a file to a source. | `$sourceId` (string), `$filePath` (string), `$options` (optional array) | `array` (Job object) |
| `listFiles(string $sourceId)` | List files for a source. | `$sourceId` (string) | `array` (List of file objects) |
| `deleteFile(string $sourceId, string $fileId)` | Delete file from a source. | `$sourceId` (string), `$fileId` (string) | `bool` (True on success) |
| `listPassages(string $sourceId, array $params = [])` | List passages for a source. | `$sourceId` (string), `$params` (optional array) | `array` (List of passages) |
| `upsertBase(array $data)` | Upsert base source (advanced). | `$data` (array) | `array` (Source object) |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Sources;

$http = new HttpClient($apiKey);
$sources = new Sources($http);

// List sources
$allSources = $sources->list();
print_r($allSources);

// Create a source
$newSource = $sources->create([
    // ... source creation payload ...
]);
print_r($newSource);

// Upload a file to a source
$job = $sources->uploadFile('source_id_here', '/path/to/file.pdf');
print_r($job);

// List files for a source
$files = $sources->listFiles('source_id_here');
print_r($files);

// Delete a file from a source
$success = $sources->deleteFile('source_id_here', 'file_id_here');
var_dump($success);
``` 