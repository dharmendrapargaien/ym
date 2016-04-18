<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerBusiness extends Model
{
    use PimpableTtaiy;
    use SoftDeletes;

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
	protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}