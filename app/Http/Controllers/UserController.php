<?php

namespace App\Http\Controllers;

use App\Petisi;
use App\KomentarPetisi;
use App\TandaTanganPetisi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //Dapatkan banyak data petisi yang telah ditandatangani dari setiap akun.
        $banyakPetisiDitandatangani = Petisi::viewDitandatanganiTable(true)
                                            ->where('tanda_tangan_petisi.user_detail_id', '=', $request->user()->userDetail->id)
                                            ->get();
        
        //Dapatkan banyak data petisi yang telah dikomentari dari setiap akun.
        $banyakPetisiSaya = Petisi::viewTable(true)
                                  ->where('user_id', '=', $request->user()->id)
                                  ->get();

        //Dapatkan banyak data petisi yang telah dikomentari dari setiap akun.
        $banyakKomentar = Petisi::viewDikomentariTable(true)
                                ->where('user_detail_id', '=', $request->user()->userDetail->id)
                                ->get();

        //Dapatkan 3 data komentator tertinggi.
        $komentatorTertinggi = Petisi::viewKomentatorTerbanyakTable()->limit(3)->get();

        //Dapatkan 3 data petisi tertinggi.
        $petisiTertinggi = Petisi::viewPetisiTerbanyakTable()->limit(3)->get();

        //Return view.
        return view('user.index', compact('komentatorTertinggi', 'petisiTertinggi', 'banyakPetisiDitandatangani', 'banyakPetisiSaya', 'banyakKomentar'));
    }

    public function lihatPetisi()
    {
        //Dapatkan data petisi terlebih dahulu.
        $petisi = Petisi::viewTable()->get();

        //Masukan ke viewnya.
        return view('user.lihat_petisi', compact('petisi'));
    }

    public function detailPetisi(Request $request)
    {
        //Id petisi.
        $idPetisi = $request->input('id');

        //Cek keberadaan parameter id petisi.
        if(empty($idPetisi))
            return redirect(route('user.lihatPetisi'))->with('notifikasi', ['status' => 'danger', 'pesan' => 'Id petisi tidak ditemukan.']);
        
        //Dapatkan data petisi berdasarkan id petisi.
        $petisi = Petisi::viewTable()->where('petisi.id', '=', $idPetisi)->first();

        //Dapatkan banyak tanda tangan petisi suatu petisi.
        $banyakTandaTanganPetisi = DB::table('tanda_tangan_petisi')
                                     ->select(DB::raw('COUNT(*) as nilai'))
                                     ->where('petisi_id', '=', $idPetisi)->first();                         

        //Cek apakah petisi sudah ditandatangani.
        $userTandaTanganPetisi = TandaTanganPetisi::where('user_detail_id', '=', $request->user()->userDetail->id)
                                                  ->where('petisi_id', '=', $idPetisi)
                                                  ->first();

        //Masukan ke viewnya.
        return view('user.detail_petisi', compact('petisi', 'banyakTandaTanganPetisi', 'userTandaTanganPetisi'));
    }

    public function postTandatanganiPetisi(Request $request)
    {
        //Id petisi.
        $idPetisi = $request->input('id');

        //Id user detail.
        $idUserDetail = $request->user()->userDetail->id;

        //Cek apakah petisi sudah ditandatangani.
        $userTandaTanganPetisi = TandaTanganPetisi::where('user_detail_id', '=', $request->user()->userDetail->id)
                                                  ->where('petisi_id', '=', $idPetisi)
                                                  ->first();
                                                
        //Pesan
        $pesan = 'Belum ada.';

        //Kalau kosong segera tambahkan kesitu.
        if(empty($userTandaTanganPetisi))
        {
            TandaTanganPetisi::create([
                'petisi_id' => $idPetisi,
                'user_detail_id' => $idUserDetail
            ]);

            $pesan = 'Petisi berhasil ditandatangani.';
        }
        else 
        {
            //Hapus dari daftar petisi ditandatangani.
            $userTandaTanganPetisi->delete();

            $pesan = 'Petisi berhasil dibatalkan tanda tangannya.';
        }

        return redirect(route('user.detailPetisi', ['id' => $idPetisi]))->with('notifikasi', ['status' => 'info', 'pesan' => $pesan]);
    }

    public function postKomentarPetisi(Request $request)
    {
        //Lakukan validasi terlebih dahulu.
        $request->validate([
            'komentar' => 'required'
        ]);        

        //Id petisi.
        $idPetisi = $request->input('id');

        //Id user detail.
        $idUserDetail = $request->user()->userDetail->id;

        //Komentar petisi.
        KomentarPetisi::create([
            'petisi_id' => $idPetisi,
            'user_detail_id' => $idUserDetail,
            'komentar' => $request->input('komentar')
        ]);

        //Segera redirect.
        return redirect(route('user.detailPetisi', ['id' => $idPetisi]))->with('notifikasi', ['status' => 'info', 'pesan' => 'Komentar berhasil ditambah.']);
    }

    public function petisiSaya(Request $request)
    {
        //Dapatkan data petisi terlebih dahulu berdasarkan id pembuatnya.
        $petisi = Petisi::where('user_id', '=', $request->user()->id)->get();

        //Masukan ke viewnya.
        return view('user.petisi_saya', compact('petisi'));
    }

    public function petisiDitandatangani(Request $request)
    {
        //Dapatkan data petisi yang telah ditandatangani
        $petisi = Petisi::viewDitandatanganiTable()
                        ->where('tanda_tangan_petisi.user_detail_id', '=', $request->user()->userDetail->id)
                        ->get(); 

        //Masukan ke viewnya.
        return view('user.petisi_ditandatangani', compact('petisi'));
    }

    public function petisiDikomentari(Request $request)
    {
        //Dapatkan data petisi komentar yang telah ditandatangani
        $petisiDikomentari = Petisi::viewDikomentariTable()
                                    ->where('komentar_petisi.user_detail_id', '=', $request->user()->userDetail->id)
                                    ->get(); 
        
        //Masukan ke viewnya.
        return view('user.petisi_dikomentari', compact('petisiDikomentari'));
    }

    public function modifikasiPetisi(Request $request)
    {       
        //Dapatkan query string tipe modifikasi.
        $tipeModifikasi = $request->input('tipe');

        //Jika tipenya adalah ubah/hapus, maka segera dieksekusi.
        if($tipeModifikasi == "ubah" || $tipeModifikasi == "hapus")
        {
            //Id petisi.
            $idPetisi = $request->input('id');
            
            //Jika tidak ada id petisi, beritahu.
            if(empty($idPetisi))
                return redirect(route('user.petisiSaya'))->with('notifikasi', ['status' => 'danger', 'pesan' => 'Id petisi tidak ditemukan.']);
            
            //Petisi berdasarkan id.
            $petisi = Petisi::find($idPetisi);

            //Cek ditemukan atau tidaknya.
            if(empty($petisi))
                return redirect(route('user.petisiSaya'))->with('notifikasi', ['status' => 'danger', 'pesan' => 'Petisi tidak ditemukan.']);

            if($tipeModifikasi == "hapus")
            {
                Storage::delete($petisi->gambar);
                $petisi->delete();
                return redirect(route('user.petisiSaya'))->with('notifikasi', ['status' => 'success', 'pesan' => 'Petisi berhasil dihapus.']);
            }
            else if($tipeModifikasi == "ubah")
            {
                return view('user.modifikasi_petisi', compact('tipeModifikasi', 'petisi'));
            }
        }

        return view('user.modifikasi_petisi', compact('tipeModifikasi'));
    }

    public function postModifikasiPetisi(Request $request)
    {         
        //Dapatkan query string tipe modifikasi.
        $tipeModifikasi = $request->input('tipe');
        
        //Lakukan validasi terlebih dahulu.
        $request->validate([
            'kategori' => 'required',
            'judul' => 'required',
            'konten' => 'required',
            'gambar' => 'image|' . ($tipeModifikasi == "buat" ? 'required|' : '') . 'dimensions:min_width=300,min_height=300'
        ]);

        //Cek tipe modifikasi.
        if($tipeModifikasi == "buat")
        {
            //Dapatkan file gambar.
            $fileGambar = $request->file('gambar');

            //Ini adalah path tempat file diupload.
            $pathFileGambar = $fileGambar->store('public/files/gambar-petisi');

            //Buat petisi.
            Petisi::create([
                'user_id' => $request->user()->id,
                'kategori_petisi_id' => $request->input('kategori'),
                'judul' => $request->input('judul'),
                'konten' => $request->input('konten'),
                'gambar' => $pathFileGambar,
            ]);

            //Redirect ke bagian 'Petisi Saya' serta tinggalkan session flash notifikasi.
            return redirect(route('user.petisiSaya'))->with('notifikasi', ['status' => 'success', 'pesan' => 'Petisi berhasil ditambahkan.']);
        }
        else if($tipeModifikasi == "ubah")
        {
            //Dapatkan query string id petisi.
            $idPetisi = $request->input('id');

            //Cek apakah ada parameter atau tidak, jika tidak ada maka beritahu.
            if(empty($idPetisi))
                return "Tidak ada parameter id petisi.";
            
            //Cari petisi yang ingin diubah berdasarkan id dan ubah sementara judul dan konten.
            $petisi = Petisi::find($idPetisi);
            $petisi->judul = $request->input('judul');
            $petisi->konten = $request->input('konten');

            //Buat variabel untuk memasukkan path file gambar sementara.
            $pathFileGambarLama = $petisi->gambar;
            
            //Cek apakah ada perubahan terhadap gambar.
            //Jika iya, maka segera upload dan modifikasi data gambarnya.
            $fileGambar = $request->file('gambar');
            $fileGambarDiupload = !empty($fileGambar);

            if($fileGambarDiupload)
            {
                $pathFileGambar = $fileGambar->store('public/files/gambar-petisi');
                $petisi->gambar = $pathFileGambar;
            }

            //Simpan perubahannya.
            $petisi->save();

            //Jika berhasil diubah dan ada perubahan pada gambar, segera hapus gambar lamanya.
            if($fileGambarDiupload)
                Storage::delete($pathFileGambarLama);

            //Redirect ke bagian 'Petisi Saya' serta tinggalkan session flash notifikasi.
            return redirect(route('user.petisiSaya'))->with('notifikasi', ['status' => 'success', 'pesan' => 'Petisi berhasil diubah.']);
        }
    }
}
