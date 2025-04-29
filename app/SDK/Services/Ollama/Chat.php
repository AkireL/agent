<?php

namespace App\SDK\Services\Ollama;

class Chat
{
    private OllamaClient $ollamaClient;
    private string $model;
    private string $systemPrompt;

    public function __construct(OllamaClient $ollamaClient)
    {
        $this->ollamaClient = $ollamaClient;
    }

    public function create(array $parameters)
    {
        return $this->ollamaClient->post('chat', $parameters, false);
    }
}
