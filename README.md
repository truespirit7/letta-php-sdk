# Letta PHP SDK

A robust, well-documented PHP SDK for the Letta AI Agentic Framework. Easily interact with all Letta API endpoints from your PHP applications.

## Getting Started

### Installation (Local/Development)

This SDK is not yet published to Packagist. To use it in your project:

1. **Clone this repository** (or download and extract it) into a directory, e.g., `vendor/letta/letta-php-sdk`.
2. In your project's `composer.json`, add a [path repository](https://getcomposer.org/doc/05-repositories.md#path):

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "vendor/letta/letta-php-sdk"
    }
  ],
  "require": {
    "letta/letta-php-sdk": "*"
  }
}
```

3. Run:

```bash
composer update letta/letta-php-sdk
```

4. Copy `.env.example` to `.env` and fill in your Letta API credentials:
   - `LETTA_API_URL` (e.g., `https://devletta.zero1.network:8283`)
   - `LETTA_API_TOKEN` (your API key)
   - (Optional) `LETTA_TEST_AGENT_ID` for example scripts

5. Load environment variables in your script (see examples below).

## Usage Examples

See the [`docs/examples/`](docs/examples/) directory for ready-to-run scripts. Each script loads credentials from your `.env` file and demonstrates a specific SDK feature.

- **Health Check:** [`health_check.php`](docs/examples/health_check.php) — Check API health status
- **List Tags:** [`list_tags.php`](docs/examples/list_tags.php) — List all tags in the system
- **Retrieve Agent:** [`retrieve_agent.php`](docs/examples/retrieve_agent.php) — Retrieve an agent by ID
- **Create & Retrieve Source:** [`create_and_retrieve_source.php`](docs/examples/create_and_retrieve_source.php) — Create a source and fetch it
- **Create, Retrieve & Delete Block:** [`create_retrieve_delete_block.php`](docs/examples/create_retrieve_delete_block.php) — Full block lifecycle
- **Create, Retrieve, Update & Delete Tool:** [`create_retrieve_update_delete_tool.php`](docs/examples/create_retrieve_update_delete_tool.php) — Full tool lifecycle
- **List, Retrieve & Delete Job:** [`list_retrieve_delete_job.php`](docs/examples/list_retrieve_delete_job.php) — List jobs, fetch and delete one
- **List, Retrieve & Delete Run:** [`list_retrieve_delete_run.php`](docs/examples/list_retrieve_delete_run.php) — List runs, fetch and delete one
- **Upload File to Source:** [`upload_file_to_source.php`](docs/examples/upload_file_to_source.php) — Create a source, upload a file, poll job status, and delete the file
- **Send Message to Agent:** [`send_message_to_agent.php`](docs/examples/send_message_to_agent.php) — Send a message to an agent and print the response and conversation history

Run an example:

```bash
php docs/examples/health_check.php
```

## Contributing

Contributions are welcome! Please see the project plan and ensure all new code is fully tested and documented.

## License

CC-BY-SA
