# Project Plan: Letta PHP SDK

## 1. Project Goals and Scope
- **Goal:** Develop a robust, well-documented PHP SDK for the Letta AI Agentic Framework, enabling PHP developers to easily interact with all Letta API endpoints.
- **Scope:**
  - Full coverage of all documented Letta API endpoints (Agents, Tools, Sources, Groups, Identities, Models, Blocks, Tags, Batches, Voice, Templates, Providers, Runs, Steps, Health).
  - Support for authentication (Bearer token).
  - Usable in modern PHP projects (Composer package, PSR standards).
  - Comprehensive error handling and response parsing.
  - Unit and integration tests.
  - Example usage and documentation.

## 2. High-Level Architecture
- **HTTP Client Layer:** Handles requests, authentication, retries, and error handling.
- **API Resource Classes:** One class per major API resource (e.g., Agent, Tool, Source, etc.), encapsulating endpoint logic.
- **Models/Data Objects:** PHP classes representing API objects (Agent, Tool, Source, etc.) for type safety and IDE support.
- **Response/Exception Handling:** Unified error and response management.
- **Configuration:** Centralized config for API base URL, token, etc.

## 3. Key Modules/Classes
- **Letta\Client**: Main entry point, manages configuration and exposes resource classes.
- **Letta\Http\HttpClient**: Handles HTTP requests, authentication, and low-level networking.
- **Letta\Resources\Agents**: Methods for all /v1/agents endpoints.
- **Letta\Resources\Tools**: Methods for all /v1/tools endpoints.
- **Letta\Resources\Sources**: Methods for all /v1/sources endpoints.
- **Letta\Resources\Groups**: Methods for all /v1/groups endpoints.
- **Letta\Resources\Identities**: Methods for all /v1/identities endpoints.
- **Letta\Resources\Models**: Methods for /v1/models endpoints.
- **Letta\Resources\Blocks**: Methods for /v1/blocks endpoints.
- **Letta\Resources\Tags**: Methods for /v1/tags endpoints.
- **Letta\Resources\Batches**: Methods for /v1/batches endpoints.
- **Letta\Resources\Voice**: Methods for /v1/voice endpoints.
- **Letta\Resources\Templates**: Methods for /v1/templates endpoints.
- **Letta\Resources\Providers**: Methods for /v1/providers endpoints.
- **Letta\Resources\Runs**: Methods for /v1/runs endpoints.
- **Letta\Resources\Steps**: Methods for /v1/steps endpoints.
- **Letta\Resources\Health**: Method for /v1/health endpoint.
- **Letta\Models\***: Data classes for Agent, Tool, Source, etc.
- **Letta\Exception\LettaException**: Base exception class for SDK errors.

## 4. Milestones and Deliverables
1. **Project Setup**
   - Composer package skeleton
   - PSR-4 autoloading
   - Initial README
2. **HTTP Client & Auth**
   - Implement HttpClient
   - Support for Bearer token
   - Error/response handling
3. **Core Resources**
   - Agents, Tools, Sources, Groups, Identities
   - Models for each resource
   - Unit tests for each
4. **Extended Resources**
   - Models, Blocks, Tags, Batches, Voice, Templates, Providers, Runs, Steps, Health
   - Models and tests
5. **Documentation & Examples**
   - Usage examples for each resource
   - API docs (PHPDoc)
   - README update
6. **Release**
   - Version 1.0.0 tag
   - Publish to Packagist

## 5. Testing and Documentation Strategy
- **Testing:**
  - PHPUnit for unit and integration tests
  - Mock HTTP responses for endpoint coverage
  - **Live integration tests against the production Letta server**
    - Use the self-hosted Letta server at `https://devletta.zero1.network:8283` for real API integration tests
    - Authentication password: `abc123` (ensure this is managed securely and not hardcoded in the repo, including adding this to a .gitignore)
    - Integration tests should be able to run locally and in CI (with credentials provided via environment variables or CI secrets)
    - **A dedicated test agent ID is available:** `agent-7ee90766-1b9b-443b-909c-ef88b54dda6c`
    - **Important:** Any temporary objects (agents, identities, blocks, etc.) created via the API during tests must be tracked so they can be cleaned up at the end of testing to avoid polluting the production environment.
    - CI integration (GitHub Actions or similar)
- **Documentation:**
  - PHPDoc for all public methods/classes
  - Markdown docs for usage and advanced topics
  - Example scripts for common use cases

## 6. Open Questions / Risks
- Are there any undocumented or unstable endpoints?
- How will breaking API changes be handled?
- Are there rate limits or special error codes to consider?
- Is async/streaming support required for all endpoints?
- What is the minimum PHP version to support?
- Will there be a need for middleware/hooks (e.g., for logging or custom retry logic)?

---

## Detailed Phased Checklist

### Phase 1: Planning & Setup
- [x] Review and finalize project plan with all stakeholders
- [x] Confirm API documentation is up to date and covers all endpoints
- [x] Define minimum supported PHP version
- [x] Set up version control and repository structure
- [x] Initialize Composer package and PSR-4 autoloading
- [x] Add `.gitignore` and ensure sensitive data (API keys, passwords) are excluded
- [x] Create initial README with project overview
- [x] **Negative Prompt:** Do NOT start coding SDK logic before the plan and architecture are approved

### Phase 2: Core Infrastructure
- [x] Implement `Letta\Client` entry point
- [x] Implement `Letta\Http\HttpClient` with Bearer token support
- [x] Implement unified error/response handling
- [x] Add configuration management (base URL, token, etc.)
- [x] Set up base exception classes
- [x] **Negative Prompt:** Do NOT hardcode credentials or server URLs in code

### Phase 3: Core API Resources
- [x] Implement `Letta\Resources\Agents` (all endpoints)
- [x] Implement `Letta\Resources\Tools`
- [x] Implement `Letta\Resources\Sources`
- [x] Implement `Letta\Resources\Groups`
- [x] Implement `Letta\Resources\Identities`
- [x] Implement models/data objects for each resource
- [x] Write unit tests for each resource
- [x] **Negative Prompt:** Do NOT skip endpoints or leave undocumented methods

### Phase 4: Extended API Resources
- [x] Implement `Letta\Resources\Models`
- [x] Implement `Letta\Resources\Blocks`
- [x] Implement `Letta\Resources\Tags`
- [x] Implement `Letta\Resources\Batches`
- [x] Implement `Letta\Resources\Voice`
- [x] Implement `Letta\Resources\Templates`
- [x] Implement `Letta\Resources\Providers`
- [x] Implement `Letta\Resources\Runs`
- [x] Implement `Letta\Resources\Steps`
- [x] Implement `Letta\Resources\Health`
- [x] Implement models/data objects for each extended resource
- [x] Write unit tests for each extended resource
- [x] **Negative Prompt:** Do NOT duplicate code between resources—use shared utilities where possible

### Phase 5: Integration Testing
- [x] Set up integration test suite using PHPUnit
- [x] Configure tests to use the production Letta server (`https://devletta.zero1.network:8283`)
- [x] Use the dedicated test agent ID: `agent-7ee90766-1b9b-443b-909c-ef88b54dda6c`
- [x] Track all temporary objects created during tests for cleanup
- [x] Implement teardown/cleanup logic for all test-created objects
- [x] Ensure tests can run both locally and in CI
- [x] **Negative Prompt:** Do NOT leave test data or objects in the production environment
- [ ] **Audit SDK request structure for consistency:**
    - [x] All implemented resource methods for create/upsert/modify are structurally consistent (only Tools is implemented so far).
    - [x] Future implementations should follow the Tools resource pattern for sending payloads as JSON in the 'body' key.
- [ ] **TODO:** Once async message functions are implemented in the SDK, revisit Runs integration tests to cover the full run lifecycle (create a run via async agent message, then retrieve and delete it).

### Phase 5.5: Extended/Missing Endpoints (from Part 2 Docs)
- Audit and implement/test the following endpoints as per Letta-API-Endpoints-Documentation Part 2.md:

**Tools**
- [x] GET `/tools/{tool_id}` (fetch tool by ID)
- [x] DELETE `/tools/{tool_id}` (delete tool by ID)
- [x] PATCH `/tools/{tool_id}` (update tool)
- [x] GET `/tools/count` (count tools)

**Sources (Files & Passages)**
- [x] GET `/sources/{source_id}/files` (list files for a source)
- [x] POST `/sources/{source_id}/upload` (upload file to source)
- [x] DELETE `/sources/{source_id}/files/{file_id}` (delete file from source)
- [x] GET `/sources/{source_id}/passages` (list passages for a source)

**Jobs**
- [x] GET `/jobs` (list jobs) *(401 Unauthorized: not testable in current backend setup)*
- [x] GET `/jobs/active` (list active jobs)
- [x] GET `/jobs/{job_id}` (get job by ID) *(401 Unauthorized: not testable in current backend setup)*
- [x] DELETE `/jobs/{job_id}` (delete/cancel job) *(401 Unauthorized: not testable in current backend setup)*

**Usage**
- [x] GET `/runs/{run_id}/usage` (get token usage for a run)

**Templates (Cloud-only)**
- [x] POST `/agents/{agent_id}/template` (create template from agent) *(404 Not Found: cloud-only endpoint, not available on this backend)*
- [x] POST `/agents/{agent_id}/version-template` (version agent template) *(404 Not Found: cloud-only endpoint, not available on this backend)*

**Memory Variables (Cloud-only)**
- [x] GET `/agents/{agent_id}/core-memory/variables` (get agent memory variables) *(404 Not Found: cloud-only endpoint, not available on this backend)*

**Global Messages (Batch)**
- [x] GET `/batch-runs/{batch_id}/messages` (get messages from batch run) *(404 Not Found: endpoint not available on this backend)*

- For each endpoint: Audit SDK for implementation, add if missing, and write/skip integration tests as appropriate for self-hosted/Cloud.

### Phase 6: Documentation & Examples
- [ ] Write PHPDoc for all public classes and methods
- [ ] Create markdown documentation for setup, usage, and advanced topics
- [ ] Provide example scripts for common use cases
- [ ] Update README with usage and contribution guidelines
- [ ] **Negative Prompt:** Do NOT release without complete and accurate documentation

### Phase 7: CI/CD & Release
- [ ] Set up CI (e.g., GitHub Actions) for linting, tests, and integration checks
- [ ] Ensure `.gitignore` and secrets management are enforced in CI
- [ ] Tag and release version 1.0.0
- [ ] Publish package to Packagist
- [ ] Announce release and update documentation
- [ ] **Negative Prompt:** Do NOT publish to Packagist or announce until all tests pass and documentation is complete

---

**Always:**
- [ ] Regularly review for code duplication, missing tests, or undocumented features
- [ ] Keep security and privacy in mind (never expose credentials)
- [ ] Communicate blockers or uncertainties early
- [ ] **Negative Prompt:** Do NOT cut corners on testing, documentation, or security for the sake of speed

---

*This plan is based on the Letta API documentation in docs/Letta-API-Endpoints-Documentation.md. Adjustments may be made as implementation progresses or as new requirements emerge.* 