@extends('user.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Petisi Saya</div>

                <div class="card-body">
                    @if (session('notifikasi'))
                        <div class="alert alert-{{ session('notifikasi')['status'] }}" role="alert">
                            {{ session('notifikasi')['pesan'] }}
                        </div>
                    @endif

                    @if (count($petisi) == 0)
                        <p>Belum ada petisi yang dibuat. Silakan membuat petisi terlebih dahulu.</p>
                    @endif

                    <p><a href="{{ route('user.modifikasiPetisi', ['tipe' => 'buat']) }}" class="btn btn-primary">Buat Petisi</a></p>

                    @if (count($petisi) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Konten</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($petisi as $satuPetisi)
                                    <tr>
                                        <td>{{ $satuPetisi->judul }}</td>
                                        <td>{{ strlen($satuPetisi->konten) > 100 ? substr($satuPetisi->konten, 0, 100) . '...' : $satuPetisi->konten}}</td>
                                        <td>
                                            <a class="btn-sm btn-success" href="{{ route('user.detailPetisi', ['id' => $satuPetisi->id]) }}">Lihat</a>
                                            <a class="btn-sm btn-warning" href="{{ route('user.modifikasiPetisi', ['tipe' => 'ubah', 'id' => $satuPetisi->id]) }}">Ubah</a>
                                            <a class="btn-sm btn-danger" href="{{ route('user.modifikasiPetisi', ['tipe' => 'hapus', 'id' => $satuPetisi->id]) }}">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
