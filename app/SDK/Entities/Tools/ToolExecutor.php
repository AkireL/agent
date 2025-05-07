<?php

namespace App\SDK\Entities\Tools;

use Exception;

class ToolExecutor
{
    private array $toolsName = [
        RecipesToolSchema::TOOL_NAME => AddRecipeCall::class,
    ];

    public function __construct(private array $params) {}

    public function execute(): string
    {
        $name = $this->params['name'];
        $arguments = $this->params['arguments'];

        echo "Tool name: $name\n";
        echo "Tool arguments: " . json_encode($arguments) . "\n";

        try {
            if (!array_key_exists($name, $this->toolsName)) {
                throw new \InvalidArgumentException("Tool $name not found");
            }

            $toolClass = new $this->toolsName[$name]();
            $toolClass->validateParams($arguments);

            $response = $toolClass->call();

            if (array_key_exists('status', $response) && in_array($response['status'], [200, 201])) {
                return $response['message'];
            }

            return "Error: " . $response['message'];
        } catch (Exception $ex) {
            return "Error: " . $ex->getMessage();
        }
    }
}
