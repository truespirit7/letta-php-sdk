Understood. I’ll now launch a focused second pass of deep research to fully document the previously missing or incomplete Letta API endpoints. These include specific endpoints under Tools, Source Files and Passages, Jobs, Usage, Templates, Memory Variables, and any global Messages endpoints.

I’ll return a structured, Markdown-formatted report with endpoint names, cURL examples, descriptions, and full response schemas, filling in the exact gaps you flagged. I’ll let you know when it’s ready for your review.


# Additional Letta API Endpoints Documentation

Below are the detailed API endpoints that were previously missing or incomplete. Each endpoint section includes the HTTP method and path, an example `curl` request, a description of its purpose, and a list of response fields with their meanings.

## Tools Endpoints

### GET `/tools/{tool_id}`

Retrieves a tool by its ID. Use this to fetch the configuration and metadata of a specific tool.

* **Example Request:**

  ```bash
  curl -X GET "https://api.letta.com/v1/tools/TOOL_ID" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** Get the details of a tool (custom function) by its unique ID. The response includes the tool’s code, schemas, and metadata.

* **Response Fields:** The response is a JSON object with the following fields:

  * **id** – The unique identifier of the tool (format: `tool-xxxxxxxx`).
  * **tool\_type** – The category/type of the tool (e.g. `"custom"` for user-created tools).
  * **description** – A text description of what the tool does.
  * **source\_type** – The type of source code (e.g. `"python"`) for the tool’s implementation.
  * **name** – The name of the tool/function.
  * **tags** – List of string tags associated with the tool (for organization or metadata).
  * **source\_code** – The source code of the tool’s function (usually Python code).
  * **json\_schema** – JSON schema object defining the tool’s input/output format (if any).
  * **args\_json\_schema** – JSON schema for the tool’s arguments (if any).
  * **return\_char\_limit** – Maximum number of characters the tool’s return value can have (integer, default 6000).
  * **created\_by\_id** – ID of the user who originally created the tool.
  * **last\_updated\_by\_id** – ID of the user who last updated the tool.
  * **metadata\_** – An object for any additional metadata key-values stored with the tool.

### DELETE `/tools/{tool_id}`

Deletes a tool by its ID.

* **Example Request:**

  ```bash
  curl -X DELETE "https://api.letta.com/v1/tools/TOOL_ID" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** Permanently removes the specified tool from Letta. A successful deletion returns a success status code (e.g. HTTP 204 No Content).

* **Response:** This call does not return a JSON body on success. If the tool is deleted successfully, you will receive an HTTP 200/204 response with no content.

### PATCH `/tools/{tool_id}`

Modifies (updates) an existing tool’s definition.

* **Example Request:**

  ```bash
  curl -X PATCH "https://api.letta.com/v1/tools/TOOL_ID" \
       -H "Authorization: Bearer <token>" \
       -H "Content-Type: application/json" \
       -d '{ "description": "New description", "source_code": "<updated code>" }'
  ```

* **Description:** Update one or more fields of a tool, such as its description, source code, or schemas. Only the fields provided in the JSON body will be changed.

* **Response Fields:** On success, returns the updated tool object (same structure as in **GET /tools/{tool\_id}**) with all tool fields described above. For convenience, the main fields are:

  * **id** – Tool’s unique ID (human-friendly).
  * **tool\_type** – Type/category of the tool.
  * **description** – Updated description of the tool.
  * **source\_type** – Language or type of source code.
  * **name** – Name of the tool/function.
  * **tags** – List of tags associated with the tool.
  * **source\_code** – The updated source code of the tool.
  * **json\_schema** – JSON schema of the function’s output (if provided or auto-generated).
  * **args\_json\_schema** – JSON schema of the function’s arguments (if any).
  * **return\_char\_limit** – Max characters allowed in tool’s return value.
  * **created\_by\_id** – User ID who created the tool.
  * **last\_updated\_by\_id** – User ID who last updated the tool.
  * **metadata\_** – Additional metadata object.

### GET `/tools/count`

Gets the total number of tools available in the user’s organization.

* **Example Request:**

  ```bash
  curl -X GET "https://api.letta.com/v1/tools/count" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** Returns a count of all tools that the current org/user can access. By default, this count **excludes** built-in system tools unless specified.

* **Response:** The response is a plain integer number representing the count of tools. For example, a successful response might simply be:

  ```json
  42
  ```

  This indicates there are 42 tools in total available. *(You can include built-in base tools in the count by using the query parameter `include_base_tools=true`.)*

## Sources Endpoints

### GET `/sources/{source_id}/files`

Lists all files that have been uploaded to a given data source.

* **Example Request:**

  ```bash
  curl -X GET "https://api.letta.com/v1/sources/SOURCE_ID/files" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** Retrieve a paginated list of files associated with the specified data source. Each file represents a document that was added to the source for embedding into the agent’s memory.

* **Response:** An array of file objects. Each file object has the following fields:

  * **source\_id** – The ID of the data source to which this file belongs.
  * **id** – The unique ID of the file (format: `file-xxxxxxxx`).
  * **file\_name** – Original name of the uploaded file.
  * **file\_path** – Path of the file (if applicable; e.g., in cloud storage or local path).
  * **file\_type** – Type/MIME of the file (e.g. `"text/plain"`, `"application/pdf"`).
  * **file\_size** – Size of the file in bytes.
  * **file\_creation\_date** – Original creation timestamp of the file (if available).
  * **file\_last\_modified\_date** – Last modified timestamp of the file (if available).
  * **created\_at** – Timestamp when the file was uploaded to Letta.
  * **updated\_at** – Timestamp of the last update to this file record.
  * **is\_deleted** – Boolean indicating if the file has been deleted (`false` means the file is active).

  Supports pagination via query params: `limit` (max number of files, default 1000) and `after` (a cursor token – typically the last file ID from a previous page).

### POST `/sources/{source_id}/files` (Upload File to Source)

Uploads a new file/document into the specified data source, splitting it into passages for embedding. **Note:** The API path for this operation is `/sources/{source_id}/upload` (as shown below), which creates an asynchronous job to process the file.

* **Example Request:**

  ```bash
  curl -X POST "https://api.letta.com/v1/sources/SOURCE_ID/upload" \
       -H "Authorization: Bearer <token>" \
       -F "file=@/path/to/your/document.pdf"
  ```

  (This uses a multipart form upload, with the file binary attached.)

* **Description:** Uploads a file to a data source. The file will be processed asynchronously – it will be split into chunks and embedded in the background. This operation initiates a **Job** that handles text extraction, chunking, and embedding of the file’s content.

* **Response:** Returns a Job object representing the file-processing task. Important fields in this Job response include:

  * **id** – The job’s ID (format: `job-xxxxxxxx`) which can be used to track status.
  * **status** – Current status of the job (`"not_started"`, `"running"`, `"completed"`, or `"failed"`).
  * **created\_at / updated\_at** – Timestamps for when the job was created and last updated.
  * **completed\_at** – Timestamp when the job completed (present if status is `"completed"`).
  * **metadata** – A metadata object with additional info (e.g., error details if failed, or processing stats).
  * **job\_type** – Type of job (should be `"job"` for a file upload job).
  * **callback\_url** – If a callback was specified for job completion, this is the URL that will be POSTed to.
  * *(The Job object includes all the standard fields documented under the Jobs endpoints; see the **Jobs** section for full field descriptions.)*

  After uploading, you can poll the job’s status via the Jobs API (GET `/jobs/{job_id}`) until it is `"completed"`. Once completed, the file’s content will have been broken into passages available via the passages endpoint, and the file will appear in the above GET files list.

### DELETE `/sources/{source_id}/files/{file_id}`

Deletes a file from the data source.

* **Example Request:**

  ```bash
  curl -X DELETE "https://api.letta.com/v1/sources/SOURCE_ID/files/FILE_ID" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** Remove a previously uploaded file from the source. This may also mark all passages from that file as deleted so they are no longer used by agents.

* **Response:** On success, returns an HTTP 200/204 status with no content (the file is deleted). The path parameters are the source ID and the file ID to identify which file to delete. (No JSON response body is expected for this endpoint.)

### GET `/sources/{source_id}/passages`

Retrieves all **passages** (embedded text chunks) associated with a data source.

* **Example Request:**

  ```bash
  curl -X GET "https://api.letta.com/v1/sources/SOURCE_ID/passages" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** List all passages in the given source. Passages are the pieces of text (with embeddings) that were extracted from files uploaded to the source. These passages can later be attached to an agent’s archival memory for context.

* **Response:** An array of passage objects. Each passage object contains the following fields:

  * **text** – The text content of this passage (a chunk of the file’s text).
  * **created\_by\_id** – ID of the user who created the passage (usually the uploader).
  * **last\_updated\_by\_id** – ID of who last updated the passage (often same as created\_by\_id).
  * **created\_at** – Timestamp when this passage was created (when the file was processed).
  * **updated\_at** – Timestamp of the last update to this passage record.
  * **is\_deleted** – Boolean indicating if this passage has been deleted/removed (defaults to false).
  * **agent\_id** – *(Optional)* If this passage has been copied to a specific agent’s memory, this may indicate the agent it’s associated with. Otherwise null/omitted.
  * **source\_id** – The ID of the data source this passage belongs to.
  * **file\_id** – The ID of the file from which this passage was derived.
  * **metadata** – Object for any metadata associated with the passage (e.g., file name, section info).
  * **id** – The unique identifier of the passage (format: `passage-xxxxxxxx`).
  * **embedding** – An array of numbers representing the vector embedding of this passage’s text.
  * **embedding\_config** – An object describing the embedding configuration used for this passage. (It typically includes fields such as the model name, embedding dimensions, provider info, etc., reflecting how the embedding was generated.)

## Jobs Endpoints

### GET `/jobs`

Lists all jobs in the organization (or those accessible to the user).

* **Example Request:**

  ```bash
  curl -X GET "https://api.letta.com/v1/jobs/" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** Retrieve a list of all jobs, including agent runs and other background tasks, that have been created. Jobs represent asynchronous tasks such as agent message processing, tool executions, file uploads, etc.

* **Response:** An array of job objects. Each job object includes the following fields:

  * **id** – Unique job identifier (format: `job-xxxxxxxx` or `run-xxxxxxxx`).
  * **created\_by\_id** – ID of the user who initiated the job.
  * **last\_updated\_by\_id** – ID of the user who last updated the job (often same as creator).
  * **created\_at** – Timestamp when the job was created.
  * **updated\_at** – Timestamp of the last update to the job.
  * **status** – Current status of the job (e.g., `"not_started"`, `"running"`, `"completed"`, `"failed"`).
  * **completed\_at** – Timestamp when the job finished, if completed (null if not yet completed).
  * **metadata** – Object containing any additional metadata for the job (may include error info if failed, or result info).
  * **job\_type** – Type of job (e.g., `"job"` for generic jobs, `"run"` for agent runs, `"batch"` for batch requests).
  * **callback\_url** – If a callback was specified, the URL that will be called upon job completion.
  * **callback\_sent\_at** – Timestamp of when the callback was last attempted (if applicable).
  * **callback\_status\_code** – HTTP status code returned by your callback endpoint (if a callback was attempted).

  You can filter jobs by source using the query parameter `source_id` (to list only jobs associated with a particular data source).

### GET `/jobs/active`

Lists all **active** (non-completed) jobs.

* **Example Request:**

  ```bash
  curl -X GET "https://api.letta.com/v1/jobs/active" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** Similar to GET /jobs, but this returns only jobs that are currently in progress or not yet started (i.e., status is not `"completed"` or `"failed"`). Use this to monitor which jobs are still pending or running.

* **Response:** An array of job objects in the same format as described above for GET /jobs. All the same fields (id, status, etc.) are provided for each job. By definition, each job’s `status` in this list will be one of the active states (e.g., `"not_started"`, `"running"`).

### GET `/jobs/{job_id}`

Retrieves the status and details of a specific job by ID.

* **Example Request:**

  ```bash
  curl -X GET "https://api.letta.com/v1/jobs/JOB_ID" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** Check the state of a particular job. This is often used to poll for completion of asynchronous tasks (for example, waiting for an agent’s long-running operation or a file upload to finish).

* **Response:** A job object with the same fields as described in GET /jobs above. Notable fields:

  * **status** – The job’s current status (e.g., `"completed"` when done).
  * **id** – The job’s ID (matches the one requested).
  * All other job metadata fields (timestamps, metadata, etc.) as documented in the list jobs response are present.

  This allows you to see if a job has finished and to obtain any result info provided in the `metadata` upon completion.

### DELETE `/jobs/{job_id}`

Cancels (and deletes) a job by ID.

* **Example Request:**

  ```bash
  curl -X DELETE "https://api.letta.com/v1/jobs/JOB_ID" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** Attempt to cancel an active job. This will stop the job if it’s still running, and remove its record. Not all jobs can be canceled (for example, a job might finish on its own before the cancel request). If a job is already completed, this call will simply delete the job record.

* **Response:** Returns the job object that was deleted (same fields as above). The returned object represents the last known state of the job at the time of deletion. Key fields of interest:

  * **status** – If the job was successfully canceled, the status may show as `"failed"` or `"completed"` depending on how the system marks canceled jobs, or it may remain in its last state. (There isn’t a distinct `"canceled"` state documented; a canceled job might be marked failed in metadata.)
  * **id** – The ID of the job that was deleted (for confirmation).
  * Other metadata and timestamps of the job’s last state are returned as in a normal job object.

  After this call, the job will no longer appear in list endpoints.

## Usage Endpoints

### GET `/runs/{run_id}/usage`

Retrieves token usage statistics for a specific agent **run**.

* **Example Request:**

  ```bash
  curl -X GET "https://api.letta.com/v1/runs/RUN_ID/usage" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** Get the number of tokens consumed during a particular run of an agent. This is useful for analyzing cost or performance, as it breaks down prompt vs completion token counts for that run.

* **Response:** A JSON object with the following fields:

  * **prompt\_tokens** – Number of tokens in the prompt (input) for this run.
  * **completion\_tokens** – Number of tokens in the assistant’s completion (output) for this run.
  * **total\_tokens** – Total tokens used (prompt + completion).
  * **prompt\_tokens\_details** – An object with details about prompt tokens, if applicable. For example, it may include a count of how many tokens were retrieved from cache (`cached_tokens`) vs newly embedded.
  * **completion\_tokens\_details** – An object with details about completion tokens. For example, for reasoning models, it might detail tokens used for reasoning steps (`reasoning_tokens`).

  **Example:** A response could look like:

  ```json
  {
    "completion_tokens": 150,
    "prompt_tokens": 1200,
    "total_tokens": 1350,
    "prompt_tokens_details": { "cached_tokens": 200 },
    "completion_tokens_details": { "reasoning_tokens": 50 }
  }
  ```

  This indicates 1,200 prompt tokens (200 came from cache) and 150 completion tokens (50 were reasoning), totaling 1,350.

*(If there are other usage endpoints (e.g. usage aggregated by time or by agent), they were not covered in the first pass. The primary usage metric provided by the API is per-run token usage as shown above.)*

## Templates Endpoints

*(Template management endpoints are available in Letta Cloud for creating and managing **Agent Templates**, which allow reusing agent configurations. Beyond listing templates, the following endpoints are provided:)*

### POST `/agents/{agent_id}/template`  *(Create Template from Agent – Cloud-only)*

Creates a new agent template from an existing agent’s configuration.

* **Example Request:**

  ```bash
  curl -X POST "https://api.letta.com/v1/agents/AGENT_ID/template" \
       -H "Authorization: Bearer <token>" \
       -H "Content-Type: application/json" \
       -d '{}'
  ```

  (No body fields are required for this request.)

* **Description:** **Letta Cloud only.** Creates an Agent Template based on the specified agent. This captures the agent’s design (prompts, tools, settings) so that new agents can be spawned from this template in the future. Essentially, it “saves” the agent as a reusable template.

* **Response:** If successful, returns a JSON object with the template’s identifying information:

  * **templateName** – The name of the newly created template (usually inherits the agent’s name, but can be a system-generated or provided name).
  * **templateId** – The unique identifier of the template. This ID is used to reference the template (for example, to list templates or create agents from this template).

  Example response:

  ```json
  {
    "templateName": "SalesAssistantTemplate",
    "templateId": "template-123e4567-e89b..."
  }
  ```

### POST `/agents/{agent_id}/version-template`  *(Version an Agent Template – Cloud-only)*

Creates a **new version** of an agent’s template (or creates a template if the agent isn’t currently templated).

* **Example Request:**

  ```bash
  curl -X POST "https://api.letta.com/v1/agents/AGENT_ID/version-template" \
       -H "Authorization: Bearer <token)" \
       -H "Content-Type: application/json" \
       -d '{ "message": "Saving new version" }'
  ```

* **Description:** **Letta Cloud only.** If the agent was created from a template, this endpoint will take the agent’s current state and save it as a **new version** of that template. If the agent was not originally from a template, calling this will first create a template from the agent and then create a version (effectively similar to the above **Create Template** call). This allows iteration on templates over time (version history).

* **Response:** On success, this call will update the underlying template. The API may return an empty response with status 201 or a message indicating success. Optionally, you can include `returnAgentState=true` as a query parameter to get the agent’s full state in the response if needed (not shown above). There is no detailed response body documented for this endpoint; generally you’ll know it succeeded if a 200-series status is returned and the template’s version count increases.

*(At the time of writing, the API reference does **not** list direct endpoints for deleting or renaming templates. Template management is mainly done via creating new versions or deleting the agents that were created from templates. For deletion of a template, one workaround is to delete the template’s project or contact Letta support, as no `DELETE /templates/{id}` endpoint is documented in the public API.)*

## Memory Variables Endpoints

### GET `/agents/{agent_id}/core-memory/variables`  *(Cloud-only)*

Returns the **memory variables** associated with a given agent.

* **Example Request:**

  ```bash
  curl -X GET "https://api.letta.com/v1/agents/AGENT_ID/core-memory/variables" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** **Letta Cloud only.** Fetches the dynamic memory variables for an agent. Memory variables are named placeholders in an agent’s core prompt/memory that can be set when creating an agent from a template (for example, a variable like `{location}` in a prompt that gets filled with a specific value for each agent). This endpoint lets you retrieve the current values of those variables for a running agent.

* **Response:** A JSON object with a single property:

  * **variables** – An object (dictionary) mapping variable names to their string values. For example:

    ```json
    {
      "variables": {
        "location": "Paris",
        "user_name": "Alice"
      }
    }
    ```

    In this case, the agent has memory variables `location` and `user_name` set to “Paris” and “Alice” respectively.

*(There are no separate endpoints for setting memory variables after agent creation; they are typically provided when creating an agent from a template. This GET endpoint is mainly to read what values are currently in use.)*

## Messages Endpoints (Global)

*(Global message endpoints refer to message retrieval outside the context of a single agent’s conversation. The primary case is retrieving messages from **batch runs**. Batch runs allow sending multiple messages in one request and then fetching all the results together.)*

### GET `/batch-runs/{batch_id}/messages`

Gets the messages produced by a specific batch job.

* **Example Request:**

  ```bash
  curl -X GET "https://api.letta.com/v1/batch-runs/BATCH_ID/messages" \
       -H "Authorization: Bearer <token>"
  ```

* **Description:** When you create a batch of messages (via the batch API) to have an agent or model respond to multiple prompts in parallel, this endpoint retrieves all the resulting messages (responses) from that batch run. The messages are returned in chronological order (oldest to newest by default, or newest first if `sort_descending=true`). You can paginate through results using a `cursor` (which should be set to the last message ID from the previous page).

* **Response:** A JSON object with a **`messages`** array. Each element in `messages` is a message object with the following fields:

  * **role** – The role of the message sender (`"user"` or `"assistant"`).
  * **created\_by\_id** – ID of the user or system that created the message.
  * **last\_updated\_by\_id** – ID of who last updated/edited the message (if applicable).
  * **created\_at** – Timestamp when the message was created.
  * **updated\_at** – Timestamp of the last update to the message.
  * **id** – The unique message ID (format: `message-xxxxxxxx`).
  * **agent\_id** – The ID of the agent that produced or received this message. In a batch, multiple agents could be involved if it’s a multi-agent batch; this field lets you know which agent a message is from.
  * **model** – The model name used for this message’s generation (e.g. which LLM was used).
  * **content** – The content of the message. This is typically an array of content segments, where each segment can contain a piece of text or a special marker. For example, an assistant message might have `content` like:

    ```json
    "content": [
      { "type": "omitted_reasoning" }
    ]
    ```

    which indicates the reasoning part was omitted. Generally, for normal messages, `content` will contain the text of the message.
  * **name** – An optional name for the message sender (used if the assistant message was given a specific name or if using function calling, etc.).
  * **tool\_calls** – A list of tool call objects that were made during the generation of this message (if the agent used any tools in producing the response). Each tool call includes an `id`, the `function` (name and arguments) invoked, and the `type` of tool call.
  * **tool\_call\_id** – If this message was generated as a direct result of a tool’s output, this may reference the tool call that produced it (links to one of the entries in `tool_calls`).
  * **step\_id** – The ID of the reasoning step (if the agent’s reasoning process is stepwise) associated with this message.
  * **otid** – The *offline threading ID*, which is a unique identifier used to group messages that belong to the same conversation thread even if the agent was offline (useful for debugging or linking related messages).
  * **tool\_returns** – A list of tool return objects (outputs from tool executions) if any were returned during the message’s creation. For example, if the assistant called a tool, this will contain the result (`status`, `stdout`, `stderr` from the tool).
  * **group\_id** – If this message is part of a multi-agent group interaction, this field identifies the group conversation it belongs to.
  * **sender\_id** – The identity ID of the end-user who sent the message, if applicable (for user messages in the batch). This can help identify which user or external source triggered the message.
  * **batch\_item\_id** – An ID linking the message to the specific batch request item. In a batch, you might send multiple prompts; each prompt has a batch item ID, and this field ties the message to the prompt it answers.

  The response object has the structure `{ "messages": [ ... ] }` wrapping the array of message objects. Pagination parameters `limit`, `cursor`, and `sort_descending` can be used to page through if the batch produced a large number of messages.

**Note:** Other message-related endpoints are typically scoped to agents (e.g. sending a message to an agent via `POST /agents/{agent_id}/messages` or listing an agent’s conversation messages via `GET /agents/{agent_id}/messages`). Those were covered previously. The endpoint above is global in the sense that it fetches messages from batch jobs rather than a single agent’s thread.
