<?php

namespace App\SDK\Services\Ollama;

class Ollama implements \App\SDK\Ports\LLMInterface
{
    private OllamaClient $ollamaClient;
    private string $model = 'qwen3';
    private string $systemPrompt;
    private array $tools = [];

    private function __construct(string $host)
    {
        $this->ollamaClient = new OllamaClient($host);
    }

    public static function client(string $host = 'host.docker.internal:11434'): Ollama
    {
        return new self($host);
    }

    public function setModel($model): self
    {
        $this->model = $model;
        return $this;
    }

    public function setSystemPrompt($systemPrompt): self
    {
        $this->systemPrompt = $systemPrompt;
        return $this;
    }

    public function setTools(array $tools): self
    {
        $this->tools = $tools;
        return $this;
    }

    public function chat()
    {
        return new Chat(
            $this->ollamaClient,
            $this->model,
            $this->systemPrompt,
            $this->tools
        );
    }

}
