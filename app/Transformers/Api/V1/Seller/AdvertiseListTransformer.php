<?php

namespace App\Transformers\Api\V1\Seller;

use League\Fractal;

class AdvertiseListTransformer extends Fractal\TransformerAbstract
{
    public function transform($seller)
    {
        return $seller;
    }
}