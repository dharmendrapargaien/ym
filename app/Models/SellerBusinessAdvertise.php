<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerBusinessAdvertise extends Model
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
	 * One advertise have multiple images
	 * @return [type] [description]
	 */
	public function images()
	{
		return $this->hasMany('App\Models\SellerAdvertiseImage')->orderBy('featured_image', 'desc');
	}

	/**
	 * fetch seller business advertise
	 * @param  integer $seller_business_id
	 * @return array
	 */
	public function getAdverise($seller_business_id)
	{

		return $this->select('id','seller_business_id','description','start_date', 'end_date', 'advertise_type')->whereSellerBusinessId($seller_business_id)->with('images')->orderBy('created_at', 'desc')->get();
	}

}
