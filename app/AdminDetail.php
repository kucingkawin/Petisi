<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminDetail extends Model
{
    protected $table = 'admin_detail';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];
}
