<?php

namespace App\Transformers\Api\V1\Seller;

use League\Fractal;

class SellerTransformer extends Fractal\TransformerAbstract
{
    public function transform($seller)
    {
        return [
            'id'         => (int)$seller->id,
            'email'      => $seller->email,
            'name'       => $seller->name,
            'created_at' => $seller->created_at,
            'updated_at' => $seller->updated_at,
        ];
    }
}