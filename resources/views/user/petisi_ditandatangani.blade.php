@extends('user.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Petisi Ditandatangani</div>

                <div class="card-body">
                    @if (session('notifikasi'))
                        <div class="alert alert-{{ session('notifikasi')['status'] }}" role="alert">
                            {{ session('notifikasi')['pesan'] }}
                        </div>
                    @endif

                    @if (count($petisi) == 0)
                        <p>Belum ada petisi yang ditandatangani. <a href="{{ route('user.lihatPetisi') }}">Mulai mencari petisi</a>.</p>
                    @endif

                    @if (count($petisi) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Konten</th>
                                    <th>Dibuat</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($petisi as $satuPetisi)
                                    <tr>
                                        <td>{{ $satuPetisi->judul }}</td>
                                        <td>{{ strlen($satuPetisi->konten) > 100 ? substr($satuPetisi->konten, 0, 100) . '...' : $satuPetisi->konten}}</td>
                                        <td>{{ $satuPetisi->created_at }}</td>
                                        <td>
                                            <a class="btn-sm btn-primary" href="{{ route('user.detailPetisi', ['id' => $satuPetisi->id]) }}">Lihat</a>
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
