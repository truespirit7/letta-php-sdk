# Letta API Endpoints Documentation

This document provides a comprehensive reference of all **Letta API** endpoints, organized by category. Each endpoint listing includes its HTTP method and full URL path, an example cURL request, a description of its purpose, and a detailed breakdown of the response fields.

## Agents API Endpoints

### GET `/v1/agents/` – List Agents

```bash
curl https://api.letta.com/v1/agents/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves a list of all agents (and their configurations) associated with the authenticated user. Supports filtering via query parameters (name, tags, etc.) and pagination.

**Response Fields:** The response is a JSON array of agent objects. Key fields for each agent include:

* **`id`** (string): Unique identifier of the agent.
* **`name`** (string): The agent's name.
* **`system`** (string): The system prompt (base persona or instructions) for the agent.
* **`agent_type`** (enum): Type of agent (e.g., `memgpt_agent`, `split_thread_agent`, `sleeptime_agent`, etc.).
* **`llm_config`** (object): Configuration of the language model for this agent (model name, provider, context window, etc.).
* **`embedding_config`** (object): Configuration of the embedding model for vector stores (embedding model name, dimensions, etc.).
* **`memory`** (object): In-context memory configuration, containing:

  * **`blocks`** (list of objects): Core memory blocks (chunks of persistent information) with fields like `value`, `limit` (character limit), `label`, etc..
  * **`prompt_template`** (string): The template format that arranges memory blocks in the prompt.
* **`tools`** (list of objects): Tools attached to the agent (each with fields `id`, `tool_type`, `name`, `description`, `source_code`, etc.).
* **`sources`** (list of objects): Data sources attached to the agent (with fields `id`, `name`, `description`, `instructions`, etc., plus an `embedding_config` for each source).
* **`tags`** (list of strings): Arbitrary tags associated with the agent.
* **`created_by_id`**, **`last_updated_by_id`** (string, optional): User IDs of who created and last updated the agent.
* **`created_at`**, **`updated_at`** (datetime string, optional): Timestamps of creation and last update.
* **`tool_rules`** (list of objects, optional): List of tool-use rules or constraints for this agent.
* **`message_ids`** (list of strings, optional): IDs of messages currently in the agent's conversation memory.
* **`response_format`** (object, optional): Format configuration for the agent's responses (e.g., `{ "type": "text" }`).
* **`description`** (string, optional): A human-readable description of the agent.
* **`metadata`** (object, optional): Additional metadata for the agent (custom key–value data).
* **`tool_exec_environment_variables`** (list of objects, optional): Environment variables specific to this agent's tool execution environment (each with `key`, `value`, etc.).
* **`project_id`**, **`template_id`**, **`base_template_id`** (string, optional): If using Letta Cloud projects and templates, these link the agent to a project or template (IDs).
* **`identity_ids`** (list of strings, optional): IDs of **Identity** objects associated with this agent (for multi-identity scenarios).
* **`message_buffer_autoclear`** (boolean, optional): If `true`, the agent's message history is not persisted between conversations (the agent still retains long-term memory via blocks).
* **`enable_sleeptime`** (boolean, optional): If `true`, enables background "sleeptime" memory management for this agent (moving memory management to a background thread).
* **`multi_agent_group`** (object, optional): If this agent is managing a multi-agent group, this object describes the group (see **Groups** section for fields like `manager_type`, `agent_ids`, etc.).

> **Note:** Query parameters for filtering are available: e.g., `name`, `tags`, `match_all_tags`, `query_text` (to search by name), as well as `before`, `after`, and `limit` for pagination. You can also filter by `project_id`, `template_id`, `base_template_id`, or `identity_id` if applicable. By default, all relational fields (tools, sources, memory, etc.) are included; you may specify `include_relationships` to limit which related data to include for performance.

### POST `/v1/agents/` – Create Agent

```bash
curl -X POST https://api.letta.com/v1/agents/ \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ ... }'
```

**Description:** Creates a new agent with the provided configuration. The request body should include agent settings such as name, system prompt, memory blocks, tools, sources, etc. (It accepts a JSON object similar in structure to the agent object returned by **List Agents**, minus database-assigned fields). On success, returns the newly created agent object.

**Response Fields:** Returns the full agent object that was created, with all fields as described in **List Agents** above (see that section for detailed field descriptions). Notably, the new agent will have a unique **`id`** assigned by the system. All configuration sub-objects (LLM config, embedding config, memory blocks, tools, etc.) will reflect the data as saved.

### GET `/v1/agents/count` – Count Agents

```bash
curl https://api.letta.com/v1/agents/count \
     -H "Authorization: Bearer <token>"
```

**Description:** Returns the total number of agents available to the user (or matching any provided filter query). Useful for quickly checking how many agents exist.

**Response Fields:** Returns an object with a field:

* **`count`** (integer): The number of agents that match the query (or total count if no filter).

### GET `/v1/agents/export` – Export Agent Serialized

```bash
curl https://api.letta.com/v1/agents/export?agent_id=<ID> \
     -H "Authorization: Bearer <token>"
```

**Description:** Exports an agent's full definition in a serialized format. This is typically used to get a portable representation of the agent (including memory blocks, tools, etc.) that can be saved or transferred.

**Response Fields:** Returns a serialized representation of the agent, usually as a JSON structure or file download. (The exact format includes agent configuration and is intended for use with the corresponding import endpoint.)

### POST `/v1/agents/import` – Import Agent Serialized

```bash
curl -X POST https://api.letta.com/v1/agents/import \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "serializedAgent": { ... } }'
```

**Description:** Creates a new agent by importing a previously exported agent serialization. The request body should include the serialized agent data (as obtained from the export endpoint). This allows cloning or migrating agents between environments.

**Response Fields:** Returns the newly created agent object (same fields as in **Create Agent**), which is the imported agent now registered in the system.

### GET `/v1/agents/{agent_id}` – Retrieve Agent

```bash
curl https://api.letta.com/v1/agents/<agent_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Fetches the full details of a single agent by its ID. This is essentially the same data as one element from **List Agents**, but for a specific agent.

**Response Fields:** Returns an agent object with all the same fields described in **List Agents** (id, name, system, configs, memory, tools, sources, etc.). This allows you to inspect the current configuration of one agent.

### DELETE `/v1/agents/{agent_id}` – Delete Agent

```bash
curl -X DELETE https://api.letta.com/v1/agents/<agent_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Permanently deletes the specified agent and all associated data (memory blocks, attached tools, sources, messages, etc.). **Use with caution**, as this action is irreversible.

**Response Fields:** On success, returns an empty response (HTTP 204 No Content) or a confirmation message. After deletion, the agent will no longer appear in **List Agents**.

### PATCH `/v1/agents/{agent_id}` – Modify Agent

```bash
curl -X PATCH https://api.letta.com/v1/agents/<agent_id> \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ ... }'
```

**Description:** Updates an existing agent's configuration. The request body should include only the fields to change – for example, you can change the agent's name, system prompt, tools, memory, etc.. Any fields not provided will remain unchanged.

**Response Fields:** Returns the updated agent object with all standard agent fields. Changed fields will reflect the new values. For example, if you updated `name` or added a tool, the response will show the new `name` and an updated `tools` list. All other fields match those described in **List Agents**.

### POST `/v1/agents/search` – Search Deployed Agents *(Cloud-only)*

```bash
curl -X POST https://api.letta.com/v1/agents/search \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "search": [ ... ], "project_id": "...", "combinator": "AND", "limit": 10 }'
```

**Description:** **(Letta Cloud only)** Searches for deployed agents using advanced filters. You can provide a complex query object (under the `"search"` key) to filter by agent attributes or metadata. For example, search criteria might include agent name contains a keyword, certain tags, project association, etc. This is useful in cloud environments where many agents might be deployed, to find specific ones.

**Response Fields:** Returns an object with:

* **`agents`** (list of agent objects): The agents matching the search criteria, each with full agent fields as described in **List Agents**. By default, up to a certain number of results will be returned (controllable via `limit`).
* **`nextCursor`** (string, optional): A cursor value for pagination, present if more agents match the criteria beyond the current result set.

*(Headers and request format as shown above. The search query structure allows multiple conditions; a `combinator` (e.g., `AND`) defines how multiple conditions are combined. This endpoint is only available in Letta Cloud deployments.)*

---

**Agent Sub-Resources and Actions:** The following endpoints allow management of agent-specific sub-resources (like an agent's context window, tools, data sources, memory, messages, etc.), typically identified by the agent's ID in the path.

### GET `/v1/agents/{agent_id}/context` – Retrieve Agent Context Window

```bash
curl https://api.letta.com/v1/agents/<agent_id>/context \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves the current **context window summary** for a given agent. This includes counts of tokens/messages in various parts of the agent's context and memory, as well as a snapshot of recent messages. It's useful for understanding how full the agent's context is and what content is currently influencing the agent.

**Response Fields:** Returns an object with statistics and content about the agent's context:

* **`context_window_size_max`** (integer): The maximum size (in tokens) of the agent's context window.
* **`context_window_size_current`** (integer): Current used tokens in the context window.
* **`num_messages`** (integer): Number of recent messages currently in the context.
* **`num_archival_memory`** (integer): Number of **archival memory** items (older memory stored outside the active context).
* **`num_recall_memory`** (integer): Number of **recall memory** items (if applicable).
* **`num_tokens_external_memory_summary`** (integer): Tokens used by any external memory summary.
* **`external_memory_summary`** (string): The summary of external memory (if the agent generates a summary of long-term memory).
* **`num_tokens_system`** (integer): Tokens in the system prompt portion.
* **`system_prompt`** (string): The current system prompt text.
* **`num_tokens_core_memory`** (integer): Tokens in the agent's core memory blocks currently in context.
* **`core_memory`** (string): A compiled string of the agent's core memory content currently in context (if applicable).
* **`num_tokens_summary_memory`** (integer): Tokens in any summary memory content.
* **`num_tokens_functions_definitions`** (integer): Tokens used by function/tool definitions in context.
* **`num_tokens_messages`** (integer): Tokens used by the messages in the context window.
* **`messages`** (list of objects): The recent messages currently in the agent's context (typically a truncated conversation history). Each message object includes fields such as `role` (e.g., "assistant" or "user"), `content` (message content, possibly segmented by type), `id` (message ID), `created_at`, `sender_id`, and any tool call/return data if the message involved a tool (similar structure as in **Agent Messages** below).
* **`summary_memory`** (string): A summary of older messages or memory that have been moved out of the active context (if the agent uses summary).
* **`functions_definitions`** (list): Definitions of tools/functions currently included in the context (each with a `function` definition and type).

This endpoint essentially provides insight into the agent's internal state regarding memory and context utilization.

### GET `/v1/agents/{agent_id}/tools` – List Agent's Tools

```bash
curl https://api.letta.com/v1/agents/<agent_id>/tools \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves the list of tools that are currently attached to a specific agent. This allows you to see what custom functions or external tools the agent can call during its operation.

**Response Fields:** Returns a JSON array of tool objects (the tools linked to the agent). Each tool object includes:

* **`id`** (string): Unique tool identifier (prefixed with `"tool-"`).
* **`tool_type`** (string): The category/type of tool (e.g., `"custom"` for user-defined tools).
* **`description`** (string): A description of what the tool does.
* **`source_type`** (string): The implementation type or source of the tool's code (for example, `"python"` or other indicator of how the tool is run).
* **`name`** (string): The function name of the tool (how it's invoked).
* **`tags`** (list of strings): Tags or labels associated with the tool (for organization/metadata).
* **`source_code`** (string): The source code of the tool (if it's a custom code tool).
* **`json_schema`** (object): The JSON schema for the tool's input/output (if defined).
* **`args_json_schema`** (object): JSON schema for the tool's arguments (if separate from the main schema).
* **`return_char_limit`** (integer): The maximum number of characters the tool's return value can have.
* **`created_by_id`** (string): User ID of who created the tool (if applicable).
* **`last_updated_by_id`** (string): User ID of who last updated the tool.
* **`metadata_`** (object): Additional metadata for the tool (if any).

These fields correspond to those of a Tool as described in the Tools section (see **Tools API Endpoints** for more detail).

### PATCH `/v1/agents/{agent_id}/tools/attach/{tool_id}` – Attach Tool to Agent

```bash
curl -X PATCH https://api.letta.com/v1/agents/<agent_id>/tools/attach/<tool_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Attaches an existing tool (identified by `tool_id`) to the specified agent. After this call, the agent will have the tool in its arsenal and can use it during conversations. This does not change the tool's global configuration; it just links the tool to the agent.

**Response Fields:** Returns the updated agent object (same format as in **Retrieve Agent**), now including the newly attached tool in its `tools` list. All agent fields are returned; key ones to verify include:

* **`tools`**: The list will now contain the tool that was attached (with all tool fields as described above).
* Other agent fields (id, name, etc.) remain the same.

This endpoint essentially returns the full agent config after modification. All standard agent response fields are present (see **List Agents**).

### PATCH `/v1/agents/{agent_id}/tools/detach/{tool_id}` – Detach Tool from Agent

```bash
curl -X PATCH https://api.letta.com/v1/agents/<agent_id>/tools/detach/<tool_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Detaches a tool from the agent, removing that tool from the agent's tool list. The tool itself is not deleted from the system; it just will no longer be accessible by that agent.

**Response Fields:** Returns the agent object after removal of the tool. The agent's **`tools`** list will no longer include the specified tool. Otherwise, the agent's fields remain as described in **List Agents**. Key things to verify in the response:

* The `tools` array should not contain the tool with the given `tool_id` (confirm by checking `id` fields in the list).
* The rest of the agent's configuration in the response is unchanged aside from any metadata updates like `last_updated_by_id`.

All standard agent fields (see above) are included in the response for completeness.

### GET `/v1/agents/{agent_id}/sources` – List Agent's Sources

```bash
curl https://api.letta.com/v1/agents/<agent_id>/sources \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves all data sources attached to a given agent. Data sources provide external knowledge (documents, files, etc.) that the agent can use. This endpoint lists each source that the agent is connected to.

**Response Fields:** Returns a JSON array of source objects associated with the agent. Each source object includes:

* **`id`** (string): Unique identifier of the source (prefixed with `"source-"`).
* **`name`** (string): Name of the data source.
* **`description`** (string): Description of the source (what kind of data it contains or its purpose).
* **`instructions`** (string): Instructions or notes on how the source should be used by the agent.
* **`embedding_config`** (object): The embedding model configuration used for this source's content (same structure as agent's embedding\_config, with fields like `embedding_model`, `embedding_dim`, etc.).
* **`metadata`** (object): Arbitrary metadata attached to the source.
* **`created_by_id`**, **`last_updated_by_id`** (string): Who created/last updated this source.
* **`created_at`**, **`updated_at`** (datetime): When the source was created and last updated.

These fields mirror those from the global Sources (see **Sources API Endpoints**). Essentially, this is a filtered list of those sources that are attached to the agent.

### PATCH `/v1/agents/{agent_id}/sources/attach/{source_id}` – Attach Source to Agent

```bash
curl -X PATCH https://api.letta.com/v1/agents/<agent_id>/sources/attach/<source_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Attaches a data source (identified by `source_id`) to the agent. After this, the agent will have access to the content of that source (its passages/documents) as part of its long-term memory.

**Response Fields:** Returns the updated agent object, now including the specified source in its **`sources`** list. The response is the full agent record (all fields as per **List Agents**), so you can verify that under `sources` the new source appears with its details. Other agent fields remain unchanged (aside from possibly `last_updated_by_id`).

### PATCH `/v1/agents/{agent_id}/sources/detach/{source_id}` – Detach Source from Agent

```bash
curl -X PATCH https://api.letta.com/v1/agents/<agent_id>/sources/detach/<source_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Detaches a data source from the agent, removing that source's content from the agent's accessible memory. The source itself remains in the system, but the agent will no longer reference its passages.

**Response Fields:** Returns the agent object after detaching the source. The agent's **`sources`** list will no longer include the specified source. The response includes all standard agent fields, identical to those described in **List Agents**. Key confirmation is that the `sources` array no longer contains the source with the given ID. (All other agent properties are returned for completeness.)

### GET `/v1/agents/{agent_id}/core-memory/blocks/{block_label}` – Retrieve Core Memory Block

```bash
curl https://api.letta.com/v1/agents/<agent_id>/core-memory/blocks/<block_label> \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves a single core memory **Block** from an agent's memory by its label (or name). Core memory blocks are segments of persistent memory (for example, persona definitions or long-term facts) that reside in the agent's context window. This endpoint lets you fetch the content and attributes of a specific block.

**Response Fields:** Returns a block object with the following fields:

* **`value`** (string): The textual content of the memory block.
* **`limit`** (integer): The character limit of this block (maximum length).
* **`name`** (string, optional): The name of the block if it is a template block (otherwise may be empty).
* **`is_template`** (boolean): Indicates if this block is a template (pre-defined structure) vs. dynamic content.
* **`label`** (string, optional): The label or role of the block (e.g., `"human"` or `"persona"` indicating how it's used in context).
* **`description`** (string, optional): A description of this block's purpose or content.
* **`metadata`** (object, optional): Metadata associated with the block (if any).
* **`id`** (string, optional): The unique ID of the block (prefixed `"block-"`). In many cases, the `label` is the primary key used, but an ID may also be present.
* **`created_by_id`** (string, optional): User ID who created this block (if applicable).
* **`last_updated_by_id`** (string, optional): User ID who last updated the block.

This endpoint is useful for reading the content of a particular memory slot in the agent.

### PATCH `/v1/agents/{agent_id}/core-memory/blocks/{block_label}` – Modify Core Memory Block

```bash
curl -X PATCH https://api.letta.com/v1/agents/<agent_id>/core-memory/blocks/<block_label> \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "value": "...", "limit": 6000, ... }'
```

**Description:** Updates the content or properties of an existing core memory block for an agent. For example, you can change the `value` (text) of a persona/human memory block, or adjust its `limit`, etc. Only the fields provided in the JSON body will be updated.

**Request Body:** Accepts a JSON object with any of the block fields that are modifiable: you can provide a new `value`, `name`, `description`, toggle `is_template`, etc. (See **Retrieve Core Memory Block** for field definitions.) For instance:

```json
{ 
  "value": "New persona or memory text...", 
  "limit": 5000 
}
```

**Response Fields:** Returns the updated block object with the same fields as in **Retrieve Core Memory Block**, reflecting the new values. Specifically, you should see the updated `value` and any other changed fields. Unmodified fields remain as before. For completeness, the response also includes metadata fields like `id`, `created_by_id`, etc., to confirm the block's identity.

### PATCH `/v1/agents/{agent_id}/core-memory/blocks/attach/{block_id}` – Attach Core Memory Block

```bash
curl -X PATCH https://api.letta.com/v1/agents/<agent_id>/core-memory/blocks/attach/<block_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** **(Advanced)** Attaches an existing memory block (usually one that was in archival storage or a template) back into the agent's **core memory**. In practice, this moves a memory block into the agent's active context (core memory) so that it will be included in the prompt. Typically used in conjunction with detaching/archiving memory.

**Response Fields:** Returns the full agent object after the block has been attached into core memory. The key difference will be in the agent's **`memory.blocks`** array: it will now include the block with the given `block_id` among the active blocks. All agent fields (as listed under **List Agents**) are returned; check that the intended block appears under `memory.blocks`. (The returned agent data lets you verify the operation's success.)

### PATCH `/v1/agents/{agent_id}/core-memory/blocks/detach/{block_id}` – Detach Core Memory Block

```bash
curl -X PATCH https://api.letta.com/v1/agents/<agent_id>/core-memory/blocks/detach/<block_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Detaches a memory block from the agent's core memory. This effectively **archives** that block (the block is removed from the active context; the agent will no longer use it in prompts unless re-attached). The block isn't deleted entirely; it can potentially be recalled or remains in long-term storage.

**Response Fields:** Returns the updated agent object. The agent's **`memory.blocks`** list will no longer contain the block with the specified `block_id`. All other agent fields are included in the response (see **List Agents** for full list). You can confirm success by checking that `memory.blocks` in the response is missing the detached block, and possibly by an updated `last_updated_by_id` timestamp.

### GET `/v1/agents/{agent_id}/messages` – List Messages (Agent Chat History)

```bash
curl https://api.letta.com/v1/agents/<agent_id>/messages \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves the message history (conversation log) for the specified agent. This includes all messages (user, assistant, system, etc.) stored for that agent's current session or across sessions, depending on memory settings. By default, it returns the most recent messages (with pagination support to get more).

**Response Fields:** Returns a JSON array of message objects. Each message in the list can be one of several **message types**, each with slightly different fields:

Common fields across message types include:

* **`id`** (string): Unique message identifier.
* **`date`** (string): Timestamp of the message (may be in ISO format or a custom format).
* **`name`** (string): Name associated with the message sender (for system/assistant messages this might be a role or empty, for user it could be the user's name).
* **`message_type`** (string): Type of message, e.g., `"user_message"`, `"system_message"`, `"assistant_message"`, `"reasoning_message"`, etc.. This indicates which variant of message object it is.
* **`sender_id`** (string): ID of the sender (could be user ID for user messages, agent ID for assistant messages, etc.).
* **`step_id`** (string, optional): If the message is associated with a reasoning or tool execution step, this links to a Step ID (see Steps section).
* **`otid`** (string, optional): An "operation ID" or tracing ID if the message is part of a tool call/return chain.
* **`content`** (list or object): The content of the message. For most messages, this is a list of content segments (each segment might have a `type` and actual text). For example, assistant messages may include an array with different content types (normal text, or special types like omitted reasoning). User messages typically have a text content segment.

Depending on `message_type`, additional fields may appear:

* **Tool Call / Tool Return messages:** These will include fields like `tool_calls` (an array describing tool function calls made during the message), `tool_call_id` (an ID linking to a specific tool call), and `tool_returns` (results from tools).
* **Reasoning messages:** These might include details of the AI's reasoning process (if such are exposed).
* **Assistant messages:** Could have similar fields to user messages but are generated by the agent.

In the API documentation, messages are categorized by type with specific property sets (e.g., System Message object, User Message object, Reasoning Message object, Hidden Reasoning, Tool Call, Tool Return, Assistant Message). Each category has a defined set of properties. For simplicity:

* **System Message:** Typically has `id, date, content` (system instructions at conversation start).
* **User Message:** `id, date, sender_id (user ID), content` of the user's input.
* **Assistant Message:** `id, date, content` of the agent's reply; may include references to tool usage (if any).
* **Reasoning Message:** Internal thoughts (usually hidden unless specifically requested); contain content representing the agent's reasoning.
* **Tool Call Message:** Captures when the agent invoked a tool (with details of the function and arguments).
* **Tool Return Message:** Captures the result of a tool invocation (stdout/stderr outputs).

The endpoint returns the messages in chronological order (oldest first) by default, limited by the `limit` parameter (default 10). Pagination is supported via `after`/`before` cursors (message IDs).

**Query Parameters:** You can use `before`, `after` to paginate through messages, `limit` to adjust the number of messages returned (default 10). There's also `group_id` to filter messages to a particular group conversation (if the agent is in a multi-agent group). Advanced options like `use_assistant_message` toggle how messages from tools are interpreted (usually keep at default).

### POST `/v1/agents/{agent_id}/messages` – Send Message (Agent Interaction)

```bash
curl -X POST https://api.letta.com/v1/agents/<agent_id>/messages \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ 
           "messages": [ { "role": "user", "content": [{ "text": "Hello agent" }] } ] 
         }'
```

**Description:** Sends a new message (typically from a user) to the agent and processes it, returning the agent's response. This is the primary endpoint to interact with an agent conversationally. You provide a list of messages (usually the latest user message, and optionally any system or context messages) and the agent will produce a reply.

**Request Body:** A JSON object with:

* **`messages`** (list of message objects, Required): The messages to send in this interaction. Usually this list contains a single user message (with `"role": "user"` and some content). It can include multiple messages if simulating a multi-turn input, but commonly one message at a time. Each message object in the list should have at least a `role` and `content`. The `content` is typically a list of segments (for text, a simple example is `[ { "type": "text", "text": "Hello" } ]`). *(The exact structure can vary; the agent expects a certain format which is consistent with how messages are represented in the response.)*
* **`use_assistant_message`** (boolean, Optional): Defaults to `true`. If true, the server will treat certain tool calls as if they were assistant messages (an internal detail – generally leave as true).
* **`assistant_message_tool_name`** (string, Optional): Defaults to `"send_message"`. The designated tool name that, if called, should be treated as sending an assistant message.
* **`assistant_message_tool_kwarg`** (string, Optional): Defaults to `"message"`. The argument name for the message content in the above tool.

**Response Fields:** Returns an object with:

* **`messages`** (list of message objects): The messages generated by the agent in response. Typically, this will include the assistant's reply as an **Assistant Message** object. If the agent's reasoning or tool use is exposed, the list may also include **Reasoning** or **Tool** message objects. By default, you will usually see one assistant message here containing the agent's answer. (The message object structure is the same as described under **List Messages** above – e.g., an assistant message with `id, content, etc.` and possibly `tool_calls` if the agent used tools).
* **`usage`** (object): Usage statistics for this interaction. This may include token counts (prompt tokens, completion tokens, total tokens) and other information about the cost of the operation. Fields might be:

  * `prompt_tokens`, `completion_tokens`, `total_tokens` – indicating how many tokens were in the input and output.
  * Other metrics like `model` used, processing time, etc., depending on implementation.

This synchronous endpoint processes the conversation turn and gives you the agent's reply immediately (suitable for real-time chat).

### PATCH `/v1/agents/{agent_id}/messages/{message_id}` – Modify Message

```bash
curl -X PATCH https://api.letta.com/v1/agents/<agent_id>/messages/<message_id> \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "content": "corrected or updated text" }'
```

**Description:** Updates the content or details of a specific message in the agent's history. This can be used to correct a message after the fact (for example, editing a user's message or a system prompt in the history) or to add annotations.

**Request Body:** You provide the fields to update. Common usage is to change the `content` of a message. Depending on message type, there are different allowed updates (the API defines different update object schemas for system vs user vs assistant messages, etc. – the documentation references "Update System Message object", "Update User Message object", etc., each with certain properties). In practice, providing a new `content` string is supported for most message types.

**Response Fields:** Returns the updated message object. The message will reflect changes such as new `content` text. The response can vary by message type: the API might return the full message or a standardized representation. According to the docs, the response can be one of multiple variants (System Message, User Message, etc.). In each case, you will get the message's fields (id, content, etc.) updated. For example, if you edited a system message, you'd receive a System Message object with its properties, if you edited a user message, a User Message object, and so on. (The variant breakdown is managed internally – essentially you get the same message back in the same structure it would appear in list messages.)

### POST `/v1/agents/{agent_id}/messages/async` – Send Message Asynchronously

```bash
curl -X POST https://api.letta.com/v1/agents/<agent_id>/messages/async \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "messages": [ { "role": "user", "content": [ ... ] } ] }'
```

**Description:** Initiates processing of a message by the agent asynchronously. Instead of waiting for the agent's response within the request, this returns immediately with a **Run ID**, and the agent will process the message in the background. This is useful for long-running tasks or if you want to poll or get a callback when the agent's answer is ready.

**Response Fields:** Returns a **Run** object (representing the asynchronous job) with fields:

* **`id`** (string): The run's unique ID (e.g., `"run-<UUID>"`). You will use this ID to check the status or retrieve results later (see **Runs** endpoints).
* **`status`** (string): The current status of the run, e.g. `"not_started"`, `"running"`, `"completed"`, `"failed"`, etc.. Initially it may be `"not_started"` or `"running"`.
* **`created_by_id`**, **`last_updated_by_id`** (string): Who initiated the run (likely your user ID) and last update actor.
* **`created_at`**, **`updated_at`** (datetime): Timestamps for creation and last update of the run record.
* **`completed_at`** (datetime, optional): Timestamp when the run finished (if it has).
* **`metadata`** (object): Any additional metadata for the run (usually empty `{}` unless used for callbacks or custom info).
* **`job_type`** (enum): The type of job – typically `"run"` or `"job"` (these terms are used interchangeably; it might say `"job"` in this context).
* **`callback_url`** (string, optional): If a callback URL was set for this run, it will be listed here (the system will POST the results to that URL when done).
* **`callback_sent_at`** (datetime, optional): Timestamp of the last callback attempt (if any).
* **`callback_status_code`** (integer, optional): HTTP status code returned by your callback endpoint (if called).
* **`request_config`** (object): Echoes the configuration used for this request (such as the `use_assistant_message` settings). In the example, it includes flags like `"use_assistant_message": true` etc., confirming how the message was interpreted.

After initiating an async send, you would typically use the **Runs** endpoints (see below) to query the run's status or to retrieve the output once it's completed.

### PATCH `/v1/agents/{agent_id}/reset-messages` – Reset Agent Messages

```bash
curl -X PATCH https://api.letta.com/v1/agents/<agent_id>/reset-messages \
     -H "Authorization: Bearer <token>"
```

**Description:** Clears **all conversation messages** for the agent, essentially resetting the chat history/state. This is akin to starting a fresh conversation with the agent. Optionally, you can have default initial system messages re-inserted after the reset.

**Query Parameter:** `add_default_initial_messages` (boolean, optional, default `false`). If `true`, after wiping the messages the system will add the agent's default system messages (if any) back to the history (for example, a default system prompt or persona message that new conversations normally start with).

**Response Fields:** Returns the full agent object, similar to **Retrieve Agent**. Notably:

* The agent's **`message_ids`** list will be empty (or contain only any default initial message IDs if those were added). In other words, the agent's conversation memory is cleared.
* All other agent configuration fields (tools, memory, etc.) remain unchanged. The response includes them all for completeness (see **List Agents** fields).
* Essentially, you get the agent state post-reset: no recent messages, and possibly a fresh system message if defaults were added.

This allows you to programmatically clear an agent's conversation context without deleting the agent itself.

---

## Tools API Endpoints

*(The Tools endpoints manage the global registry of tools (custom functions or integrations) that can be attached to agents.)* Each tool in Letta is defined globally and can then be attached to one or more agents.

### GET `/v1/tools/` – List Tools

```bash
curl https://api.letta.com/v1/tools/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves all tools available in the system (for the authenticated user's organization). This list includes custom tools you've created as well as any built-in or base tools provided by the system.

**Response Fields:** Returns an array of tool objects. Each tool object includes:

* **`id`** (string): The unique tool ID (format: **`tool-XXXXXXXX`**).
* **`tool_type`** (enum): The type/category of the tool (e.g., `"custom"`, or other categories if defined). Possible values include custom, base, composio, etc. (system-defined list).
* **`description`** (string): A description of what the tool does.
* **`source_type`** (string): The technology or format of the tool's implementation (e.g., `"python"` for a Python function, `"external"` for an API call, etc.).
* **`name`** (string): The callable name of the tool (function name that agents use to invoke it).
* **`tags`** (list of strings): Tags/keywords attached to the tool for categorization.
* **`source_code`** (string): The code or content of the tool. For a custom code tool, this is the actual source code (function body) that will be executed.
* **`json_schema`** (object): JSON Schema describing the tool's input/output (if applicable). (Often an empty object `{}` if not used.)
* **`args_json_schema`** (object): JSON Schema describing the tool's expected arguments structure.
* **`return_char_limit`** (integer): The maximum number of characters the tool's output can produce. This prevents tools from returning excessively large results.
* **`created_by_id`** (string): The user ID of who created the tool.
* **`last_updated_by_id`** (string): The user ID of who last updated the tool.
* **`metadata_`** (object): A metadata dictionary for additional info about the tool.

This endpoint gives an overview of all tools that can potentially be attached to agents.

### POST `/v1/tools/` – Create Tool

```bash
curl -X POST https://api.letta.com/v1/tools/ \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ 
           "name": "my_tool", 
           "description": "Does X", 
           "tool_type": "custom", 
           "source_type": "python", 
           "source_code": "...", 
           "json_schema": {}, 
           "args_json_schema": {}, 
           "return_char_limit": 5000 
         }'
```

**Description:** Registers a new custom tool in the system. You must provide details such as the tool's name (function name), description, type, and implementation code or configuration. Once created, the tool can be attached to agents.

**Response Fields:** Returns the newly created tool object, with all the fields as described in **List Tools** above (including its assigned `id`). For example, you'll see the `id` (generated), `name`, `description`, `tool_type`, etc., matching what was provided, and default or system-filled values for any omitted fields (e.g., `created_by_id` will be your user ID, `metadata_` might be empty).

### PUT `/v1/tools/` – Upsert Tool

```bash
curl -X PUT https://api.letta.com/v1/tools/ \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ ... }'
```

**Description:** Creates or updates a tool in one call ("upsert" = update if exists, otherwise insert). You typically include an `id` or unique key so the system knows if it's an existing tool. If a tool with the given identifier exists, it will be updated with the provided fields; if not, a new tool is created.

**Response Fields:** Returns the tool object after upsert. If it created a new tool, it will resemble the **Create Tool** response; if it updated an existing tool, it will show the tool with updated fields. All standard tool fields are present.

### POST `/v1/tools/base` – Upsert Base Tools

```bash
curl -X POST https://api.letta.com/v1/tools/base \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ ... }'
```

**Description:** (Advanced) Upserts the **base tools**. Base tools are a set of default tools (possibly provided by Letta or configured as a baseline). This endpoint allows adding/updating multiple base tools in bulk. It's generally used internally or for administrative updates of default tool sets.

**Response Fields:** Returns a list of base tool objects that were upserted or affected, each with standard tool fields. Essentially confirms the base tool configurations now in place.

### POST `/v1/tools/run-from-source` – Run Tool From Source

```bash
curl -X POST https://api.letta.com/v1/tools/run-from-source \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "source_code": "...", "input": { ... } }'
```

**Description:** Runs a snippet of tool code on-the-fly without creating a persistent tool. You provide `source_code` for a tool and an `input` for it, and the system executes it once and returns the result. This is useful for quickly testing code or running an ephemeral action without registering a new tool.

**Response Fields:** Returns the execution result, likely an object containing:

* The **stdout** or output of the tool,
* The **stderr** if any errors occurred,
* Possibly a status indicator.

(It does not return a full tool object since no tool is being saved – instead it gives you the output of running the code.)

### GET `/v1/tools/composio/apps` – List Composio Apps

```bash
curl https://api.letta.com/v1/tools/composio/apps \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists available **Composio** apps. Composio is an integration for tools (it likely refers to composite or external packaged tools). This endpoint shows which Composio applications are available to add as tools.

**Response Fields:** Returns a list of apps, each possibly with fields like `name`, `app_id`, and details about what actions they support. (For example, an app might be an integration like Google, Slack, etc., with its own set of actions.)

### GET `/v1/tools/composio/apps/{app_name}/actions` – List Composio Actions by App

```bash
curl https://api.letta.com/v1/tools/composio/apps/<app_name>/actions \
     -H "Authorization: Bearer <token>"
```

**Description:** Given a Composio app (by name or ID), this returns all the actions that app supports as tools. For instance, if the app is a third-party service, the actions might be specific API calls or functions of that service.

**Response Fields:** Returns a list of actions. Each action might include fields such as `action_name`, `description`, input schema, etc., describing how it can be used as a tool.

### POST `/v1/tools/composio` – Add Composio Tool

```bash
curl -X POST https://api.letta.com/v1/tools/composio \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "app": "app_name", "action": "action_name", "config": { ... } }'
```

**Description:** Adds a new tool to Letta based on a Composio app action. You specify which app and action to create a tool for, and provide any configuration needed (like auth keys or parameters). The system then creates a tool wrapping that external action.

**Response Fields:** Returns the created tool object, with the standard fields (it will likely have `tool_type` reflecting it's a Composio type, the `name` might be auto-generated or based on the app-action, etc.). The important part is that this new tool can then be attached to agents like any other.

### GET `/v1/tools/mcp` – List MCP Servers

```bash
curl https://api.letta.com/v1/tools/mcp/servers \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists configured **MCP** (Model Context Protocol) servers. MCP servers are external tool servers that Letta can connect to for additional tools. This endpoint shows all configured remote MCP endpoints.

**Response Fields:** A list of MCP server entries, each with details such as `server_id` or name, URL/host, and possibly status or metadata about the server.

### PUT `/v1/tools/mcp` – Add MCP Server to Config

```bash
curl -X PUT https://api.letta.com/v1/tools/mcp/servers \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "url": "http://example.com/api", "name": "My MCP Server" }'
```

**Description:** Registers a new external MCP server with Letta. After adding, the tools provided by that server can be listed and added to agents.

**Response Fields:** Returns the list of MCP servers now configured (including the newly added one), or a confirmation. The new server's details (like an ID or name and URL) will be included.

### GET `/v1/tools/mcp/{server_id}/tools` – List MCP Tools by Server

```bash
curl https://api.letta.com/v1/tools/mcp/<server_id>/tools \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves all tools that are available from a specific MCP server (by server ID or name). These are external tools hosted on that remote server.

**Response Fields:** A list of tool definitions coming from the MCP server. They likely have similar fields (name, description, etc.), but are not yet local tools in Letta until added. This is for viewing what's available on that server.

### POST `/v1/tools/mcp` – Add MCP Tool

```bash
curl -X POST https://api.letta.com/v1/tools/mcp/tools \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "server_id": "<id>", "tool_name": "<remote_tool_name>" }'
```

**Description:** Adds a tool from an MCP server into Letta's tool list. Essentially, you specify which tool (by name or ID) on which server to import, and Letta will create a local tool that proxies to the remote implementation.

**Response Fields:** Returns the created local tool object (with standard fields like `id`, `name`, etc.). The `source_type` or other metadata may indicate it's an MCP proxy. Once created, it behaves like a normal tool that can be attached to agents.

### DELETE `/v1/tools/mcp/servers/{server_id}` – Delete MCP Server from Config

```bash
curl -X DELETE https://api.letta.com/v1/tools/mcp/servers/<server_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Removes an MCP server configuration from Letta. This will typically also disable any tools that were associated with that server (those tools may need to be cleaned up separately).

**Response Fields:** Typically returns an empty response or a confirmation message. After this call, the server will no longer be listed in **List MCP Servers**, and its tools will not be available (calls to them may fail if not removed).

*(Tools endpoints allow powerful extension of agent capabilities. After creating or importing tools with these endpoints, use the **Agents** endpoints (Attach/Detach Tool) to manage which agents have access to them.)*

## Sources API Endpoints

Data Sources represent knowledge bases (document sets, files, etc.) that agents can use for long-term memory and retrieval.

### GET `/v1/sources/` – List Sources

```bash
curl https://api.letta.com/v1/sources/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists all data sources created by or accessible to the user. These could include file databases, web content, or any text sources loaded into Letta.

**Response Fields:** Returns an array of source objects. Each source object includes:

* **`id`** (string): Unique source identifier (format **`source-XXXXXXXX`**).
* **`name`** (string): Name of the data source.
* **`description`** (string): Description of the source content or purpose.
* **`instructions`** (string): Instructions/notes on using the source (e.g., how an agent should reference it).
* **`embedding_config`** (object): The embedding model settings for this source's content (with fields: `embedding_endpoint_type`, `embedding_model`, `embedding_dim`, `embedding_chunk_size`, etc.). This config dictates how the source's content is vectorized for recall.
* **`metadata`** (object): Arbitrary metadata tags for the source.
* **`created_by_id`** (string): User ID of the creator of the source.
* **`last_updated_by_id`** (string): User ID of who last updated it.
* **`created_at`** (datetime): Timestamp when the source was created.
* **`updated_at`** (datetime): Timestamp when the source was last updated.

This endpoint shows all data sources in your account, regardless of whether they are attached to agents.

### POST `/v1/sources/` – Create Source

```bash
curl -X POST https://api.letta.com/v1/sources/ \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ 
           "name": "My Documents", 
           "description": "Knowledge base of docs", 
           "instructions": "Use this for product Q&A.", 
           "embedding_config": { "embedding_model": "openai-text-embedding-ada-002", ... }, 
           "metadata": {} 
         }'
```

**Description:** Creates a new data source. Initially, a source has no content until files or passages are added (via separate file upload or passage creation not shown here). You define the source's name, description, and how to embed its content.

**Response Fields:** Returns the created source object with all fields as in **List Sources**. Key fields to check are the assigned `id` and that the `embedding_config` reflects your input or defaults. The source initially will have no passages/files until you add some.

### GET `/v1/sources/count` – Count Sources

```bash
curl https://api.letta.com/v1/sources/count \
     -H "Authorization: Bearer <token>"
```

**Description:** Returns the number of data sources available.

**Response Fields:** An object with:

* **`count`** (integer): total number of sources.

### GET `/v1/sources/{source_id}` – Retrieve Source

```bash
curl https://api.letta.com/v1/sources/<source_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Fetches details of a specific data source by ID. This is similar to getting a single source from **List Sources**.

**Response Fields:** Returns the source object (same fields as described in **List Sources**: id, name, description, instructions, embedding\_config, etc.) for the given source.

### PATCH `/v1/sources/{source_id}` – Modify Source

```bash
curl -X PATCH https://api.letta.com/v1/sources/<source_id> \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "description": "Updated description" }'
```

**Description:** Updates properties of a data source. You can change fields like `name`, `description`, `instructions`, or even the `embedding_config` (for example, switch to a different embedding model) as needed.

**Response Fields:** Returns the updated source object with the new values. Any fields not included in the request remain unchanged. (Standard fields as per **List Sources**.)

### DELETE `/v1/sources/{source_id}` – Delete Source

```bash
curl -X DELETE https://api.letta.com/v1/sources/<source_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Deletes a data source and all its content (passages/files). **Warning:** This will remove all memory content associated with that source from any agents that had it attached. This is irreversible.

**Response Fields:** On success, typically an empty response (204 No Content) or confirmation message. The source will no longer appear in **List Sources**, and agents that were using it will no longer reference its data.

### GET `/v1/sources/id/{name}` – Get Source ID by Name

```bash
curl https://api.letta.com/v1/sources/id/<source_name> \
     -H "Authorization: Bearer <token>"
```

**Description:** Convenience endpoint to retrieve a source's ID by its name. If you know the human-readable name of a source, you can get the `id` (which is needed for other API calls) without listing all sources.

**Response Fields:** Returns an object like `{ "id": "source-1234abcd..." }` if a source with that name exists. If not, it might return a 404 or an empty result.

**Source Files & Passages:** *These sub-endpoints allow managing the content of data sources.*

* **List Source Files:** *(`GET /v1/sources/{source_id}/files`)* – Returns metadata of files uploaded to the source (file names, sizes, etc.). Files represent raw documents added to the source.

* **Upload File to Source:** *(`POST /v1/sources/{source_id}/files`)* – Allows uploading a new file (document) to the data source. The file's contents will be processed into passages for the agent's memory. (Typically a multipart form upload.)

* **Delete File From Source:** *(`DELETE /v1/sources/{source_id}/files/{file_id}`)* – Removes a file (and its associated passages) from the source.

* **List Source Passages:** *(`GET /v1/sources/{source_id}/passages`)* – Lists the atomic text passages that have been indexed for the source. Passages are chunks of text derived from files, which the agent can search through. Each passage may have fields like `id`, `text`, and metadata (source file reference, etc.).

* *(Creating or modifying passages is generally handled automatically when files are added. The API also may allow direct passage creation if needed.)*

These file/passage endpoints are primarily used to feed data into sources and manage it. Once a source has passages, an agent with that source attached can recall information from those passages during conversations.

## Groups API Endpoints

Multi-agent **Groups** allow multiple agents to work together or be managed collectively. A Group typically defines a set of agent IDs and how they interact (e.g., round-robin managers, etc.).

### GET `/v1/groups/` – List Groups

```bash
curl https://api.letta.com/v1/groups/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves all multi-agent groups for the user. This lets you see configurations where agents have been grouped (for collaborative or managed interactions).

**Response Fields:** Returns an array of group objects. Each group object has:

* **`id`** (string): Unique identifier of the group.
* **`manager_type`** (string): The strategy for the group's manager agent (e.g., `"round_robin"`, `"all_to_one"`, etc.). This defines how messages or turns are assigned among group members.
* **`agent_ids`** (list of strings): The IDs of member agents that belong to this group.
* **`description`** (string): A description of the group's purpose or behavior.
* **`shared_block_ids`** (list of strings, optional): IDs of memory blocks that are shared among agents in the group (if any).
* **`manager_agent_id`** (string, optional): If the group has a designated "manager" agent, this is the agent ID that orchestrates the group.
* **`termination_token`** (string, optional): A special token or keyword that, if encountered, might trigger termination of the group interaction.
* **`max_turns`** (integer, optional): Maximum number of turns in a group conversation before it should end or rotate.
* **`sleeptime_agent_frequency`** (integer, optional): Frequency (in turns) at which a "sleeptime" memory management agent should intervene (used if one agent in group manages long-term memory asynchronously).
* **`turns_counter`** (integer, optional): Counter of how many turns have happened in the group so far.
* **`last_processed_message_id`** (string, optional): The ID of the last message that was processed by the group's manager (for tracking state).
* **`max_message_buffer_length`** (integer, optional): Desired max number of recent messages each agent in the group should hold in context. This is a guideline for memory management (to avoid context overflow).
* **`min_message_buffer_length`** (integer, optional): Desired minimum number of messages to retain.

This endpoint gives an overview of multi-agent collaboration setups.

### POST `/v1/groups/` – Create Group

```bash
curl -X POST https://api.letta.com/v1/groups/ \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ 
           "manager_type": "round_robin", 
           "agent_ids": ["agent1", "agent2"], 
           "description": "Agent collaboration group", 
           "shared_block_ids": [], 
           "manager_agent_id": null 
         }'
```

**Description:** Creates a new group of agents with the specified configuration. You define how the group is managed and which agents are members.

**Response Fields:** Returns the created group object, with all the fields as described in **List Groups** (including its new `id`). Verify that `agent_ids` match what was sent, `manager_type` is set, etc. Any defaults (like counters starting at 0, etc.) will be present.

### GET `/v1/groups/count` – Count Groups

```bash
curl https://api.letta.com/v1/groups/count \
     -H "Authorization: Bearer <token>"
```

**Description:** Returns the number of groups.

**Response Fields:** An object with `count` (integer) indicating how many groups exist.

### GET `/v1/groups/{group_id}` – Retrieve Group

```bash
curl https://api.letta.com/v1/groups/<group_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Fetches a specific group's details by ID.

**Response Fields:** Returns the group object (fields same as in **List Groups**) for the given ID.

### PATCH `/v1/groups/{group_id}` – Modify Group

```bash
curl -X PATCH https://api.letta.com/v1/groups/<group_id> \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "agent_ids": ["agent1","agent3"] }'
```

**Description:** Updates the group's configuration. You can add/remove agents by changing `agent_ids`, change the `manager_type`, update description, etc.

**Response Fields:** Returns the updated group object with new values in place. For example, if you changed the `agent_ids`, the returned `agent_ids` list will reflect that change.

### DELETE `/v1/groups/{group_id}` – Delete Group

```bash
curl -X DELETE https://api.letta.com/v1/groups/<group_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Deletes a group. This does not delete the agents in the group; it just disbands the group configuration.

**Response Fields:** On success, an empty response or confirmation. The group will no longer appear in **List Groups**.

*(In an agent's perspective, when an agent is part of a group, its `multi_agent_group` field (in agent details) will reference the group configuration. Managing groups via these endpoints updates which agents have that link.)*

## Identities API Endpoints

**Identities** represent distinct personas or roles that can be associated with agents or conversations. They can be used, for example, to isolate conversations or switch the "identity" of an agent (like different users or characters).

### GET `/v1/identities/` – List Identities

```bash
curl https://api.letta.com/v1/identities/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists all identity profiles available to the user. An identity might include information like a name, persona description, or other attributes that define a role or user identity.

**Response Fields:** Returns an array of identity objects. Each identity object could include:

* **`id`** (string): Unique identity ID (e.g., `"identity-XXXXXXXX"`).
* **`name`** (string): Name of the identity (for example, a user name or character name).
* **`description`** (string, optional): A description of this identity (could be a persona's background or context).
* **`metadata`** (object, optional): Additional info for the identity.

(The exact fields depend on how identities are defined in Letta. These are typically simpler structures representing a user or persona.)

### POST `/v1/identities/` – Create Identity

```bash
curl -X POST https://api.letta.com/v1/identities/ \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "name": "Alice", "description": "Alice persona for customer support" }'
```

**Description:** Creates a new identity profile. For example, you might create identities for different users or roles that interact with agents.

**Response Fields:** Returns the newly created identity object, including its assigned `id` and the fields you provided (`name`, `description`, etc.).

### PUT `/v1/identities/` – Upsert Identity

```bash
curl -X PUT https://api.letta.com/v1/identities/ \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "name": "Alice", "description": "Updated description" }'
```

**Description:** Creates or updates an identity. If an identity with the given name (or ID, if specified) exists, it will be updated; otherwise, a new identity is created.

**Response Fields:** Returns the identity object after upsert (with current values).

### GET `/v1/identities/count` – Count Identities

```bash
curl https://api.letta.com/v1/identities/count \
     -H "Authorization: Bearer <token>"
```

**Description:** Returns the number of identity profiles.

**Response Fields:** An object with `count` (integer).

### GET `/v1/identities/{identity_id}` – Retrieve Identity

```bash
curl https://api.letta.com/v1/identities/<identity_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Fetches details of a specific identity by ID.

**Response Fields:** Returns the identity object (id, name, description, etc.) for that ID.

### DELETE `/v1/identities/{identity_id}` – Delete Identity

```bash
curl -X DELETE https://api.letta.com/v1/identities/<identity_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Deletes an identity profile. If agents were associated with this identity (via `identity_ids`), those associations should be considered removed (the agent will simply have one less identity associated).

**Response Fields:** On success, empty or confirmation. The identity will no longer appear in **List Identities**.

*(Identities might be used in Letta Cloud to isolate conversation histories or to provide multi-user support. For example, you could have one agent serving multiple end-users and use identities to keep their conversations separate in memory.)*

## Models API Endpoints

These endpoints list which AI models are available for use in Letta (for LLMs and embeddings). They are read-only informational endpoints.

### GET `/v1/models/llm` – List LLM Models

```bash
curl https://api.letta.com/v1/models/llm \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists all Large Language Models (LLMs) that are configured and available on the Letta server. This may include local models and any provider models (OpenAI, etc.) that have been enabled.

**Response Fields:** Returns a list of model entries. Each entry might include:

* **`name`** (string): The model's name or identifier (e.g., `"gpt-3.5-turbo"`, `"llama-2-13b"`).
* **`provider`** (string): Which provider or category this model belongs to (e.g., `"openai"`, `"local"`).
* **`context_window`** (integer): The maximum context length (in tokens) of the model.
* **`description`** (string, optional): A human-friendly description of the model.
* **`capabilities`** (object, optional): Any flags about what the model supports (e.g., functions, streaming, etc.).

This lets you see what you can set in an agent's `llm_config`.

### GET `/v1/models/embedding` – List Embedding Models

```bash
curl https://api.letta.com/v1/models/embedding \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists all embedding models available. Embedding models are used for vectorizing text (for semantic search in source passages, etc.).

**Response Fields:** Returns a list of embedding model entries, each possibly with:

* **`name`** (string): Embedding model name (e.g., `"text-embedding-ada-002"` or a local model name).
* **`provider`** (string): Provider of the model (e.g., `"openai"`, `"local"`).
* **`dimension`** (integer): The dimensionality of the embedding vectors produced (e.g., 1536).
* **`description`** (string, optional): Description of the embedding model.

These model lists are useful to populate dropdowns in a UI or to validate model choices when configuring agents.

## Blocks API Endpoints (Global Blocks)

*(Not to be confused with **Agent Core Memory Blocks** above, the global Blocks endpoints manage persistent blocks in the system that might be templates or shared across agents.)*

### GET `/v1/blocks/` – List Blocks

```bash
curl https://api.letta.com/v1/blocks/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists all memory blocks in the system that the user has access to. These might include template blocks or global blocks that are not yet attached to an agent.

**Response Fields:** Similar structure to blocks as described in **Retrieve Core Memory Block**: each block with `id`, `value`, `limit`, `name`, `label`, etc. (Global blocks may serve as templates that can be attached to agents.)

### POST `/v1/blocks/` – Create Block

```bash
curl -X POST https://api.letta.com/v1/blocks/ \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "label": "persona", "value": "Helpful assistant persona", "limit": 5000 }'
```

**Description:** Creates a new memory block in the global store (not attached to any specific agent yet). This could be used to define a reusable persona or context block.

**Response Fields:** Returns the created block object with all fields (`id`, etc.) as per a block.

### GET `/v1/blocks/{block_id}` – Retrieve Block *(Global)*

```bash
curl https://api.letta.com/v1/blocks/<block_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Fetches a block by its ID from the global store.

**Response Fields:** Same as **Retrieve Core Memory Block** – the block's content and attributes.

### DELETE `/v1/blocks/{block_id}` – Delete Block

```bash
curl -X DELETE https://api.letta.com/v1/blocks/<block_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Deletes a memory block from the global store. If this block was attached to any agents, those agents' core memory should be updated (the block would effectively be detached or removed for them as well).

**Response Fields:** Success yields empty/confirmation. The block will be gone from **List Blocks**.

### PATCH `/v1/blocks/{block_id}` – Modify Block *(Global)*

```bash
curl -X PATCH https://api.letta.com/v1/blocks/<block_id> \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "value": "New content..." }'
```

**Description:** Updates a global block's fields (value, limit, etc.). If an agent has this block in its core memory, changes would reflect in that agent's memory content as well (assuming it references by ID).

**Response Fields:** Returns the updated block object.

*(Global blocks can be thought of as templates or shared memory pieces that can be attached/detached to agents via the Agents core-memory endpoints.)*

## Tags API Endpoint

Tags provide a way to label and filter objects like agents, tools, etc.

### GET `/v1/tags/` – List Tags

```bash
curl https://api.letta.com/v1/tags/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves all unique tags in use by the user's resources. This can help in building filter UIs or understanding how things are categorized.

**Response Fields:** Returns a list of strings – each string is a tag that exists on at least one object (agent, tool, source, etc.). Example: `["sales", "support", "v1"]`. There is no additional metadata; it's just the set of tag names.

## Batches API Endpoints

**Batches** handle batch operations, such as sending a message to multiple agents or processing many inputs asynchronously.

### GET `/v1/batches/runs` – List Batch Runs

```bash
curl https://api.letta.com/v1/batches/runs \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists all batch jobs (runs) that have been initiated. A batch run might be an operation where multiple agents or multiple messages are processed in parallel.

**Response Fields:** Returns a list of batch run objects. Each object may include:

* **`id`** (string): The batch run ID (likely prefixed `"batch-"` or using the run format) – effectively a job ID.
* **`status`** (string): Current status of the batch (`not_started`, `running`, `completed`, etc.).
* **`created_at`**, **`completed_at`**, etc.: Timing information.
* Possibly **`total_items`**, **`completed_items`** to track progress, and similar fields.
* If available, a list or count of any errors encountered for items in the batch.

This is a high-level overview of all batch processes.

### POST `/v1/batches/messages` – Create Messages Batch

```bash
curl -X POST https://api.letta.com/v1/batches/messages \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "messages": [ {...}, {...} ], "agent_ids": ["agent1","agent2"], "callback_url": "..."}'
```

**Description:** Initiates a batch operation to send messages to multiple agents (or multiple messages to one or more agents). For example, you could broadcast a user query to a list of agents in parallel, or queue up many interactions.

**Response Fields:** Returns a batch run object (similar to the runs described in **Send Message Async**, but for a batch). Key fields:

* **`id`**: Batch run ID.
* **`status`**: Initial status (`not_started` or `running`).
* **`job_type`**: Likely indicates it's a batch.
* **`metadata`** and any `callback_url` fields if provided.

Essentially, you'll use the batch ID to check on progress or retrieve results.

### GET `/v1/batches/runs/{batch_id}` – Retrieve Batch Run

```bash
curl https://api.letta.com/v1/batches/runs/<batch_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Fetches the status and details of a specific batch run by ID.

**Response Fields:** Returns the batch run object with updated fields, such as:

* **`status`**: Current status of the batch (could be `completed` or `failed` once done).
* **`completed_at`**: When the batch finished, if it has.
* **`results`** or **`messages`**: Possibly an array of results for each item (for a messages batch, this could be an array of agent responses or a summary of outcomes).
* **`error_count`** or **`errors`**: If some items failed, there may be information on how many or which ones.

The structure may vary, but essentially you can get the outcome of each item in the batch here.

### PATCH `/v1/batches/runs/{batch_id}` – Cancel Batch Run

```bash
curl -X PATCH https://api.letta.com/v1/batches/runs/<batch_id> \
     -H "Authorization: Bearer <token>" \
     -d '{ "status": "canceled" }'
```

**Description:** Attempts to cancel an ongoing batch run. If the batch is still running and supports cancellation, this will stop processing remaining items.

**Response Fields:** Returns the updated batch run object, with its `status` likely set to `"canceled"` (and any incomplete items aborted). If cancellation was successful, the `completed_at` may be set to the time of cancellation.

### GET `/v1/batches/messages/{batch_id}/messages` – List Batch Messages

```bash
curl https://api.letta.com/v1/batches/messages/<batch_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** After a messages batch run completes, this endpoint can retrieve all the messages/responses generated in that batch.

**Response Fields:** Returns a list of message objects similar to **List Messages**, but aggregated from the batch's activity. For example, if the batch sent a query to 5 agents, this might return 5 assistant message responses (one from each agent). Each message will likely have an associated agent or context so you know which agent's response it is. (The exact format might include the agent\_id alongside each message.)

## Voice API Endpoint

*(This endpoint is specifically for handling voice interactions. It likely uses speech-to-text or text-to-speech in some manner.)*

### POST `/v1/voice/chat-completions` – Create Voice Chat Completion

```bash
curl -X POST https://api.letta.com/v1/voice/chat-completions \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "agent_id": "<agent_id>", "audio": "<base64-encoded-audio>" }'
```

**Description:** Processes a voice input through the agent and returns a completion (response), possibly in audio form. In practice, this endpoint may take an audio clip of a user speaking to the agent, transcribe it, feed it to the agent, then generate a voice/audio response. It is essentially a voice-enabled version of sending a message.

**Request Body:** Would include the `agent_id` (to identify which agent to use) and an audio payload. The audio might be provided as base64 data or via a file upload field (depending on implementation). There could also be parameters like desired voice for the response, language, etc.

**Response Fields:** The output could be:

* **`transcript`** (string): The text transcription of the input audio (what the user said).
* **`response_text`** (string): The agent's text response.
* **`response_audio`** (binary or base64): An audio file (e.g., WAV/MP3) of the agent speaking the response.
* **`message_id`** (string): ID of the generated message, if it's recorded in history.

The exact response may vary. It might return an audio stream or a URL to download the audio. In any case, this endpoint bridges voice and the text-based chat system.

*(Note: Ensure the `Content-Type` is correct when sending audio data; it might be `multipart/form-data` in a real scenario. The example above is illustrative.)*

## Templates API Endpoints (Agent Templates)

*(These endpoints deal with **Agent Templates**, which are predefined configurations of agents.)*

### GET `/v1/templates/` – List Templates *(Cloud-only)*

```bash
curl https://api.letta.com/v1/templates/ \
     -H "Authorization: Bearer <token>"
```

**Description:** *(Letta Cloud only)* Retrieves all agent templates available in the cloud environment. Templates are blueprints for creating agents; each template can include default blocks, tools, etc.

**Response Fields:** Returns an array of template objects. Each template object typically includes:

* **`templateId`** (string): Unique template identifier.
* **`templateName`** (string): Name of the template.
* **`description`** (string, optional): Description of the agent template (what kind of agent it's for).
* **`base_template_id`** (string, optional): If this template inherits or is derived from another base template.
* Possibly fields listing default memory blocks, default tools, etc., that comprise the template (or these may be retrievable via other endpoints).

This endpoint allows users to see what starting templates they have (for example, a "Customer Support Bot" template or "Sales Agent" template), which can then be used to create new agents quickly.

*(Templates are often created from existing agents or via the UI; see the **Create Template From Agent** endpoint under Agents.)*

## Client-Side Access Tokens API Endpoints *(Cloud-only)*

When using Letta Cloud, sometimes you need temporary tokens for client-side (browser or untrusted environment) access, with limited scope.

### POST `/v1/client-tokens` – Create Token *(Cloud-only)*

```bash
curl -X POST https://api.letta.com/v1/client-tokens \
     -H "Authorization: Bearer <token>"
```

**Description:** Generates a new client-side access token. This token can be used in front-end applications to interact with the Letta API without exposing the main API key. Such tokens usually have restricted permissions or expiration.

**Response Fields:** Returns the token details, possibly including:

* **`token`** (string): The token value (e.g., a JWT or random string).
* **`expiration`** (datetime): When the token will expire.
* **`scopes`** or **`permissions`**: What actions the token is allowed to perform (e.g., maybe limited to sending messages to a specific agent).
* **`token_id`** (string): An identifier for the token (for management or revocation).

### DELETE `/v1/client-tokens/{token_id}` – Delete Token *(Cloud-only)*

```bash
curl -X DELETE https://api.letta.com/v1/client-tokens/<token_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Revokes a previously issued client-side token by its ID. After this, the token will no longer be valid for authentication.

**Response Fields:** Typically empty or confirmation of revocation.

*(Use these endpoints to manage transient tokens for web clients. The main API key should remain secret on the backend, while client tokens can be created with minimal privileges for frontend usage.)*

## Projects API Endpoint *(Cloud-only)*

In Letta Cloud, projects can be used to organize agents and resources.

### GET `/v1/projects/` – List Projects *(Cloud-only)*

```bash
curl https://api.letta.com/v1/projects/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Returns all projects the user has in Letta Cloud. Each project can group agents, templates, and other resources.

**Response Fields:** An array of project objects. Each project object likely includes:

* **`id`** (string): Project ID.
* **`name`** (string): Project name.
* **`description`** (string, optional): Project description.
* **`created_at`**, **`updated_at`**, etc.: Timestamps.
* Possibly counts of resources in the project or settings.

Projects help multi-tenant or multi-team usage within a single Letta account.

---

## Runs API Endpoints

*(The Runs endpoints track execution runs, including those from async message sends, batch operations, or possibly continuous agent runs.)*

### GET `/v1/runs/` – List Runs

```bash
curl https://api.letta.com/v1/runs/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists all recent runs (async operations) initiated by the user. This includes one-off runs from **Send Message Async** and any other background processes invoked.

**Response Fields:** Returns a list of run objects. Each run object includes fields similar to those described under **Send Message Async**: `id`, `status`, `created_at`, `completed_at`, `metadata`, etc., and may also include what type of run it was (for example, which agent or batch it was associated with).

### GET `/v1/runs/active` – List Active Runs

```bash
curl https://api.letta.com/v1/runs/active \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists only the runs that are currently in progress (not yet completed). This helps to monitor what tasks are still running.

**Response Fields:** An array of run objects (same structure as above), filtered to those with a `status` like `running` or `not_started`.

### GET `/v1/runs/{run_id}` – Retrieve Run

```bash
curl https://api.letta.com/v1/runs/<run_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Retrieves the details of a specific run by ID. Use this to check the result or status of an async operation (like a message or batch).

**Response Fields:** The run object with all its details. If the run is completed and produced a result, that result might be included here or via a different endpoint depending on the run type. For instance, an async message run might have the agent's response in a field like `result_message` or reference to a message ID. A batch run would likely direct you to **Batch Messages** as we saw. Common fields: `status`, timing, etc., as described before for runs.

### DELETE `/v1/runs/{run_id}` – Delete Run

```bash
curl -X DELETE https://api.letta.com/v1/runs/<run_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Removes a run record. This is mostly for cleanup; deleting a run does not undo whatever actions it performed, it just deletes the log of that run.

**Response Fields:** Empty on success. The run will no longer appear in list endpoints.

*(Attempting to delete an active run might either cancel it or be disallowed; ensure the run is completed or canceled before deletion.)*

## Steps API Endpoints

"Steps" refer to internal reasoning or action steps an agent takes during processing (especially if using a ReAct-like chain of thought). These endpoints let you inspect those steps.

### GET `/v1/steps/` – List Steps

```bash
curl https://api.letta.com/v1/steps/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists recent reasoning steps across runs. This is more of a debugging or auditing feature to see how agents are thinking or what tools they called in each step.

**Response Fields:** A list of step objects. Fields in a step might include:

* **`id`** (string): Step ID.
* **`run_id`** (string): The run (or message) ID this step is part of.
* **`agent_id`** (string): The agent executing this step.
* **`type`** (string): Step type (e.g., "thought", "tool\_call", "tool\_return").
* **`input`** (object/string): The input to this step (e.g., the thought text or tool name and args).
* **`output`** (object/string): The output of this step (e.g., the result of a tool, or the next thought).
* **`timestamp`**: When it happened.

### GET `/v1/steps/{step_id}` – Retrieve Step

```bash
curl https://api.letta.com/v1/steps/<step_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Fetches a specific step's details.

**Response Fields:** The step object (fields as above: id, type, input, output, etc. for that single step).

## Health API Endpoint

### GET `/v1/health` – Health Check

```bash
curl https://api.letta.com/v1/health \
     -H "Authorization: Bearer <token>"
```

**Description:** A simple endpoint to check if the Letta server is running and accessible. Often returns a status or version info.

**Response Fields:** Typically returns something like: `{ "status": "ok" }` or a similar heartbeat. It might also include version numbers of the server. The primary purpose is operational (for load balancers or uptime monitors to ping the service).

## Providers API Endpoints

Providers represent external AI providers (like OpenAI, AI21, Azure, etc.) configured for use.

### GET `/v1/providers/` – List Providers

```bash
curl https://api.letta.com/v1/providers/ \
     -H "Authorization: Bearer <token>"
```

**Description:** Lists all model providers configured in Letta (and possibly their status). This helps know which external services are set up.

**Response Fields:** Returns an array of provider objects, each possibly including:

* **`id`** (string): Provider ID or name (e.g., `"openai"`, `"azure_openai"`).
* **`category`** (string): Category of provider (like `"base"` for base LLMs, `"embedding"` for embedding providers, etc.).
* **`auth_status`** (string): Whether authentication is properly set up (e.g., `"valid"`, `"invalid_key"`).
* **`details`**: May include fields like the API key (masked), default model, etc., depending on provider type.

### POST `/v1/providers/` – Create Provider

```bash
curl -X POST https://api.letta.com/v1/providers/ \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "provider": "openai", "api_key": "sk-xxxx", "category": "base" }'
```

**Description:** Adds a new provider configuration (for example, adding your API key for a new provider). This might be used to set up a connection to a service like OpenAI or Cohere by supplying credentials.

**Response Fields:** Returns the created provider object (or updated, if it was an upsert). You should see the provider listed in **List Providers** after this, with any non-secret fields visible (the API key might not be returned in plain text for security).

### DELETE `/v1/providers/{provider_id}` – Delete Provider

```bash
curl -X DELETE https://api.letta.com/v1/providers/<provider_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Removes a provider configuration. Agents using this provider might no longer function unless another provider is available for their models.

**Response Fields:** Typically confirmation or empty. The provider will vanish from **List Providers**.

### PATCH `/v1/providers/{provider_id}` – Modify Provider

```bash
curl -X PATCH https://api.letta.com/v1/providers/<provider_id> \
     -H "Authorization: Bearer <token>" \
     -H "Content-Type: application/json" \
     -d '{ "api_key": "new-key-value" }'
```

**Description:** Updates settings for an existing provider (for example, updating an expired API key, or changing the default model endpoint).

**Response Fields:** Returns the updated provider object. Check that the fields changed (though API keys might be write-only, the response may just indicate success).

### GET `/v1/providers/check/{provider_id}` – Check Provider

```bash
curl https://api.letta.com/v1/providers/check/<provider_id> \
     -H "Authorization: Bearer <token>"
```

**Description:** Performs a health check or validation of the given provider configuration. For instance, it might attempt a test API call to verify that the credentials are correct and the service is reachable.

**Response Fields:** Likely returns a status object, e.g.: `{ "status": "ok" }` if the provider is configured correctly, or details of any error (like "invalid API key" or network issues).

This helps quickly debug provider setup issues.

---

Each endpoint above plays a role in Letta's ecosystem, from managing agents and their memories to integrating external tools and providers. This documentation should enable a development team to implement a PHP SDK with full coverage, as it details the requests and responses for every documented API endpoint on the Letta platform. Ensure to handle authentication (the `Authorization: Bearer <token>` header) for all calls, and handle optional fields or cloud-only features appropriately.

---

## License

This documentation is licensed under CC-BY-SA 4.0 (Creative Commons Attribution-ShareAlike 4.0 International).
