# Agent Integration Test: Exact API Calls and Parameters

This document details **exactly** what was tested by `tests/integration/AgentIntegrationTest.php` during the most recent test run. It includes the API endpoints called, the parameters/payloads used, and the side effects of each test.

---

## Environment Variables Used
- `LETTA_API_URL`: API base URL
- `LETTA_API_TOKEN`: Bearer token for authentication
- `LETTA_TEST_AGENT_ID`: Agent ID used for non-destructive tests (tool/source/memory management)

---

## Test: `testListAgents`
- **Endpoint:** `GET /v1/agents/`
- **Parameters:** None
- **Side Effects:** None
- **Cleanup:** None

---

## Test: `testCreateRetrieveModifyDeleteAgent`
- **Endpoints & Payloads:**
    1. `POST /v1/agents/`
        - Payload:
          ```json
          {
            "name": "integration_test_agent_<unique>",
            "description": "Integration test agent",
            "llm_config": {
              "name": "letta-free",
              "provider": "letta",
              "model": "letta-free",
              "model_endpoint_type": "openai",
              "context_window": 4096
            },
            "embedding_config": {
              "embedding_endpoint_type": "openai",
              "embedding_model": "text-embedding-ada-002",
              "embedding_dim": 1536
            }
          }
          ```
    2. `GET /v1/agents/{agent_id}`
        - Path param: `agent_id` from previous response
    3. `PATCH /v1/agents/{agent_id}`
        - Payload:
          ```json
          { "description": "Updated description" }
          ```
    4. `DELETE /v1/agents/{agent_id}`
        - Path param: `agent_id` from previous response
- **Side Effects:** Creates and deletes an agent
- **Cleanup:** Deletes the created agent (even if test fails)

---

## Test: `testCountAgents`
- **Endpoint:** `GET /v1/agents/count`
- **Parameters:** None
- **Side Effects:** None
- **Cleanup:** None
- **Notes:** Skips test if endpoint returns 404

---

## Test: `testExportImportAgent`
- **Endpoints & Payloads:**
    1. `POST /v1/agents/` (same payload as in create test, but with name `export_import_agent_<unique>`)
    2. `GET /v1/agents/export?agent_id={agent_id}`
    3. `POST /v1/agents/import`
        - Payload: The full exported agent object from previous step
- **Side Effects:** Creates, exports, and imports agents
- **Cleanup:** Deletes both the original and imported agents
- **Notes:** Skips test if export/import endpoints return 404

---

## Test: `testGetContext`
- **Endpoint:** `GET /v1/agents/{agent_id}/context`
- **Parameters:**
    - `agent_id`: from `LETTA_TEST_AGENT_ID` environment variable
- **Side Effects:** None
- **Cleanup:** None

---

## Test: `testToolManagement`
- **Endpoints & Flow:**
    1. `GET /v1/agents/{agent_id}/tools` (agent_id from env)
    2. If any tools exist:
        - `PATCH /v1/agents/{agent_id}/tools/attach/{tool_id}`
        - `PATCH /v1/agents/{agent_id}/tools/detach/{tool_id}`
- **Parameters:**
    - `agent_id`: from `LETTA_TEST_AGENT_ID`
    - `tool_id`: from first tool in list
- **Side Effects:** May attach/detach tools to the test agent
- **Cleanup:** None (tools are detached after attach)

---

## Test: `testSourceManagement`
- **Endpoints & Flow:**
    1. `GET /v1/agents/{agent_id}/sources` (agent_id from env)
    2. If any sources exist:
        - `PATCH /v1/agents/{agent_id}/sources/attach/{source_id}`
        - `PATCH /v1/agents/{agent_id}/sources/detach/{source_id}`
- **Parameters:**
    - `agent_id`: from `LETTA_TEST_AGENT_ID`
    - `source_id`: from first source in list
- **Side Effects:** May attach/detach sources to the test agent
- **Cleanup:** None (sources are detached after attach)

---

## Test: `testCoreMemoryBlockManagement`
- **Endpoints & Flow:**
    1. `GET /v1/agents/{agent_id}/core-memory/blocks/{block_label}`
    2. `PATCH /v1/agents/{agent_id}/core-memory/blocks/{block_label}`
        - Payload: `{ "data": "test" }`
    3. `PATCH /v1/agents/{agent_id}/core-memory/blocks/attach/{block_id}`
    4. `PATCH /v1/agents/{agent_id}/core-memory/blocks/detach/{block_id}`
- **Parameters:**
    - `agent_id`: from `LETTA_TEST_AGENT_ID`
    - `block_label`: `'test_block'`
    - `block_id`: `'test_block_id'`
- **Side Effects:** May modify, attach, or detach core memory blocks for the test agent
- **Cleanup:** None (blocks are detached after attach)

---

# Summary Table

| Test Name                        | Endpoints Called                                                                 | Side Effects                |
|-----------------------------------|---------------------------------------------------------------------------------|-----------------------------|
| testListAgents                    | GET /v1/agents/                                                                 | None                        |
| testCreateRetrieveModifyDelete... | POST, GET, PATCH, DELETE /v1/agents/{id}                                        | Creates & deletes agents    |
| testCountAgents                   | GET /v1/agents/count                                                            | None                        |
| testExportImportAgent             | POST /v1/agents/, GET /v1/agents/export, POST /v1/agents/import                 | Creates, imports agents     |
| testGetContext                    | GET /v1/agents/{id}/context                                                     | None                        |
| testToolManagement                | GET, PATCH (attach/detach) /v1/agents/{id}/tools                                | Modifies agent tools        |
| testSourceManagement              | GET, PATCH (attach/detach) /v1/agents/{id}/sources                              | Modifies agent sources      |
| testCoreMemoryBlockManagement     | GET, PATCH (modify/attach/detach) /v1/agents/{id}/core-memory/blocks/{label/id} | Modifies agent memory       |

---

**This document is a post-mortem of the exact integration test activity for the Letta Agents resource.** 