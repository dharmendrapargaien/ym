<?php

namespace App\Http\Requests\Api\V1\Buyer;

class SignUpRequest extends \App\Http\Requests\Request
{
    /**
     * Basic rules array
     * @var array
     */
    public $rules = [
        'name'     => 'required|max:50',
        'email'    => 'required|email|max:255|unique:buyers,email',
        'password' => 'required',
        'phone_no' => 'required|unique:buyers,phone_no',
    ];

    /**
     * Function to create rules dynamically
     * @return array [rules array]
     */
    public function rules(){
        
        return $this->rules;
    }
}