<?php

namespace App\SDK\Services\Ollama;

class Ollama implements \App\SDK\Ports\LLMInterface
{
    private OllamaClient $ollamaClient;

    public static function client(string $host = 'http://localhost:11434'): Ollama
    {
        return new self($host);
    }

    private function __construct(string $host)
    {
        $this->ollamaClient = new OllamaClient($host);
    }

    public function chat()
    {
        return new Chat($this->ollamaClient);
    }

}
