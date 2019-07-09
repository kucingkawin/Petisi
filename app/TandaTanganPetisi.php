<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TandaTanganPetisi extends Model
{
    protected $table = 'tanda_tangan_petisi';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'petisi_id', 'user_detail_id'
    ];
}
