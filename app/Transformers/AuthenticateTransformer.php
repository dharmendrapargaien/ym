<?php

namespace App\Transformers;

use League\Fractal;

class AuthenticateTransformer extends Fractal\TransformerAbstract
{
    public function transform($apiKey)
    {
        return [
            'access_token' => $apiKey["access_token"],
            'token_type'   => $apiKey['token_type'],
            'refresh_token' => $apiKey['refresh_token'], 
            'user_id' => auth()->user()->id,
            'email' => auth()->user()->email,
            'created_at' => auth()->user()->created_at,
            'updated_at' => auth()->user()->updated_at,
        ];
    }
}