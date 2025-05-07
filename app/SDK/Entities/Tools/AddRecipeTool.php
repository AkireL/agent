<?php

namespace App\SDK\Entities\Tools;

class RecipesToolSchema
{
    const TOOL_NAME = "add_recipe";

    private $properties = [];
    private $required = [];
    private string $description = 'Create a recipe for a specific day';


    public function __construct()
    {
        $this->properties = [];
    }

    public function addIngredients(bool $isRequired = true): self
    {
        $this->properties['ingredients'] = [
            'type' => 'string',
            'description' => 'ingredients for the recipe'
        ];

        if ($isRequired) {
            $this->required[] = 'ingredients';
        }

        return $this;
    }

    public function addScheduleAt(bool $isRequired = true): self
    {
        $this->properties['schedule_at'] = [
            'type' => 'string',
            'description' => 'date of the week (dd-mm-yyyy)'
        ];

        if ($isRequired) {
            $this->required[] = 'schedule_at';
        }
        return $this;
    }

    public function addTitle(bool $isRequired = true): self
    {
        $this->properties['title'] = [
            'type' => 'string',
            'description' => 'title of the recipe'
        ];

        if ($isRequired) {
            $this->required[] = 'title';
        }

        return $this;
    }

    public function addPreparation(bool $isRequired = true)
    {
        $this->properties['preparation'] = [
            'type' => 'string',
            'description' => 'preparation steps'
        ];
        if ($isRequired) {
            $this->required[] = 'preparation';
        }

        return $this;
    }

    public function getProperties(): array
    {
        return [
            'type' => 'function',
            'function' => [
                'name' => self::TOOL_NAME,
                'description' => $this->description,
                'parameters' => [
                    'type' => 'object',
                    'properties' => $this->properties,
                    'required' => $this->required,
                ],
            ],
        ];
    }
}

class AddRecipeTool
{
    public function build(): array
    {
        $toolInputSchema = new RecipesToolSchema();
        $toolInputSchema
            ->addIngredients(true)
            ->addScheduleAt(true)
            ->addTitle()
            ->addPreparation();

        var_dump($toolInputSchema->getProperties());
        return $toolInputSchema->getProperties();
    }
}
