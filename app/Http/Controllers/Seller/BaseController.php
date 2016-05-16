<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public $inputs = [];

    public $bladeContent = [];

	public function __construct()
	{
		$this->inputs = collect(request()->all());
	}
}
