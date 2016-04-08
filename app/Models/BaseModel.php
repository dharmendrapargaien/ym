<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends \Eloquent
{
    protected $dates = ['created_at', 'updated_at'];
}
