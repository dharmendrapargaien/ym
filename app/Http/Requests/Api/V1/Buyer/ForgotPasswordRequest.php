<?php

namespace App\Http\Requests\Api\V1\Buyer;

class ForgotPasswordRequest extends \App\Http\Requests\Request
{
    /**
     * Basic rules array
     * @var array
     */
    public $rules = [
        'email' => 'required|email|exists:buyers,email',
    ];

    /**
     * Function to create rules dynamically
     * @return array [rules array]
     */
    public function rules(){
        return $this->rules;
    }

}