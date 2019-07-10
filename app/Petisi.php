<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Petisi extends Model
{
    protected $table = 'petisi';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'kategori_petisi_id', 'judul', 'konten', 'gambar'
    ];

    public static function viewTable($dapatkanBanyak = false)
    {
        //SELECT petisi.id, petisi.user_id, users.name as user_name, users.role_id as user_role_id, petisi.kategori_petisi_id, kategori_petisi.nama as nama_kategori_petisi, petisi.konten, petisi.gambar, petisi.created_at, petisi.updated_at FROM petisi inner join users on petisi.user_id = users.id inner join kategori_petisi on petisi.kategori_petisi_id = kategori_petisi.id
        $hasil = DB::table('petisi');

        if(!$dapatkanBanyak)
            $hasil = $hasil->select('petisi.id', 'petisi.user_id', DB::raw('users.name as user_name'), 'petisi.kategori_petisi_id', DB::raw('kategori_petisi.nama as nama_kategori_petisi'), 'petisi.judul', 'petisi.konten', 'petisi.gambar', 'petisi.created_at', 'petisi.updated_at');
        else
            $hasil = $hasil->select(DB::raw("COUNT(*) as nilai"));

        return $hasil->join('users', 'petisi.user_id', '=', 'users.id')
                     ->join('kategori_petisi', 'petisi.kategori_petisi_id', '=', 'kategori_petisi.id');
    }

    public static function viewDitandatanganiTable($dapatkanBanyak = false)
    {
        $hasil = DB::table('tanda_tangan_petisi');

        if(!$dapatkanBanyak)
            $hasil = $hasil->select('tanda_tangan_petisi.id', 'tanda_tangan_petisi.petisi_id', 'petisi.kategori_petisi_id', DB::raw('kategori_petisi.nama as nama_kategori_petisi'), 'petisi.judul', 'petisi.konten', 'petisi.gambar', 'tanda_tangan_petisi.user_detail_id', 'tanda_tangan_petisi.created_at', 'tanda_tangan_petisi.updated_at');
        else
            $hasil = $hasil->select(DB::raw("COUNT(*) as nilai"));

        return $hasil->join('petisi', 'tanda_tangan_petisi.petisi_id', '=', 'petisi.id')
                     ->join('kategori_petisi', 'petisi.kategori_petisi_id', '=', 'kategori_petisi.id');
    }

    public static function viewDikomentariTable($dapatkanBanyak = false)
    {
        $hasil = DB::table('komentar_petisi');

        if(!$dapatkanBanyak)
            $hasil = $hasil->select('komentar_petisi.id', 'komentar_petisi.petisi_id', 'petisi.kategori_petisi_id', DB::raw('kategori_petisi.nama as nama_kategori_petisi'), 'petisi.judul', 'petisi.konten', 'petisi.gambar', 'komentar_petisi.user_detail_id', 'komentar_petisi.komentar', DB::raw('users.name as user_name'), 'komentar_petisi.created_at', 'komentar_petisi.updated_at');
        else
            $hasil = $hasil->select(DB::raw("COUNT(*) as nilai"));
        
        return $hasil->join('petisi', 'komentar_petisi.petisi_id', '=', 'petisi.id')
                     ->join('kategori_petisi', 'petisi.kategori_petisi_id', '=', 'kategori_petisi.id')  
                     ->join('user_detail', 'komentar_petisi.user_detail_id', 'user_detail.id')
                     ->join('users', 'user_detail.user_id', 'users.id'); 
    }

    public static function viewKomentatorTerbanyakTable()
    {
        //SELECT users.name as user_name, COUNT(komentar_petisi.petisi_id) as banyak_komentar FROM user_detail left join komentar_petisi on user_detail.id = komentar_petisi.user_detail_id inner join users on user_detail.user_id = users.id group by user_detail.id
        return DB::table('user_detail')
                 ->select(DB::raw('users.name as username'), DB::raw('COUNT(komentar_petisi.petisi_id) as banyak_komentar'))
                 ->leftJoin('komentar_petisi', 'user_detail.id', '=', 'komentar_petisi.user_detail_id')
                 ->join('users', 'user_detail.user_id', '=', 'users.id')
                 ->orderBy('banyak_komentar', 'desc')
                 ->groupBy('user_detail.id');
    }

    public static function viewPetisiTerbanyakTable()
    {
        //SELECT petisi.judul as judul, COUNT(tanda_tangan_petisi.petisi_id) as banyak_tanda_tangan_petisi FROM `petisi` left outer join `tanda_tangan_petisi` on petisi.id = tanda_tangan_petisi.petisi_id group by tanda_tangan_petisi.petisi_id
        return DB::table('petisi')
                 ->select(DB::raw('petisi.judul as judul'), DB::raw('COUNT(tanda_tangan_petisi.petisi_id) as banyak_tanda_tangan_petisi'))
                 ->leftJoin('tanda_tangan_petisi', 'petisi.id', '=', 'tanda_tangan_petisi.petisi_id')
                 ->orderBy('banyak_tanda_tangan_petisi', 'desc')
                 ->groupBy('tanda_tangan_petisi.petisi_id');        
    }
}
