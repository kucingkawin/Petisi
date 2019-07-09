<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\KategoriPetisi;

class KategoriPetisiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('DELETE FROM kategori_petisi;');
        DB::statement('ALTER TABLE kategori_petisi AUTO_INCREMENT=1;');
        KategoriPetisi::create(['nama' => 'Pendidikan', 'deskripsi' => 'Kategori ini berhubungan dengan pendidikan.']);
        KategoriPetisi::create(['nama' => 'Politik', 'deskripsi' => 'Kategori ini berhubungan dengan politik.']);
        KategoriPetisi::create(['nama' => 'Kesehatan', 'deskripsi' => 'Kategori ini berhubungan dengan kesehatan.']);
        KategoriPetisi::create(['nama' => 'Masyarakat', 'deskripsi' => 'Kategori ini berhubungan dengan masyarakat.']);
        KategoriPetisi::create(['nama' => 'Lain-lain', 'deskripsi' => 'Kategori selain yang disediakan.']);
    }
}
