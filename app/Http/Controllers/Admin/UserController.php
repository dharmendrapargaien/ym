<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Admin\BaseController;
use App\Models\User;

class UserController extends BaseController
{
	
    public function index()
    {
    	return "Ok";
    }

    
}
