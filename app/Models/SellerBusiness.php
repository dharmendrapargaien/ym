<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerBusiness extends Model
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
     * one seller have multiple business
     * @return [type] [description]
     */
    public function business()
    {
        return $this->belongsTo('App\Models\Business');
    }

    /**
     * seler's one business have multiple adverise
     * @return [type] [description]
     */
    public function advertises()
    {
        return $this->hasMany('App\Models\SellerBusinessAdvertise');
    }
}