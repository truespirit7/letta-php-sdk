# Letta PHP SDK

A robust, well-documented PHP SDK for the Letta AI Agentic Framework. Easily interact with all Letta API endpoints from your PHP applications.

## Getting Started

### Installation

Install via Composer:

```bash
composer require letta/letta-php-sdk
```

### Configuration

1. Copy `.env.example` to `.env` and fill in your Letta API credentials:
   - `LETTA_API_URL` (e.g., `https://devletta.zero1.network:8283`)
   - `LETTA_API_TOKEN` (your API key)
   - (Optional) `LETTA_TEST_AGENT_ID` for example scripts

2. Load environment variables in your script (see examples below).

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

Run an example:

```bash
php docs/examples/health_check.php
```

## API Reference

- **Resource Reference:** See [`docs/dev/README_RESOURCES.md`](docs/dev/README_RESOURCES.md) for detailed documentation of each SDK resource class and their methods.
- **Full API Endpoints:**
  - [`docs/dev/Letta-API-Endpoints-Documentation.md`](docs/dev/Letta-API-Endpoints-Documentation.md)
  - [`docs/dev/Letta-API-Endpoints-Documentation Part 2.md`](docs/dev/Letta-API-Endpoints-Documentation%20Part%202.md)
- **Tool Compatibility Notes:** [`docs/dev/letta-tool-compatibility-notes.md`](docs/dev/letta-tool-compatibility-notes.md)
- **Project Plan:** [`docs/dev/PROJECT_PLAN.md`](docs/dev/PROJECT_PLAN.md)

## Contributing

Contributions are welcome! Please see the [project plan](docs/dev/PROJECT_PLAN.md) and ensure all new code is fully tested and documented.

## License

MIT
