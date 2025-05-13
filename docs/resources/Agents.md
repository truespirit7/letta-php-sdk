# Agents Resource

Resource class for `/v1/agents` endpoints.

Provides methods to interact with Letta agent resources, including listing, creating, retrieving, updating, deleting, running, and advanced agent operations.

## Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `list(array $params = [])` | List all agents. | `$params` (optional array) | `array` (List of agent objects) |
| `create(array $data)` | Create a new agent. | `$data` (array, agent creation payload) | `array` (Agent object) |
| `retrieve(string $agentId)` | Retrieve agent by ID. | `$agentId` (string) | `array` (Agent object) |
| `update(string $agentId, array $data)` | Update agent by ID. | `$agentId` (string), `$data` (array) | `array` (Agent object) |
| `delete(string $agentId)` | Delete agent by ID. | `$agentId` (string) | `bool` (True on success) |
| `run(string $agentId, array $data = [])` | Run an agent. | `$agentId` (string), `$data` (optional array) | `array` (Run result) |
| `upsertBase(array $data)` | Upsert base agent (advanced). | `$data` (array) | `array` (Agent object) |
| `runFromSource(array $data)` | Run agent from source (advanced). | `$data` (array) | `array` (Run result) |

## Example Usage

```php
use Letta\Http\HttpClient;
use Letta\Resources\Agents;

$http = new HttpClient($apiKey);
agents = new Agents($http);

// List agents
$allAgents = $agents->list();
print_r($allAgents);

// Create an agent
$newAgent = $agents->create([
    // ... agent creation payload ...
]);
print_r($newAgent);

// Retrieve an agent
$agent = $agents->retrieve('agent_id_here');
print_r($agent);

// Delete an agent
$success = $agents->delete('agent_id_here');
var_dump($success);
``` 