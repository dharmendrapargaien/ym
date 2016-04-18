<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerBusinessAddress extends Model
{
    /**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $guarded = ['id', 'created_at', 'updated_at'];
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
	protected $dates = ['created_at', 'updated_at'];
}
