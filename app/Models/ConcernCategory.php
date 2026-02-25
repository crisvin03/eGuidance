<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConcernCategory extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];
}
