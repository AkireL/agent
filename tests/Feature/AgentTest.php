<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Thread;
use App\SDK\Entities\Tools\Tools;
use App\SDK\Services\Ollama\Ollama;
use App\SDK\UseCases\Agent\Agent;
use Tests\TestCase;

class AgentTest extends TestCase
{

    /**
     * @test
     */
    public function it_call_agent(): void
    {
        $client = Client::factory()->create();

        $thread = Thread::factory()->create([
            'client_id' => $client->getKey(),
        ]);

        \App\Models\Message::factory()->create([
            'thread_id' => $thread->getKey(),
            'role' => 'user',
            'content' => [
                'content' => 'Hello, how are you?',
            ],
        ]);

        \App\Models\Message::factory()->create([
            'thread_id' => $thread->getKey(),
            'role' => 'assistant',
            'content' => [
                'content' => 'bien gracias. En que puedo ayudarte?',
            ],
        ]);

        \App\Models\Message::factory()->create([
            'thread_id' => $thread->getKey(),
            'role' => 'user',
            'content' => [
                'content' => "ok, entonces dime de que trata Kusuriya no Hitorigoto? o la boticaria",
            ],
        ]);

        \App\Models\Message::factory()->create([
            'thread_id' => $thread->getKey(),
            'role' => 'assistant',
            'content' => [
                'content' => "es una novela ligera japonesa trata de una chica huerfana que la adopta un unoco y que fue criada por unas cortezanas de un burdel. Ella aprendío medicina de su padre.",
            ]
        ]);

        $systemPrompt = 'You are a helpful assistant.';

        $llm = Ollama::client()
            ->setSystemPrompt($systemPrompt)
            ->setModel('qwen3')
            ->setTools(Tools::get());

        $agent = new Agent(
            $client->getKey(),
            $llm,
        );

        $content = $agent->run('suena interesante, dime ¿Qué más sabes?', $thread->getKey());

        var_dump($content);

    }
}
