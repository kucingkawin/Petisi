<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomentarPetisi extends Model
{
    protected $table = 'komentar_petisi';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'petisi_id', 'user_detail_id', 'komentar'
    ];
}
