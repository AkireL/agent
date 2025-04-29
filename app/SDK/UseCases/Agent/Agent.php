<?php

namespace App\SDK\UseCases\Agent;
use App\SDK\Infrastructure\EloquentMessage;
use App\SDK\Infrastructure\EloquentRunner;
use App\SDK\Infrastructure\EloquentRunnerState;
use App\SDK\Infrastructure\EloquentThread;
use App\SDK\Ports\MessageRepositoryInterface;
use App\SDK\Ports\RunnerRepositoryInterface;
use App\SDK\Ports\RunnerStateRepositoryInterface;
use App\SDK\Ports\ThreadRepositoryInterface;
use App\SDK\Services\Ollama\Ollama;

class Agent
{
    private $llm;
    private $params = [];
    private ThreadRepositoryInterface $threadRepository;
    private RunnerRepositoryInterface $runnerRepository;
    private RunnerStateRepositoryInterface $runnerStateRepository;
    private MessageRepositoryInterface $messageRepository;

    public function __construct(private int $clientId, private string $systemPrompt, private $tools)
    {
        $this->llm = (Ollama::client());
        $this->params = [
            'model' => 'llama2',
            'system_prompt' => [
                [
                    'role' => 'system',
                    'content' => $this->systemPrompt,
                ],
            ],
            'tools' => $this->tools,
        ];

        $this->threadRepository = new EloquentThread();
        $this->runnerRepository = new EloquentRunner();
        $this->runnerStateRepository = new EloquentRunnerState();
        $this->messageRepository = new EloquentMessage();
    }

    public function setModel($model): self
    {
        $this->params['model'] = $model;

        return $this;
    }

    public function run($message, $threadId=null)
    {
        // TODO: Create test
        $thread = $this->threadRepository->createOrRetrieve($this->clientId, $threadId);

        $message = $this->messageRepository->create(
                $thread->getId(),
                'user',
                [
                    'content' => $message,
                ]
            );

        $runnerId = $this->runnerRepository->getOrCreate($thread->getId(), null);

        $messages = $this->messageRepository->listMessages($thread->getId());


        $this->runnerStateRepository->create(
            $runnerId,
            $message->getId()
        );

        $response = $this->llm->chat()->create([
            'model' => $this->params['model'],
            'messages' => array_merge(
                [
                    'role' => $this->params['system_prompt'][0]['role'],
                    'content' => $this->params['system_prompt'][0]['content'],
                ],
                $messages,
            ),
            'tools' => $this->params['tools'],
        ]);

        if ($response['message']['tool_calls']) {
            return $this->executeTool(
                $thread->getId(),
                $runnerId,
                $response
            );
        }

        return $this->getSimpleResponse(
            $thread->getId(),
            $runnerId,
            $response
        );
    }

    private function getSimpleResponse($threadId, $runnerId, array $response): string
    {
        $message = $this->messageRepository->create(
            $threadId,
            'assistant',
            [
                'content' => $response['message']['content'],
            ]
        );

        $this->runnerStateRepository->create(
            $runnerId,
            $message->getId(),
            'completed'
        );

        return $response['message']['content'];
    }

    private function executeTool($threadId, $runnerId, array $response): string
    {
        $message = $this->messageRepository->create(
            $threadId,
            'assistant',
            [
                'content' => $response['message']['tool_calls'],
            ]
        );

        $this->runnerStateRepository->create(
            $runnerId,
            $message->getId(),
            'required_action'
        );

        // TODO: Execute tool
        $responseTool = "";

        $message = $this->messageRepository->create(
            $threadId,
            'assistant',
            [
                'content' => $responseTool,
            ]
        );

        $this->runnerStateRepository->create(
            $runnerId,
            $message->getId(),
            'in_progress'
        );

        $messages = $this->messageRepository->listMessages($threadId);

        $response = $this->llm->chat()->create([
            'model' => $this->params['model'],
            'messages' => array_merge(
                [
                    'role' => $this->params['system_prompt'][0]['role'],
                    'content' => $this->params['system_prompt'][0]['content'],
                ],
                $messages
            ),
            'tools' => $this->params['tools'],
        ]);

        if ($response['message']['tool_calls']) {
            return $this->executeTool($threadId, $runnerId, $response);
        }

        return $this->getSimpleResponse(
                $threadId,
                $runnerId,
                $response
            );
    }
}
