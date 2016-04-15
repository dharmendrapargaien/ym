<?php

namespace App\Transformers\Api\V1\Seller;

use League\Fractal;

class AuthenticateTransformer extends Fractal\TransformerAbstract
{
    public function transform($apiKey)
    {
        return $apiKey;
    }
}