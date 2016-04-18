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


}
