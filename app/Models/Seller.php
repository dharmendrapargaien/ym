<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Authenticatable
{
    use SoftDeletes;

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
     * The businesses that belong to the seller.
     */
    public function businesses()
    {

        return $this->belongsToMany('App\Models\Business', 'seller_businesses');
    }

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