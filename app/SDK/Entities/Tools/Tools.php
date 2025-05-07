<?php

namespace App\SDK\Entities\Tools;

class Tools
{
    public static function get(): array
    {
        $addRecipeTool = new AddRecipeTool();

        return [
            $addRecipeTool->build(),
        ];
    }
}
