<?php

namespace App\SDK\Services\Ollama;

class Chat
{
    private OllamaClient $ollamaClient;
    private string $model;
    private string $systemPrompt;
    private array $tools;

    public function __construct(OllamaClient $ollamaClient, string $model, string $systemPrompt = '', array $tools)
    {
        $this->model = $model;
        $this->systemPrompt = $systemPrompt;
        $this->tools = $tools;
        $this->ollamaClient = $ollamaClient;
    }

    public function create(array $messages)
    {
        $parameters = [];

        $parameters['model'] = $this->model;

        if (! empty($this->tools)) {
            $parameters['tools'] = $this->tools;
        }

        $parameters["messages"] = array_merge([
            [
                'role' => "system",
                'content' => $this->systemPrompt,
            ],
        ],
        $messages);

        return $this->ollamaClient->post('chat', $parameters, false);
    }
}
