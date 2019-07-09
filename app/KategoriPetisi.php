<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriPetisi extends Model
{
    protected $table = 'kategori_petisi';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'deskripsi'
    ];
}
