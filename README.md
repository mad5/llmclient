# LLM Client (PHP)

A simple and flexible PHP client for interacting with Large Language Models (LLMs), supporting both local **Ollama** instances and **OpenAI's** API.

## Objective

The objective of this project is to provide a lightweight, easy-to-use interface for PHP applications to communicate with various LLM providers. It abstracts the underlying API calls, allowing for seamless switching between local and remote models through a unified configuration.

## Features

- **Ollama Integration**: Connect to locally hosted models (e.g., Llama 3, Gemma) via the Ollama API.
- **OpenAI Integration**: Use OpenAI's chat completion models (e.g., GPT-4o).
- **Unified Interface**: `AiClient.php` provides a consistent way to initialize and use different providers.
- **Helper Utilities**: Includes tools for HTML content extraction, JSON cleaning, and logging.

## Installation

1. Clone the repository to your project directory.
2. Ensure you have PHP installed (7.4+ recommended).
3. Copy the example configuration file:
   ```bash
   cp config.example.php config.php
   ```

## Configuration

Edit `config.php` to suit your environment.

### Ollama Configuration (Local)
```php
$config = [
    "llm" => "ollama",
    "ollama_url" => "http://localhost:11434",
    "ollama_model" => "gemma3:12b",
    // ... other settings
];
```

### OpenAI Configuration (Remote)
```php
$config = [
    "llm" => "openai",
    "openai_key" => "your-sk-api-key",
    "openai_model" => "gpt-4o",
    // ... other settings
];
```

## Usage

### Basic Example

You can initialize the client using the `initAiAgent` function and start generating responses.

```php
<?php
$config = include 'config.php';
require_once 'ai/AiClient.php';

// Initialize the client based on config.php
$client = initAiAgent($config);

// Generate a response
$response = $client->generate("Tell me a short joke about PHP.");

// Get the response text
echo $client->getResponseText();
```

### Advanced Usage with System Context

```php
$systemContext = "You are a helpful assistant specialized in PHP programming.";
$prompt = "How do I use array_map?";

$response = $client->generate($prompt, $systemContext);
echo $client->getResponseText();
```

### Handling Multi-turn Conversations

The client can maintain context for follow-up questions.

```php
// First turn
$client->generate("My name is Junie.");

// Second turn with context from the previous response
$context = $client->getResponseContext();
$client->generate("What is my name?", null, $context);

echo $client->getResponseText(); // Should output: "Your name is Junie."
```

## Project Structure

- `ai/AiClient.php`: The factory to create `OllamaClient` or `OpenAIClient`.
- `ai/OllamaClient.php`: Implementation for the Ollama API.
- `ai/OpenAIClient.php`: Implementation for the OpenAI API.
- `ai/AiHelper.php`: Collection of helper functions for text processing, logging, and more.
- `config.php`: Your local configuration file (ignored by git).
- `test.php`: A simple test script to verify your connection.

## Helper Functions (`AiHelper.php`)

- `fetchPageText($url)`: Fetches a URL and extracts the main text content, stripping HTML tags and scripts.
- `cleanContentWithAi($rawText)`: Uses the AI to clean extracted web content (removes navigation, ads, etc.).
- `getJsonWithoutFence($text)`: Extracts JSON from a string that might contain markdown code blocks.
- `sendlog($msg)`: Logs messages to `storage/log/ai.log`.

## License

This project is open-source. Feel free to use and modify it for your needs.
