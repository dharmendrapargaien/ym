<?php

namespace App\Transformers;

use League\Fractal;

class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform($user)
    {
        return [
            'id' => (int)$user->id,
            'email' => $user->email,
            'name' => $user->name,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }
}