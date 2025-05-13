import json

# Letta-compatible function code with simple docstring and manual schema
function_code = (
    "def add(a: int, b: int) -> int:\n"
    "    \"\"\"\n"
    "    Add two numbers.\n"
    "    Args:\n"
    "        a (int): First number.\n"
    "        b (int): Second number.\n"
    "    Returns:\n"
    "        int: The sum.\n"
    "    \"\"\"\n"
    "    return a + b\n"
    "\n"
    "json_schema = {\n"
    "    'type': 'object',\n"
    "    'properties': {\n"
    "        'a': {'type': 'integer', 'description': 'First number.'},\n"
    "        'b': {'type': 'integer', 'description': 'Second number.'}\n"
    "    },\n"
    "    'required': ['a', 'b']\n"
    "}\n"
)

payload = {
    "name": "Add Two Numbers",
    "tool_type": "function",
    "source_code": function_code
}

with open("temp_tool.json", "w", encoding="utf-8") as f:
    json.dump(payload, f, ensure_ascii=False)

# Generate a minimal valid PDF file for upload testing
pdf_bytes = b'%PDF-1.1\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\n3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 200 200]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>endobj\n4 0 obj<</Length 44>>stream\nBT/F1 24 Tf 100 100 Td (Hello PDF) Tj ET\nendstream\nendobj\n5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj\nxref\n0 6\n0000000000 65535 f\n0000000010 00000 n\n0000000079 00000 n\n0000000178 00000 n\n0000000334 00000 n\n0000000421 00000 n\ntrailer<</Size 6/Root 1 0 R>>\nstartxref\n497\n%%EOF\n'
with open('temp_test.pdf', 'wb') as f:
    f.write(pdf_bytes) 