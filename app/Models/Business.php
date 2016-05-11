<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    
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


	/**
     * The sellers that belong to the business.
     */
    public function sellers()
    {

        return $this->belongsToMany('App\Seller', 'seller_businesses');
    }
}