<?php

namespace App\SDK\Entities\Tools;

class AddRecipeCall
{
    private array $params = [];

    public function validateParams(array $params)
    {
        if (!isset($params['schedule_at']) || empty($params['schedule_at'])) {
            throw new \InvalidArgumentException('The "day" parameter is required.');
        }

        if (!isset($params['ingredients']) || empty($params['ingredients'])) {
            throw new \InvalidArgumentException('The "ingredients" parameter is required.');
        }

        $this->params = $params;

        return true;
    }

    public function call()
    {
        $day = $this->params['schedule_at'];
        $ingredients = $this->params['ingredients'];
        $title = $this->params['title'];
        $preparation = $this->params['preparation'];

        return [
            'status' => 201,
            'message' => "Recipe added for $day with ingredients: $ingredients; title: $title; preparation: $preparation"
        ];
    }
}
