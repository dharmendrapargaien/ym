<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Buyer extends Authenticatable
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
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];


    /**
     * get seller data
     * @param  string $email
     * @return 
     */
    public function getBuyerData($email)
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
    public function getBuyerConfirmationData($email, $confiration_code)
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
