<?php

namespace App\Http\Requests\Api\User;

class SignUpRequest extends \App\Http\Requests\Request
{
    /**
     * Basic rules array
     * @var array
     */
    public $rules = [
        'email' => 'required|email|unique:users,email',
        'password' => 'required_without:facebook_id',
        'username' => 'required|unique:users,username',
        'facebook_id' => 'unique:users,facebook_id'
    ];

    /**
     * Function to create rules dynamically
     * @return array [rules array]
     */
    public function rules(){
        
        return $this->rules;
    }
}