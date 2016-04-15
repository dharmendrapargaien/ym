<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
    */
    protected $hidden = ['password', 'remember_token'];
	
	protected $dates = ['created_at', 'updated_at'];

    /**
     * get seller data
     * @param  string $email
     * @return 
     */
    public function getSellerData($email)
    {
        return $this->where(function($query) use($email){
            
            if (is_numeric($email)) {

                $query->wherePhoneNo($email);
            } else {

                $query->whereEmail($email);
            }
        })->first();
    }

    /**
     * get seller data
     * @param  string $email
     * @return 
     */
    public function getSellerConfirmationData($email, $confiration_code)
    {
        return $this->where(function($query) use($email){
            
            if (is_numeric($email)) {

                $query->wherePhoneNo($email);
            } else {

                $query->whereEmail($email);
            }
        })->whereConfirmationCode($confiration_code)->first();
    }
}