<?php

namespace App\Http\Requests\Api\User;

class AuthenticationRequest extends \App\Http\Requests\Request
{ 
    /**
     * Basic rules array
     * @var array
     */
    public $rules = [
        'email' => 'required|email|exists:users,email',
        'password' => 'required',
        'client_id' => 'required|exists:oauth_clients,id',
        'client_secret' => 'required|exists:oauth_clients,secret'
    ];

    /**
     * Function to create rules dynamically
     * @return array [rules array]
     */
    public function rules(){
        
        return $this->rules;
    }
}