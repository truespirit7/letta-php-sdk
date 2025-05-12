# letta-php-sdk
PHP SDK for Letta AI Agentic Framework.

## Integration Test Setup

To run integration tests against a live Letta server, you must create a `.env` file in the `tests/integration/` directory with the following variables:

```
LETTA_API_URL=your_letta_api_url
LETTA_API_TOKEN=your_letta_api_token
LETTA_TEST_AGENT_ID=your_test_agent_id
```

A `.env.example` file is provided as a template. **Never commit your real `.env` file or secrets to version control.**
